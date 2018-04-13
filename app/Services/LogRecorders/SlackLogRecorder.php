<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 3/21/2018
 * Time: 5:31 PM
 */

namespace App\Services\LogRecorders;

use Illuminate\Support\Facades\Log;

final class SlackLogRecorder implements LogRecorder
{

    public function alert($message)
    {
        if(config('logging.slack_alert')){
            $message = $this->modifyMessage($message, debug_backtrace());
            Log::alert($message);
        }
    }

    public function debug($message)
    {
        $debugTrace = debug_backtrace();
        $logNeeded = $this->checkLogNeed($debugTrace);
        if ($logNeeded) {
            $message = $this->modifyMessage($message, $debugTrace);
            Log::debug($message);
        }
    }

    #region SERVICE METHODS
    private function checkLogNeed($debugTrace)
    {
        $debugLogger = config('logging.slack_debug');
        $neededFile = config('logging.slack_debug_file');
        if($debugLogger && $neededFile){
            $calledFile = $debugTrace[1]['file'];
            $logNeeded = $this->compareFileNames($calledFile, $neededFile);
            return $logNeeded;
        }elseif($debugLogger){
            return true;
        }else{
            return false;
        }
    }

    private function compareFileNames($calledFile, $neededFile)
    {
        if(strtolower(basename($calledFile)) == strtolower(basename($neededFile))){
            return true;
        }else{
            return false;
        }

    }

    private function modifyMessage($message, $debugTrace)
    {
        if(is_array($message)){
            return array_merge(['source'=>substr(realpath($debugTrace[1]['file']),-45)], $message);
        }else{
            return [
                'source'=>substr(realpath($debugTrace[1]['file']),-45),
                'message'=>$message
            ];
        }
    }
    #endregion
}