<?php
namespace App\Controller\Page;

use Contao\CoreBundle\ServiceAnnotation\Page;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Page(path="updater/contao/theme")
 */
class UpdatePageController
{
    public function generate()
    {
        exec('bash -c "exec nohup setsid ../src/updateTheme.sh > /dev/null 2>&1 &"', $output, $retval);
        echo 'OK'; 
        return new Response('OK');
    }
}
