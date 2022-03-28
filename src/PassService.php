<?php

namespace TKr;

use TKr\ShannonEntropy;

class PassService
{
    const BEGIN_END_LENGTH = 3;
    const MIN_PASSWORD_LENGTH = 8;
    const GENERATED_PASSWORD_LENGTH = 16;
    const GENERATED_TOKEN_LENGTH = 48;
    const ALLOWED_BEDIN_END = 'QWERTYUIPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm';
    const ALLOWED_CHARS = 'qwertyuiopasdfghjklzxcvbnm23456789QWERTYUIPASDFGHJKLZXCVBNM';
    const ALLOWED_SPECIAL = '@#$%&*+?:!.-[]~|{}';
    const ITERATIONS = 200;


    public function generateSecurePasswordString($length = self::GENERATED_PASSWORD_LENGTH, $special = false, $iterations = self::ITERATIONS)
    {
        $bestPass = '';
        $bestEntropy = 0;

        for ($i = 0; $i < $iterations; $i++) {
            $pass = $this->generateSecurePasswordStringOnce($length, $special);
            if (self::verify($pass)) {
                if (!$special || ($special && self::containsSpecial($pass))) {
                    $entropy = ShannonEntropy::value(strtolower($pass));
                    if ($entropy > $bestEntropy) {
                        $bestPass = $pass;
                        $bestEntropy = $entropy;
                    }
                }
            }
        }

        return $bestPass;
    }

    private function generateSecurePasswordStringOnce($length = self::GENERATED_PASSWORD_LENGTH, $special = false)
    {
        $dictionary = self::ALLOWED_CHARS;
        if ($special) {
            $dictionary .= self::ALLOWED_SPECIAL;
        }

        if ($length > (self::BEGIN_END_LENGTH * 2)) {
            $beginLength = self::BEGIN_END_LENGTH;
            $endLength = self::BEGIN_END_LENGTH;
            $middle = $length - $beginLength - $endLength;
            $password = $this->generate($beginLength, self::ALLOWED_BEDIN_END);
            $password .= $this->generate($middle, $dictionary);
            $password .= $this->generate($endLength, self::ALLOWED_BEDIN_END);
        } else {
            $password = $this->generate($length, $dictionary);
        }

        return $password;
    }

    public function generateSecureTokenString()
    {
        return $this->generateSecurePasswordString(self::GENERATED_TOKEN_LENGTH);
    }

    private function generate($length = 10, $dictionary = self::ALLOWED_BEDIN_END)
    {
        $dictionary = str_shuffle($dictionary);
        /* get secure pseudo random string (all ASCII chars), php's rand function is not cryptographically secure
           so openssl_random_pseudo_bytes is used , returned string is split to array */
        $bytes = openssl_random_pseudo_bytes(255);
        $bytes = str_split(substr($bytes, 0, $length));
        $constLength = strlen($dictionary);
        $constLength = $constLength < 255 ? $constLength : 255;
        $password = '';
        foreach ($bytes as $char) {
            /* Convert all pseudo random bytes to decimal number (0-255), and select corresponding char from ALLOWED_CHARS
               Password is still secure and random, but can has lower entropy (but still ~50) because instead of
               all ASCII chars contain only ALLOWED_CHARS, entering unprintable chars from keyboard is difficult */
            $strPosition = hexdec(bin2hex($char));
            $strPosition = $strPosition % $constLength;
            $password .= $dictionary[$strPosition];
        }
        return $password;

    }

    public static function verify($string)
    {
        return self::containsNumbers($string) &&
            self::containsLowerChars($string) &&
            self::containsUpperChars($string);
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

    public static function containsSpecial($string)
    {
        return preg_match('/[@#$%&*+?:!]+/', $string) > 0;
    }

    public static function teorethicEntropy($string, $special = false)
    {
        $base = 62;
        if ($special) {
            $base = 72;
        }
        return log(pow($base, strlen($string)), 2);
    }



    /**
     * Calculate entropy of a string
     *
     * @see    https://github.com/jreesuk/entropizer
     *
     * @param  string $str
     * @return integer
     */
    public static function entropizer($str) {
        $classes = array(
            array("regex" => "/[a-z]/", "size" => 26),
            array("regex" => "/[A-Z]/", "size" => 26),
            array("regex" => "/[0-9]/", "size" => 10),
            " ,.?!\"£$%^&*()-_=+[]{};:\'@#~<>/\\|`¬¦"
        );
        $size = 0;
        $str = trim($str);
        foreach($classes as $case) {
            if(is_array($case)) {
                if(preg_match($case["regex"], $str)) {
                    $size += $case["size"];
                }
            } else {
                foreach(str_split($case, 1) as $char) {
                    if(strpos($str, $char) !== false) {
                        $size += strlen($case);
                        break;
                    }
                }
            }
        }
        return floor(log($size, 2) * strlen($str));
    }

}
