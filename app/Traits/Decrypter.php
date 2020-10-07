<?php
/**
 * Created by PhpStorm.
 * User: rifat
 * Date: 3/15/19
 * Time: 9:31 PM
 */

namespace App\Traits;


trait Decrypter
{
    /**
     * Decryptor
     *
     * @param $encrypted_string
     * @return mixed
     */
    public function decrypt($encrypted_string)
    {
        try{
            $decrypt_value = $this->decrypt($encrypted_string);
        }catch (\Exception $ex){
            abort(404);
        }
        return $decrypt_value;
    }
}