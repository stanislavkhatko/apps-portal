<?php
/**
 * Created by PhpStorm.
 * User: Work
 * Date: 4/2/2018
 * Time: 10:44 PM
 */

namespace App\Services\ContentLoaders;

use App\Services\Traits\StorageHelper;
use Illuminate\Support\Facades\Storage;
use App\Services\Facades\LogRec;
use Illuminate\Http\Request;
use App\Models\ContentItem;
use App\Services\Facades\ContentLoader;

final class LocalContentLoader extends ContentLoader
{
    use StorageHelper;

    #region MAIN METHODS
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $contentItem = ContentItem::find($id);
        #region LOGREC
        LogRec::debug([
            'process' => 'updating content item',
            'description' => 'Content Item from DB',
            'contentItem' => $contentItem->toArray(),
            'request' => $request->all()
        ]);
        #endregion
        $contentDeleted = false;
        $imageDeleted = false;

        //image
        $imageInputLink = basename($request->input('contentItem')['preview']);
        if (Storage::disk('temp')->exists($imageInputLink)) {

            #region LOGREC
            LogRec::debug([
                'process' => 'updating image file'
            ]);
            #endregion

            $this->deleteOldImageFile(basename($contentItem->preview));
            $imageDeleted = true;
        }

        //content
        $contentInputLink = basename($request->input('contentItem')['download']['link']);
        if (Storage::disk('temp')->exists($contentInputLink)) {

            #region LOGREC
            LogRec::debug([
                'process' => 'updating content file',
                'DB_content_link' => basename($contentItem->download['link']),
                'INPUT_content_link' => $contentInputLink
            ]);
            #endregion

            $this->deleteOldContentFile(basename($contentItem->download['link']));
            $contentDeleted = true;
        }

        $input = $request->except(['preview', 'download']);
        $contentItem->fill($input);

        #region LOGREC
        LogRec::debug([
            'description' => 'contentItem after request update',
            'contentItem' => $contentItem->toArray()
        ]);
        #endregion

        if ($imageDeleted === true) {
            $contentItem->preview = $this->moveToImagesFolder($request, $contentItem->id);
        }

        if ($contentDeleted === true) {
            $contentItem->download = $this->moveToContentFolder($request, $contentItem->id);
        }

        #region LOGREC
        LogRec::debug([
            'description' => 'contentItem after moving files',
            'contentItem' => $contentItem->toArray()
        ]);
        #endregion
        $contentItem->type = 'upload';
        $contentItem->save();

        return response()->json(['success' => true, 'contentItem' => $contentItem]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $contentItem = new ContentItem();
        $contentItem->fill($request->get('contentItem'));
        $contentItem->save();

        if($contentItem->type !== 'reference') {
            $contentItem->preview = $this->moveToImagesFolder($request, $contentItem->id);
            $contentItem->download = $this->moveToContentFolder($request, $contentItem->id);
        } else {
            $contentItem->preview = $this->moveToImagesFolder($request, $contentItem->id);
        }

        $this->deleteTempFolder();

        return response()->json(['success' => true, 'contentItem' => $contentItem]);
    }

    public function delete(ContentItem $contentItem)
    {
        $imageFiles = Storage::disk('images')->files();
        if(count($imageFiles)>0){
            $image = $this->findFile($imageFiles, $contentItem->id);
            if($image !== false){
                Storage::disk('images')->delete($image);
            }
        }

        $contentFiles = Storage::disk('content')->files();
        if(count($contentFiles)>0){
            $content = $this->findFile($contentFiles, $contentItem->id);
            if($content !== false){
                Storage::disk('content')->delete($content);
            }
        }
    }
    #endregion

    #region SERVICE METHODS
    private function moveToImagesFolder($request, $newFileName)
    {
        $DS = DIRECTORY_SEPARATOR;
        $file = basename($request->input('contentItem')['preview']);
        $fileExtension = pathinfo($file,PATHINFO_EXTENSION);

        $path = 'temp'.$DS.$file;
        Storage::disk('public')->move($path, 'images'.$DS.$newFileName.'.'.$fileExtension);
        return Storage::disk('images')->url($newFileName.'.'.$fileExtension);
    }

    private function moveToContentFolder($request, $newFileName)
    {
        $DS = DIRECTORY_SEPARATOR;
        $file = basename($request->input('contentItem')['download']['link']);

        $fileExtension = pathinfo($file,PATHINFO_EXTENSION);

        $path = 'temp'.$DS.$file;

        Storage::disk('public')->move($path, 'content'.$DS.$newFileName.'.'.$fileExtension);

        $storageDirectory = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $fullPath = $storageDirectory.'public'.$DS.'content'.$DS.$newFileName.'.'.$fileExtension;
        return [
            'link'=>$fullPath
        ];
    }

    private function deleteTempFolder()
    {
        $chance = rand(0,10);
        if($chance === 1){
            Storage::disk('local')->deleteDirectory('\public\temp');
        }
    }

    private function deleteOldImageFile($imageFile)
    {
        #region LOGREC
        LogRec::debug([
            'process'=>'deleting file '. $imageFile
        ]);
        #endregion

        Storage::disk('images')->delete($imageFile);
    }

    private function deleteOldContentFile($contentFile)
    {
        #region LOGREC
        LogRec::debug([
            'process'=>'deleting file '. $contentFile
        ]);
        #endregion

        Storage::disk('content')->delete($contentFile);
    }
    #endregion
}