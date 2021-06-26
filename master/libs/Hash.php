<?php

declare(strict_types=1);

namespace services\master\libs;

/**
 * *
 *  * PHP version 7.4
 *  *
 *  * @Date: 2021/6/15 1:27:43
 *  * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 *  * @category Developer
 *  * @package  Vitriapp
 *  * @license  Commercial
 *
 */
class Hash
{

    /**
     * @param string $input
     * @param int $rounds
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
