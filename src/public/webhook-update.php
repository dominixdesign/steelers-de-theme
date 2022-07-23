<?php

$post = file_get_contents('php://input');

file_put_contents('test', var_export($post, true));

//exec('chmod 744 ../src/updateTheme.sh');
//exec('bash -c "exec nohup setsid ../src/updateTheme.sh > /dev/null 2>&1 &"');
echo 'OK'; 
