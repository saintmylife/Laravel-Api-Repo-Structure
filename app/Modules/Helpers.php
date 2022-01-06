<?php

if (!function_exists('num2alpha')) {
    /**
     * Convert an integer to a string of uppercase letters (A-Z, AA-ZZ, AAA-ZZZ, etc.)
     * @param  $number
     * @return string of uppercase letters
     */
    function num2alpha($number)
    {
        for($result = ""; $number >= 0; $number = intval($number / 26) - 1)
            $result = chr($number%26 + 0x41) . $result;
        return $result;
    }
}

if (!function_exists('alpha2num')) {
    /**
     * Convert a string of uppercase letters to an integer.
     * @param $alpha
     * @return $number
     */
    function alpha2num($alpha)
    {
        $length = strlen($alpha);
        $number = 0;
        for($i = 0; $i < $length; $i++)
            $number = $number*26 + ord($alpha[$i]) - 0x40;
        return $number-1;
    }
}
