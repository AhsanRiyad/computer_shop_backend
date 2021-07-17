<?php

namespace App\Http\Traits;

use DB;
use App\Transactions;
use App;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
// use Illuminate\Http\Request;

use Illuminate\Support\Str;


//a trait built by me for having common methods here
trait ImageUploadTrait
{

    function test(){
        return 'test trait';
    }


    function upload($tableName)
    {
        /*         unique:table,column,except,idColumn
                    The field under validation must not exist within the given database table.

                    Specifying A Custom Table / Column Name:

                    Instead of specifying the table name directly, you may specify the Eloquent model which should be used to determine the table name:

                    'email' => 'unique:App\User,email_address'
                    The column option may be used to specify the field's corresponding database column. If the column option is not specified, the field name will be used.

                    'email' => 'unique:users,email_address' 
        */
        /* $validatedData = request()->validate([
            'image' => ["unique:$modelReference,image"]
        ]); */


        //image compresser plugins / package
        //http://image.intervention.io/getting_started/installation#laravel


        /* Specifying A File Name
        If you would not like a file name to be automatically assigned to your stored file, you may use the storeAs method, which receives the path, the file name, and the (optional) disk as its arguments:
        */

        //pathname, filename, diskname
        //see the storage path in the fileconfig
        //image with custome name
        /* $path = request()->file('image')->storeAs(
            'food_image',
            request()->name,
            'local'
        ); */

/*
        $image = Image::make(request()->file('image'))->resize(200,null,function($constraint){
            $constraint->aspectRatio();
        })->encode('jpg', 80);*/


        $image = Image::make(request()->file('image'))->fit(200)->encode('jpg');
        $uuid = Str::uuid()->toString();
        $name = "storage/photo/$tableName/$uuid".".jpg";
        $path =  Storage::disk('public')->put($name, $image);
        return $name;

        //image with unique name


        // image with unique name
        // $path = request()->file('image')->store(
            // "storage/photo/$tableName" path name,
            // 'public' /*disk name*/
        // );
        // return $path;


        // You may also use the putFileAs method on the Storage facade, which will perform the same file manipulation as the example above:

        /* $path = Storage::putFileAs(
        'avatars', $request->file('avatar'), $request->user()->id
        ); */
    }

    function update_upload($tableName, $path){
        
        // $path_new = request()->file('image')->store(
            // "storage/photo/$tableName" /*path name*/,
            // 'public' /*disk name*/
        // );
        // return $path_new;

        // Storage::disk('public')->delete($path);
        // $path_new = request()->file('image')->store(
            // "storage/photo/$tableName" /*path name*/,
            // 'public' /*disk name*/
        // );
        // return $path_new;

        try{
            $image = Image::make(request()->file('image'))->fit(200)->encode('jpg');
            Storage::disk('public')->delete($path);
            $uuid = Str::uuid()->toString();
            $name = "storage/photo/$tableName/$uuid".".jpg";
            $path =  Storage::disk('public')->put($name, $image);
        }catch(Excepetion $e){
            $name = $path;
        }
        return $name;
    }
}
