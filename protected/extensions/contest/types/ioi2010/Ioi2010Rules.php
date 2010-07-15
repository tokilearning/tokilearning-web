<?php

class Ioi2010Rules {

    private static function getUnixTimestamp($Time) {
        list($date , $time) = explode(' ' , $Time);
        list($h , $m , $s) = explode(':' , $time);
        list($Y , $M , $D) = explode('-' , $date);
        return mktime($h , $m , $s , $M , $D , $Y);
    }

    public static function getAvailableTokens($contest , $submitter , $problem) {
        if ($contest == null)
            return 0;
        $c = new CDbCriteria();
        $c->condition = 'submitter_id = ' . $submitter->id . ' AND contest_id = ' . $contest->id . ' AND problem_id = ' . $problem->id;
        $subs = Submission::model()->findAll($c);
        $count = 0;
        $time = time();
        //echo $time - 30 * 6 . "<br />";
        foreach ($subs as $sub) {
            //echo self::getUnixTimestamp($sub->submitted_time) . "<br />";
            if ($sub->getSubmitContent('fullfeedback') !== null && self::getUnixTimestamp($sub->submitted_time) >= $time - 30 * 60)
                $count++;
        }

        if (2 - $count >= 0)
            return 2 - $count;
        else
            return 0;
    }
}