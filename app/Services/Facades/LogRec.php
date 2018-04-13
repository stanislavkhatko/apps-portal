<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 3/21/2018
 * Time: 5:56 PM
 */

namespace App\Services\Facades;


use Illuminate\Support\Facades\Facade;

class LogRec extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LogRec';
    }
}