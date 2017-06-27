<?php

namespace TKr\PassGen;

class Verify
{
    public static function verify($string)
    {
        return self::containsNumbers($string) &&
            self::containsLowerChars($string) &&
            self::containsUpperChars($string) &&
            self::containsSpecialChars($string);
    }

    public static function containsNumbers($string)
    {
        return preg_match('/[0-9]+/', $string) > 0;
    }

    public static function containsLowerChars($string)
    {
        return preg_match('/[a-z]+/', $string) > 0;
    }

    public static function containsUpperChars($string)
    {
        return preg_match('/[A-Z]+/', $string) > 0;
    }

    public static function containsSpecialChars($string)
    {
        return preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $string) > 0;
    }
}
