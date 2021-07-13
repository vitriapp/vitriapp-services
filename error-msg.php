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

$http_status = filter_input(INPUT_SERVER, 'REDIRECT_STATUS', FILTER_SANITIZE_STRING);

if ($http_status===200) {
    print 'Document has been processed and sent to you.+';
}
if ($http_status===400) {
    print 'Bad HTTP request.+';
}
if ($http_status===401) {
    print 'Unauthorized - Invalid password.+';
}
if ($http_status===403) {
    print 'Forbidden.+';
}
if ($http_status===403) {
    print 'Error.+';
}
if ($http_status===500) {
    print 'Internal Server Error.+';
}
if ($http_status===418) {
    print 'Im a teapot! - This is a real value.+';
}
