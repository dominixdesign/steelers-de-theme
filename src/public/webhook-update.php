<?php

$hookSecret = file_get_contents('../src/secret.txt');

$post = file_get_contents('php://input');

if(trim($post) !== trim($hookSecret)) {
    header('HTTP/1.1 404 Internal Server Error');
    die();
}

exec('chmod 744 ../src/updateTheme.sh');
exec('bash -c "exec nohup setsid ../src/updateTheme.sh > /dev/null 2>&1 &"');
