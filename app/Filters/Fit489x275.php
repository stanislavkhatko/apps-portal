<?php
/**
 * Created by PhpStorm.
 * User: skhatko
 * Date: 5/29/18
 * Time: 21:48
 */

namespace App\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Fit489x275 implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(489, 275);
    }
}