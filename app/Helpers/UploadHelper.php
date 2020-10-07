<?php
/**
 * Created by IntelliJ IDEA.
 * User: rifat
 * Date: 7/26/18
 * Time: 11:26 PM
 */

namespace App\Helpers;


use Intervention\Image\Facades\Image;

class UploadHelper
{
    public function imagePath($image) : string
    {
        $full_path = null;
        if (is_file($image)){
            $img = Image::make($image);
            $img->resize(150,null,function ($constraint){
                $constraint->aspectRatio();
            });
            $full_path = public_path().'/uploads/drugs/'.str_random(40).'.'.$image->extension();
            $img->save($full_path);
        }
        return $full_path;
    }
}