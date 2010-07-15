<?php

class CDateHelper {

    /**
     * Returns time difference between two timestamps, in human readable format.
     *
     * @param   integer       timestamp
     * @param   integer       timestamp, defaults to the current time
     * @param   string        formatting string
     * @return  string|array
     */
    public static function timespan($time1, $time2 = NULL, $output = 'years,months,weeks,days,hours,minutes,seconds') {
        // Array with the output formats
        $output = preg_split('/[^a-z]+/', strtolower((string) $output));

        // Invalid output
        if (empty($output))
            return FALSE;

        // Make the output values into keys
        extract(array_flip($output), EXTR_SKIP);

        // Default values
        $time1 = max(0, (int) $time1);
        $time2 = empty($time2) ? time() : max(0, (int) $time2);

        // Calculate timespan (seconds)
        $timespan = abs($time1 - $time2);

        // All values found using Google Calculator.
        // Years and months do not match the formula exactly, due to leap years.
        // Years ago, 60 * 60 * 24 * 365
        isset($years) and $timespan -= 31556926 * ($years = (int) floor($timespan / 31556926));

        // Months ago, 60 * 60 * 24 * 30
        isset($months) and $timespan -= 2629744 * ($months = (int) floor($timespan / 2629743.83));

        // Weeks ago, 60 * 60 * 24 * 7
        isset($weeks) and $timespan -= 604800 * ($weeks = (int) floor($timespan / 604800));

        // Days ago, 60 * 60 * 24
        isset($days) and $timespan -= 86400 * ($days = (int) floor($timespan / 86400));

        // Hours ago, 60 * 60
        isset($hours) and $timespan -= 3600 * ($hours = (int) floor($timespan / 3600));

        // Minutes ago, 60
        isset($minutes) and $timespan -= 60 * ($minutes = (int) floor($timespan / 60));

        // Seconds ago, 1
        isset($seconds) and $seconds = $timespan;

        // Remove the variables that cannot be accessed
        unset($timespan, $time1, $time2);

        // Deny access to these variables
        $deny = array_flip(array('deny', 'key', 'difference', 'output'));

        // Return the difference
        $difference = array();
        foreach ($output as $key) {
            if (isset($$key) AND !isset($deny[$key])) {
                // Add requested key to the output
                $difference[$key] = $$key;
            }
        }

        // Invalid output formats string
        if (empty($difference))
            return FALSE;

        // If only one output format was asked, don't put it in an array
        if (count($difference) === 1)
            return current($difference);

        // Return array
        return $difference;
    }

    /**
     * Returns time difference between two timestamps, in the format:
     * N year, N months, N weeks, N days, N hours, N minutes, and N seconds ago
     *
     * @param   integer       timestamp
     * @param   integer       timestamp, defaults to the current time
     * @param   string        formatting string
     * @return  string
     */
    public static function timespan_string($time1, $time2 = NULL, $output = 'years,months,weeks,days,hours,minutes,seconds') {
        if ($difference = self::timespan($time1, $time2, $output) AND is_array($difference)) {
            // Determine the key of the last item in the array
            $last = end($difference);
            $last = key($difference);

            $span = array();
            foreach ($difference as $name => $amount) {
                if ($name !== $last AND $amount === 0) {
                    // Skip empty amounts
                    continue;
                }

                // Add the amount to the span
                $span[] = ($name === $last ? ' and ' : ', ') . $amount . ' ' . ($amount === 1 ? CInflectorHelper::singular($name) : $name);
            }

            // Replace difference by making the span into a string
            $difference = trim(implode('', $span), ',');
        } elseif (is_int($difference)) {
            // Single-value return
            $difference = $difference . ' ' . ($difference === 1 ? CInflectorHelper::singular($output) : $output);
        }

        return $difference;
    }

    public static function timespan_string2($time1, $time2 = NULL, $output = 'years,months,weeks,days,hours,minutes,seconds') {
    //public static function timespan_string2($time1, $time2 = NULL, $output = 'tahun,bulan,minggu,hari,jam,menit,detik') {
        if ($difference = self::timespan($time1, $time2, $output) AND is_array($difference)) {
            // Determine the key of the last item in the array
            $last = end($difference);
            $last = key($difference);

            $span = array();
            $i = 2;
            foreach ($difference as $name => $amount) {
                if ($name !== $last AND $amount === 0) {
                    // Skip empty amounts
                    continue;
                }
                if ($i == 0){
                    break;
                }
                $i--;
                // Add the amount to the span
                $span[] = ($name === $last ? ' ' : ' ') . $amount . ' ' . ($name);
            }

            // Replace difference by making the span into a string
            $difference = trim(implode('', $span), '');
        } elseif (is_int($difference)) {
            // Single-value return
            $difference = $difference . ' ' . ($difference === 1 ? ($output) : $output);
        }
        //TODO: Optimize this
        $difference = str_replace('years', Yii::t('labels', 'tahun'), $difference);
        $difference = str_replace('months', Yii::t('labels', 'bulan'), $difference);
        $difference = str_replace('weeks', Yii::t('labels', 'minggu'), $difference);
        $difference = str_replace('days', Yii::t('labels', 'hari'), $difference);
        $difference = str_replace('hours', Yii::t('labels', 'jam'), $difference);
        $difference = str_replace('minutes', Yii::t('labels', 'menit'), $difference);
        $difference = str_replace('seconds', Yii::t('labels', 'detik'), $difference);
        return $difference;
    }

    public static function timespanAbbr($time){
        //<abbr title="\'.$data->questioned_time.\'">\'.(($data->questioned_time == \'0000-00-00 00:00:00\')? \'never\' : CDateHelper::timespan_string2(strtotime($data->questioned_time)).\' ago\').\'</abbr>\''
        $t = strtotime($time);
        $l = ($t > time())? Yii::t('labels', ' lagi') : (($t < time()) ? Yii::t('labels', ' lalu') : '');
        $date1 = ($time == null || $time == '0000-00-00 00:00:00')? 'n/a' : self::timespan_string2(strtotime($time)).$l;
        $date2 = ($time == null || $time == '0000-00-00 00:00:00')? 'n/a' : date("D d M Y H:i", strtotime($time));
        return "<abbr title='$date2'>$date1</abbr>";
    }

}