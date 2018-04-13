<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 4/3/2018
 * Time: 11:09 PM
 */

namespace App\Services\Facades;


use Illuminate\Support\Facades\Facade;

class CloudUploader extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CloudUploader';
    }
}