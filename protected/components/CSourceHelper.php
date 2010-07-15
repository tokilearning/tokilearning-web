<?php

class CSourceHelper {

    public static function getSourceExtension($filename){
        if (($pos = strrpos($filename, '.')) !== false) {
            $ext = strtolower(substr($filename, $pos + 1));
            return $ext;
        }
        return null;
    }   

//    public static function getSourceType($filename) {
//        static $extensions;
//        if ($extensions === null){
//
//        }
//        if (($pos = strrpos($file, '.')) !== false) {
//            $ext = strtolower(substr($file, $pos + 1));
//            if (isset($extensions[$ext]))
//                return $extensions[$ext];
//        }
//        return null;
//    }

}