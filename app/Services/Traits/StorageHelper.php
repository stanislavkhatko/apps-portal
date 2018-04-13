<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 4/4/2018
 * Time: 3:08 PM
 */

namespace App\Services\Traits;


trait StorageHelper
{

    protected function findFile(array $filesArray, string $fileName)
    {
        $clearFileNames = $this->getCleanNames($filesArray);

        $fileKey = array_search($fileName, $clearFileNames);

        if($fileKey !== false){
            return $filesArray[$fileKey];
        }

        return false;

    }

    protected function getCleanNames(array $filesArray)
    {
        $cleanNamesArray = null;
        foreach ($filesArray AS $fileName){
            $cleanNamesArray[] = pathinfo($fileName,PATHINFO_FILENAME);
        }
        return $cleanNamesArray;
    }
}