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


    public static function parseHtmlContent($html, $path = 'articles') {

        preg_match_all('/<img[^>]+>/i', $html, $imgTags);
        for ($i = 0; $i < count($imgTags[0]); $i++) {
            preg_match('/src="([^"]+)/i', $imgTags[0][$i], $imgage);
            $imagePath = str_ireplace( 'src="', '', $imgage[0]);
            $imagePathExploded = parse_url($imagePath);

            if (!empty($imagePathExploded['path'])) {
                if (str_starts_with($imagePathExploded['path'],'/')) {
                    $imagePathExploded['path'] = preg_replace('/\//', '', $imagePathExploded['path'], 1);
                }
                $upload = Upload::where('path', $imagePathExploded['path'])->first();
                if ($upload) {
                    self::setUploadPath($upload, $path);
                    $upload->refresh();
                    $imageNewPath = Storage::disk('s3')->temporaryUrl($upload->path, now()->addDay(2));

                    $html = str_replace($imagePath, $imageNewPath, $html);
                }

            }
        }

        return $html;
    }


    public static function uploadBase64($base64, $dir = 'temp')
    {
        $fileName = uniqid(rand()).'.png';
        $filePath = $dir.'/'.$fileName;
        $path = Storage::disk('s3')->put($filePath, base64_decode($base64));

        $input = [
            'extension' => 'png',
            'name' => $fileName,
            'mime' => 'image/png',
            'size' => 0,
            'path' => $filePath
        ];

        $upload = UploadService::create($input);

        $hashName = md5($upload->path . $upload->id);
        $upload->update(['hash_name' => $hashName]);

        return $upload;
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
