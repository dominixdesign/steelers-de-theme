<?php

/*
 * This file is part of the DelClientBundle.
 *
 * (c) Dominik Sander <http://dominix-design.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/* Backend Module */
$GLOBALS['BE_MOD']['del'] = array(
	'del_rounds' => array(
		'tables' => array('tl_del_client_rounds')
	),
	'del_games' => array(
    'tables' => array('tl_del_client_games')
	),
	'del_refresh' => array(
		'callback' => 'dominix\\DelClientBundle\\Modules\\ModuleRefresh'
	)
);

/* Model Classes */
$GLOBALS['TL_MODELS']['tl_del_client_rounds'] = '\dominix\DelClientBundle\Models\delRounds';
$GLOBALS['TL_MODELS']['tl_del_client_games'] = '\dominix\DelClientBundle\Models\delGames';

/* Frontend Modules */
$GLOBALS['FE_MOD']['del']['schedule'] = '\dominix\DelClientBundle\Modules\ScheduleModule';

/* Cronjob */
// $GLOBALS['TL_CRON']['hourly'][] = array('\dominix\DelClientBundle\Utils\delApi','refreshAll');
