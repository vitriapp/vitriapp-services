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
    print_r('Document has been processed and sent to you.+', null);
}
if ($http_status===400) {
    print_r('Bad HTTP request.+', null);
}
if ($http_status===401) {
    print_r('Unauthorized - Invalid password.+', null);
}
if ($http_status===403) {
    print_r('Forbidden.+', null);
}
if ($http_status===403) {
    print_r('Error.+', null);
}
if ($http_status===500) {
    print_r('Internal Server Error.+', null);
}
if ($http_status===418) {
    print_r('Im a teapot! - This is a real value.+', null);
}
