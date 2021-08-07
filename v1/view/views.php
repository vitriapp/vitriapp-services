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
use services\set\Regular;
use services\v1\controller\PostPutDelete;
use services\v1\controller\Get;
use services\v1\error\Error;

require_once '../../master/Responses.php';
require_once '../../master/libs/Util.php';
require_once '../../set/Constant.php';
require_once '../controller/Get.php';
require_once '../controller/PostPutDelete.php';
require_once '../error/Error.php';
require_once '../General.php';
require_once '../../set/Regular.php';

$constant = new Constant();
$general = new General();
$regular = new Regular();
$util = new Util();

$value = (int)filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
$idUser = (int)filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

if ($constant->method() === Constant::GET_DATA) {
    $get = new Get();
    if ($idUser > 0 && $value === 0) {
        $get->{'show' .
        $general->method($util->getEntityUri())}(
            $idUser,
            false,
            $general->method($util->getEntityUri()),
            'get'
        );
    } elseif ($idUser === 0 && $value > 0) {
        $get->{'show' .
        $general->method($util->getEntityUri())}(
            $value,
            true,
            $general->method(
                $util->getEntityUri()
            ),
            'get'
        );
    } else {
        $error = new Error();
        $error->notFound();
    }
} elseif (in_array(
    $constant->method(),
    [
        Constant::POST_DATA,
        Constant::PUT_DATA,
        Constant::DELETE_DATA
    ],
    true
)) {
    $controller = new PostPutDelete();
    $controller->request(
        $regular->results($constant->method()),
        $general->method($util->getEntityUri()),
        $constant->method()
    );
} else {
    $error = new Error();
    $error->display();
}
