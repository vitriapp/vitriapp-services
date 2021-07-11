<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/6/15 1:27:43
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\master\libs;

/**
 * Class Hash
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Hash
{

    /**
     * Crypt
     *
     * This method is useful for crypt password and token.
     *
     * @param string $input  data for crypt words.
     * @param int    $rounds rounds for crypt words.
     *
     * @return mixed
     */
    final public function crypt(string $input, int $rounds = 8): string
    {
        $iteration = '';
        $salt_chars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
        for ($cycle = 0; $cycle < 22; $cycle++) {
            $iteration .= $salt_chars[array_rand($salt_chars)];
        }
        return crypt($input, sprintf('$2a$%02d$', $rounds) . $iteration);
    }
}
