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

$status = filter_input(
    INPUT_SERVER,
    'REDIRECT_STATUS',
    FILTER_SANITIZE_STRING
);

if ($status===200) {
    print_r('Document has been processed and sent to you.+', false);
}
if ($status===400) {
    print_r('Bad HTTP request.+', false);
}
if ($status===401) {
    print_r('Unauthorized - Invalid password.+', false);
}
if ($status===403) {
    print_r('Forbidden.+', false);
}
if ($status===403) {
    print_r('Error.+', false);
}
if ($status===500) {
    print_r('Internal Server Error.+', false);
}
if ($status===418) {
    print_r('Im a teapot! - This is a real value.+', false);
}
