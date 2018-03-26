<?php
/**
 * JulLib ©2015 Julien <youlweb@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TKr;

/**
 * Shannon entropy property.
 *
 * Allows to estimate the average minimum number of bits needed to encode
 * a string of symbols based on the alphabet size and the frequency of
 * the symbols. {@link http://www.shannonentropy.netmark.pl Read more}.
 * @author Julien <youlweb@hotmail.com>
 */
class ShannonEntropy
{
    /**
     * Return the average number of bits needed to encode the input string.
     *
     * @param string $string
     * @return float
     */
    public static function value($string)
    {
        $h = 0;
        $size = strlen($string);
        foreach (count_chars($string, 1) as $v) {
            $p = $v / $size;
            $h -= $p * log($p) / log(2);
        }

        return $h;
    }
}
