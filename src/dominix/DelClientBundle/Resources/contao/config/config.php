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
		'callback' => \App\Contao\Module\ModuleRefresh::class
	)
);

/* Model Classes */
$GLOBALS['TL_MODELS']['tl_del_client_rounds'] = '\App\Contao\Model\delRounds';
$GLOBALS['TL_MODELS']['tl_del_client_games'] = '\App\Contao\Model\delGames';

/* Frontend Module */
$GLOBALS['FE_MOD']['del']['schedule'] = '\App\Contao\Module\ScheduleModule';

/* Cronjob */
// $GLOBALS['TL_CRON']['hourly'][] = array('\App\Contao\Utils\delApi','refreshAll');
