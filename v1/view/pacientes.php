<?php

declare(strict_types=1);

/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/7/28 6:3:13
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\v1;

use services\master\libs\Util;
use services\set\Constant;
use services\v1\controller\Get;
use services\v1\controller\Post;
use services\v1\controller\Put;
use services\v1\controller\Delete;
use services\v1\error\Error;

require_once '../../master/Responses.php';
require_once '../../master/libs/Util.php';
require_once '../../set/Constant.php';
require_once '../controller/Get.php';
require_once '../controller/Post.php';
require_once '../controller/Put.php';
require_once '../controller/Delete.php';
require_once '../error/Error.php';
require_once '../General.php';

$constant = new Constant();
$value = (int)filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
$idUser = (int)filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$util = new Util();
$general = new General();

if ($constant->method() === Constant::GET_DATA) {
    $get = new Get();
    if ($idUser > 0 && $value === 0) {
        $get->{'show'.
        $general->method($util->getEntityUri())}(
            $idUser,
            false,
            $general->method($util->getEntityUri())
        );
    } elseif ($idUser === 0 && $value > 0) {
        $get->{'show'.
        $general->method($util->getEntityUri())}(
            $value,
            true,
            $general->method($util->getEntityUri())
        );
    } else {
        $error = new Error();
        $error->notFound();
    }
} elseif ($constant->method() === Constant::POST_DATA) {
    $post = new Post();
    $post->{'add'.$general->method($util->getEntityUri())}();
} elseif ($constant->method() === Constant::PUT_DATA) {
    $put = new Put();
    $put->{'edit'.$general->method($util->getEntityUri())}();
} elseif ($constant->method() === Constant::DELETE_DATA) {
    $delete = new Delete();
    $delete->{'remove'.$general->method($util->getEntityUri())}();
} else {
    $error = new Error();
    $error->display();
}
