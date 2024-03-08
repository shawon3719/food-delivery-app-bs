<?php

namespace App\Http\Controllers\API\V1;

use App\Data\Constants;
use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Services\Media\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function uploadAvatar(Request $request)
    {

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            $mediaService = new MediaService();

            $filePath =  $mediaService->storeImage('avatar', $avatar);

            $user = Auth::user();
            if ($user) {
                
                if(Avatar::where('user_id', $user->id)->exists()){
                    $avatarModel = Avatar::where('user_id', $user->id)->first();
                }else{
                    $avatarModel =  new Avatar();
                }

                $avatarModel->url =$filePath;
                $avatarModel->user_id = $user->id;
                $avatarModel->created_by = $user->id;
                $avatarModel->save();
            }

            // Return the URL of the uploaded avatar
            return response()->json([
                'imageUrl' => $mediaService->getAvatarImageUrl($filePath), // Use Storage::url() to get the full public URL
            ]);
        }

        return response()->json(['message' => 'Avatar not found'], 400);
    }
}
