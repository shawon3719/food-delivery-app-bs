<?php


namespace App\Services\Media;

use App\Data\Constants;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaService
{



    public function storeImage($directory, $image)
    {
        return  Storage::disk(Constants::DISK_NAME_CHAT_ATTACHMENT)->put($directory,$image);

    }

    public function destroyImage($directory, $name)
    {
        return Storage::disk('publicImage')->delete($directory. '/' . $name);
    }

    public function getImageUrl($name)
    {
        return env('APP_SERVER_DOMAIN_STORAGE_PATH') . '/storage/uploads/' . $name;
    }

   

}
