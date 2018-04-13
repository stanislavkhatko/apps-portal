<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 3/21/2018
 * Time: 5:38 PM
 */

namespace App\Services\LogRecorders;


interface LogRecorder
{
    public function alert($message);

    public function debug($message);
}