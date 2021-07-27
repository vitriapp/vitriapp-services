<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/6/14 0:19:41
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\v1;

use JsonException;
use services\set\Constant;
use services\v1\patients\Post;
use services\v1\patients\Put;
use services\v1\patients\Delete;
use services\v1\patients\Error;

require_once '../../master/Responses.php';
require_once '../../set/Constant.php';
require_once 'Patients.php';
require_once 'Get.php';
require_once 'Post.php';
require_once 'Put.php';
require_once 'Delete.php';
require_once 'Error.php';

$constant = new Constant();
$value = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
$idUser = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

switch ($constant->method()) {
    case Constant::GET_DATA:
        $get = new Get();
        if (isset($value)) {
            $get->variousPatients((int)$value);
        } elseif (isset($idUser)) {
            $get->onePatients((int)$idUser);
        }
        break;

    case Constant::POST_DATA:
        $post = new Post();
        $post->addPatients();
        break;

    case Constant::PUT_DATA:
        $put = new Put();
        $put->editPatients();
        break;

    case Constant::DELETE_DATA:
        $delete = new Delete();
        try {
            $delete->removePatients();
        } catch (JsonException $exception) {
            log($exception->getMessage());
        }
        break;

    default:
        $error = new Error();
        $error->display();
        break;
}
