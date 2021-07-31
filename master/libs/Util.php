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
     * Get uri
     *
     * This method is useful for get uri
     *
     * @return mixed
     */
    final public function getUri():string
    {
        return filter_input(
            INPUT_SERVER,
            'REQUEST_URI',
            FILTER_SANITIZE_STRING
        );
    }

    /**
     * Get version api
     *
     * This method is useful for get version api
     *
     * @return mixed
     */
    final public function getVersionApi():string
    {
        preg_match('/v\d+/', $this->getUri(), $version);
        return $version[0];
    }

    /**
     * Get entity for method
     *
     * This method is useful for get entity from uri
     *
     * @return mixed
     */
    final public function getEntityUri():string
    {
        $value = str_replace(
            "/vitriapp/services/".$this->getVersionApi()."/",
            "",
            filter_input(
                INPUT_SERVER,
                'REQUEST_URI',
                FILTER_SANITIZE_STRING
            )
        );
        $getId = "/". (int)preg_replace('/\D/', '', $value);
        $getPart = preg_replace('/v[\d,]/', '', $this->getUri());
        $entity = str_replace(array($getPart, $getId), array("", ''), $value);
        if (strpos($entity, 'list') !== false) {
            return str_replace(
                "/list",
                "",
                $entity
            );
        }
        return $entity;
    }

    /**
     * Get post
     *
     * This method is useful for filter field post
     *
     * @param string $name name textfield
     *
     * @return mixed
     */
    final public function getPost(string $name):string
    {
        return filter_input(
            INPUT_POST,
            $name,
            FILTER_SANITIZE_STRING
        );
    }

    /**
     * Get get
     *
     * This method is useful for filter field get
     *
     * @param string $name name textfield
     *
     * @return mixed
     */
    final public function getGet(string $name):string
    {
        return filter_input(
            INPUT_GET,
            $name,
            FILTER_SANITIZE_STRING
        );
    }

    /**
     * Get request
     *
     * This method is useful for filter field request
     *
     * @param string $name name textfield
     *
     * @return mixed
     */
    final public function getRequest(string $name):string
    {
        return filter_input(
            INPUT_REQUEST,
            $name,
            FILTER_SANITIZE_STRING
        );
    }
}
