<?php

namespace TKr\PassGen;

class Verify
{
    public static function containsNumber($string)
    {
        return false !== self::strpos_array($string, ['1','2','3','4','5','6','7','8','9','0']);
    }

    public static function strpos_array($haystack, $needles)
    {
        if (is_array($needles)) {
            foreach ($needles as $str) {
                if (is_array($str)) {
                    $pos = strpos_array($haystack, $str);
                } else {
                    $pos = strpos($haystack, $str);
                }
                if ($pos !== false) {
                    return $pos;
                }
            }
        } else {
            return strpos($haystack, $needles);
        }

        return false;
    }
}
