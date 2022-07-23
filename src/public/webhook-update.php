<?php

file_put_contents('test', var_export($_POST, true));

//exec('chmod 744 ../src/updateTheme.sh');
//exec('bash -c "exec nohup setsid ../src/updateTheme.sh > /dev/null 2>&1 &"');
echo 'OK'; 
