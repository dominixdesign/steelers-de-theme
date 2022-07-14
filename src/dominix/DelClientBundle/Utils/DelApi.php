<?php

/*
 * This file is part of the DelClientBundle.
 *
 * (c) Dominik Sander <http://dominix-design.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dominix\DelClientBundle\Utils;

use dominix\DelClientBundle\Models\DelStandings;
use Contao\StringUtil;
use Contao\Files;

use dominix\DelClientBundle\Models\DelRounds;
use dominix\DelClientBundle\Utils\DelRefreshStandings;
use dominix\DelClientBundle\Utils\DelRefreshGames;
use dominix\DelClientBundle\Utils\DelRefreshPlayers;

class DelApi
{

  const API_URL = 'https://s3-eu-west-1.amazonaws.com/de.hokejovyzapis.cz/';

  private static function call($page, $round) {
    $uri = self::API_URL . $page;

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $uri,
      CURLOPT_USERAGENT => 'starting6media powered website'
    ));

    $response = curl_exec($curl);
		if(curl_errno($curl)>0) {
			throw new \Exception(curl_error());
		} elseif(curl_getinfo($curl,CURLINFO_HTTP_CODE)!=200) {
			throw new \Exception('Del response http code: '.curl_getinfo($curl,CURLINFO_HTTP_CODE));
		}
		curl_close($curl);

    return $response;

  }

  public static function getGames($round) {
    return self::call('league-all-team-stats/2021/1/22.json', $round);
  }

	public static function updateTeam($holemaTeam, $round) {

		$t = DelStandings::findAll(array (
	    'limit'   => 1,
	    'column'  => array('holemaid=?','round=?'),
	    'value'   => array($holemaTeam->{'@id'}, $round)
	  ));
		if(!$t) {
			$t = new DelStandings();
			$t->holemaid = $holemaTeam->{'@id'};
		}

		$t->shortname = $holemaTeam->shortname;
		$t->tstamp = time();
		$t->name = $holemaTeam->name;
		$t->city = $holemaTeam->city;
		$t->round = $round;
		$t->alias = StringUtil::generateAlias($t->name);
		$t->save();

		foreach([20, 50, 100, 200] as $width) {
			$filename = TL_ROOT . DelStandings::getLogoFilename($t->alias, $width);
			if(!file_exists($filename)) {
				Files::getInstance()->fputs(fopen($filename, 'w+'), file_get_contents($holemaTeam->logo->{'image_'.$width}));
			}
		}

		return $t;

	}

	public static function refreshAll() {
		$r = DelRounds::findAll(array (
	    'column'  => array('autorefresh=?'),
	    'value'   => array(1)
	  ));

		foreach($r as $round) {
				DelRefreshStandings::refresh($round->holemaid);
				DelRefreshGames::refresh($round->holemaid);
				DelRefreshPlayers::refresh($round->holemaid);
		}

    \System::log('Del Update done.', __METHOD__, TL_CRON);

	}


}
