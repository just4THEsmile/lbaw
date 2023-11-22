<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    static $default = 'NcIkXUq1IpkhshOeSYHMyDmX6u0q7Deku5FNMiWv.png';
    static $diskName = 'ImagesStorer';

    static $systemTypes = [
        'profile' => ['png', 'jpg', 'jpeg'],
    ];
    private static function isValidType(String $type) {
        return array_key_exists($type, self::$systemTypes);
    }
    
    private static function defaultAsset(String $type) {
        return asset($type . '/' . self::$default);
    }
    
    private static function getFileName (String $type, int $user_id) {
            
        $fileName = null;
        switch($type) {
            case 'profile':
                $fileName = User::find($user_id)->profilepicture;
                break;
            }
    
        return $fileName;
    }
    
    static function get(String $type, int $userId) {
    
        // Validation: upload type
        if (!self::isValidType($type)) {
            return self::defaultAsset($type);
        }
    
        // Validation: file exists
        $fileName = self::getFileName($type, $userId);
        if ($fileName) {
            return asset($type . '/' . $fileName);
        }
    
        // Not found: returns default asset
        return self::defaultAsset($type);
    }

    function upload(Request $request) {


        // Validation: has file
        if (!$request->hasFile('profilepicture')) {
            return redirect()->back()->with('error', 'Error: File not found');
        }

        // Validation: upload type
        if (!$this->isValidType($request->type)) {
            return redirect()->back()->with('error', 'Error: Unsupported upload type');
        }

        // Validation: upload extension
        $file = $request->file('profilepicture');

        // Prevent existing old files
        $type = $request->type;
        $this->delete($type, $request->user_id);

        // Generate unique filename
        $fileName = $file->hashName();
        
        // Validation: model
        $error = null;

        $user = User::findOrFail($request->user_id);
        if ($user) {
            $user->profilepicture = $fileName;
            $user->save();
        } else {
            $error = "unknown user";
        }

        if ($error) {
            redirect()->back()->with('error', `Error: {$error}`);
        }

        $file->storeAs($type, $fileName, self::$diskName);
        return redirect()->back()->with('success', 'Success: upload completed!');

    }
    

    private static function delete(String $type, int $user_id) {
        $existingFileName = self::getFileName($type, $user_id);
    
        if ($existingFileName && $existingFileName !== self::$default) {
            Storage::disk(self::$diskName)->delete($type . '/' . $existingFileName);
    
            switch($type) {
                case 'profile':
                    User::find($user_id)->profilepicture = null;
                    break;
            }
        }
    }

    
}
