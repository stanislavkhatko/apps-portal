<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 4/2/2018
 * Time: 10:53 PM
 */

namespace App\Services\Facades;


use Illuminate\Support\Facades\Facade;

class ContentLoader extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ContentLoader';
    }
}