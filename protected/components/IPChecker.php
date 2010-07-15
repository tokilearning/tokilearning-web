<?php

class IPChecker {

    public static function isInITB($ip = NULL) {
        $ip = (!isset($ip)) ? Yii::app()->request->userHostAddress : $ip;
        return self::matchIP($ip, "167.205.*");
    }

    public static function isLocal($ip = NULL) {
        $ip = (!isset($ip)) ? Yii::app()->request->userHostAddress : $ip;
        return self::matchIP($ip, "127.0.0.1") || self::matchIP($ip, "::1");
    }

    private static function matchIP($ip1, $ip2) {
        return (($ip1 === $ip2)||($pos = strpos($ip2, '*')) !== false && !strncmp($ip1, $ip2, $pos));
    }

}