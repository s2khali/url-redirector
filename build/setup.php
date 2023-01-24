<?php
$env = getenv();

$append = "\n";
foreach ($env as $key => $value){
    $append .= 'env[' . $key . '] = "' . $value . '"' . "\n";
}
file_put_contents ( "/etc/php/8.1/fpm/php-fpm.conf" ,  $append, FILE_APPEND);


$append = file_get_contents("/var/www/_build/php-fpm.ini");
file_put_contents ( "/etc/php/8.1/fpm/php.ini" ,  $append, FILE_APPEND);

$append = file_get_contents("/var/www/_build/php.ini");
file_put_contents ( "/etc/php/8.1/phpdbg/php.ini" ,  $append, FILE_APPEND);

$append = file_get_contents("/var/www/_build/httpd.conf");
file_put_contents ( "/etc/apache2/sites-available/000-default.conf" ,  $append, FILE_APPEND);


$append = file_get_contents("/var/www/_build/fpm.conf");
file_put_contents ( "/etc/php/8.1/fpm/pool.d/www.conf" ,  $append, FILE_APPEND);
file_put_contents ( "/etc/php/8.1/fpm/php-fpm.conf" ,  $append, FILE_APPEND);
