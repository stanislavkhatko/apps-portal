<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 4/2/2018
 * Time: 10:43 PM
 */

namespace App\Services\ContentLoaders;

use App\Models\ContentItem;
use Illuminate\Http\Request;

abstract class ContentLoader
{
    abstract public function update(Request $request, $id);

    abstract public function store(Request $request);

    abstract public function delete(ContentItem $contentItem);
}