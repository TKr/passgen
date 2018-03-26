<?php

namespace TKr;

use TKr\ShannonEntropy;

class PassService
{
    const BEGIN_END_LENGTH = 4;
    const MIN_PASSWORD_LENGTH = 8;
    const GENERATED_PASSWORD_LENGTH = 16;
    const GENERATED_TOKEN_LENGTH = 48;
    const ALLOWED_BEDIN_END = 'ABCDEFGHJKLMNPRTUVWXYZabcdefghijkmnopqrstuvwxyz';
    const ALLOWED_CHARS = '23456789ABCDEFGHJKLMNPRTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
    const ITERATIONS = 100;

    public function generateSecurePasswordString($length = self::GENERATED_PASSWORD_LENGTH, $iterations = self::ITERATIONS)
    {
        $bestPass = '';
        $bestEntropy = 0;

        for ($i = 0; $i < $iterations; $i++) {
            $pass = $this->generateSecurePasswordStringOnce($length);
            $entropy = ShannonEntropy::value($pass);
            if ($entropy > $bestEntropy) {
                $bestPass = $pass;
                $bestEntropy = $entropy;
            }
        }

        return $bestPass;
    }

    private function generateSecurePasswordStringOnce($length = self::GENERATED_PASSWORD_LENGTH)
    {
        if ($length > (self::BEGIN_END_LENGTH * 2)) {
            $beginLength = self::BEGIN_END_LENGTH;
            $endLength = self::BEGIN_END_LENGTH;
            $middle = $length - $beginLength - $endLength;
            $password = $this->generate($beginLength, self::ALLOWED_BEDIN_END);
            $password .= $this->generate($middle, self::ALLOWED_CHARS);
            $password .= $this->generate($endLength, self::ALLOWED_BEDIN_END);
        } else {
            $password = $this->generate($length, self::ALLOWED_CHARS);
        }

        return $password;
    }

    public function generateSecureTokenString()
    {
        return $this->generateSecurePasswordString(self::GENERATED_TOKEN_LENGTH);
    }

    private function generate($length = self::ALLOWED_BEDIN_END, $dictionary = self::ALLOWED_BEDIN_END)
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
}
