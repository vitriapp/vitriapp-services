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
 * Class Util
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class Util
{

    /**
     * Get post or get
     *
     * This method is useful for filter field get or post
     *
     * @param string $name name textfield
     *
     * @return mixed
     */
    final public function getPostOrGet(string $name):string
    {
        if (filter_input(INPUT_POST, $name, FILTER_SANITIZE_STRING)) {
            return filter_input(INPUT_POST, $name, FILTER_SANITIZE_STRING);
        }
        if (filter_input(INPUT_GET, $name, FILTER_SANITIZE_STRING)) {
            return filter_input(INPUT_GET, $name, FILTER_SANITIZE_STRING);
        }
        return filter_input(INPUT_REQUEST, $name, FILTER_SANITIZE_STRING);
    }
}
