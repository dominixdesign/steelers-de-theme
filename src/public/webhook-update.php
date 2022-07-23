<?php

exec('chmod 744 ../src/updateTheme.sh');
exec('bash -c "exec nohup setsid ../src/updateTheme.sh > /dev/null 2>&1 &"');
echo 'OK'; 
