<?php

class Comparator {

    public static function compare_string($string1, $string2){
        return strcmp ($string1, $string2);
    }

    public static function compare_file($filepath1, $filepath2, &$cmpoutput = NULL)
    {
        $exec = "cmp --quiet $filepath1 $filepath2";
	sprintf("%s\n", $exec);
        if (!defined("EVALUATOR_DEBUG")) $comparelastline = exec($exec." 2>&1", $cmpoutput, $retval);
        return ($retval == 0);
    }
}
