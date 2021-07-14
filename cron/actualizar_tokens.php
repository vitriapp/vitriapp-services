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

namespace services\cron;

use JsonException;
use services\master\Unique;

require_once __DIR__ . '/../master/Unique.php';

$token = new Unique();
$datetime = date('Y-m-d H:i');
try {
    echo $token->updateToken($datetime);
} catch (JsonException $exception) {
    log((float)$exception);
}
