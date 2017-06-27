<?php

namespace TKr;

class PassGen
{
    const ALLOWED_CHARS_FLAT = '3456789ABCDEFGHJKLMNPRTUVWXYZabcdefghijkmnopqrstuvwxyz3456789';
    const ALLOWED_CHARS_SPECIAL = '!?@#$%&*()<>[]{}\|3456789ABCDEFGHJKLMNPRTUVWXYZabcdefghijkmnopqrstuvwxyz';

    private $password;

    private $passwords = [];

    private $limit;

    public function __construct($password, $limit = 5)
    {
        $pseudoSaltMD5 = md5($password);
        $pseudoSaltSHA1 = sha1($password);
        $this->password = $pseudoSaltMD5 . $password . $pseudoSaltSHA1;
        $this->limit = $limit;
        $this->generatePasswords();
    }

    public function getPasswords()
    {
        return $this->passwords;
    }

    private function generatePasswords()
    {
        $string = $this->password;
        for ($i = 0; $i < $this->limit; $i++) {
            $generated1 = sha1($string);
            $generated2 = sha1($generated1);
            $string = $generated1 . $generated2;
            $bulk = [];
            $bulk['flat'] = $this->getFlatString($string, self::ALLOWED_CHARS_FLAT);
            $bulk['special'] = $this->getFlatString($string, self::ALLOWED_CHARS_SPECIAL);
            $this->passwords[] = $bulk;
            $string = $bulk['flat'] . $bulk['special'];
        }
    }

    private function getFlatString($generated, $dicitionary)
    {
        $password = '';
        $constLength = strlen($dicitionary);
        for ($i = 0; $i < 40; $i = $i + 2) {
            $current = substr($generated, $i, 2);
            $current = hexdec($current);
            $strPosition = $current % $constLength;
            $password .= $dicitionary[$strPosition];
        }
        return $password;
    }
}
