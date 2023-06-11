<?php

namespace App\Services;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService
{

    public static function create($data): Model|Builder
    {
        return Upload::create($data);
    }


    public static function parseHtmlContent($html) {

        if (!trim($html)) {
            return '';
        }
        $doc = new \DOMDocument();
        $doc->loadHTML($html);
        $xml = simplexml_import_dom($doc);
        $images = $xml->xpath('//img');

        foreach ($images as $image) {
            $imagePath = $image['src'];
            $imagePathExploded = parse_url($imagePath);

            if (!empty($imagePathExploded['path'])) {
                if (str_starts_with($imagePathExploded['path'],'/')) {
                    $imagePathExploded['path'] = preg_replace('/\//', '', $imagePathExploded['path'], 1);
                }
                $upload = Upload::where('path', $imagePathExploded['path'])->first();
                if ($upload) {
                    self::setUploadPath($upload, 'articles');
                    $upload->refresh();
                    $image['src'] = Storage::disk('s3')->temporaryUrl($upload->path, now()->addDay(2));
                }

            }
        }

       return $xml->asXML();
    }


    /**
     * @param Model $upload
     * @param string $dir
     * @return string|null
     */
    public static function setUploadPath(Model $upload, string $dir): ?string
    {
        if (Str::contains($upload->path, 'temp/')) {
            $oldPath = $upload->path;
            if (Storage::disk('s3')->exists($oldPath)) {
                $newPath = Str::replaceFirst('temp', $dir, $oldPath);

                try {
                    if (Storage::disk('s3')->move($oldPath, $newPath)) {
                        $upload->path = $newPath;
                        $upload->save();
                        return $newPath;
                    }

                    return null;
                } catch (\Exception $ex) {
                    return null;
                }
            }
            return null;
        }

        return null;
    }
}
