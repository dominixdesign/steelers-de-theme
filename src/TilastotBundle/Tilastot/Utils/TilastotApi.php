<?php

/*
 * This file is part of the TilastotBundle.
 *
 * (c) Dominik Sander <http://dominix-design.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tilastot\Utils;

use Contao\StringUtil;
use Contao\Files;

use App\Tilastot\Model\Rounds;
use App\Tilastot\Model\Standings;
use App\Tilastot\Utils\RefreshStandings;
use App\Tilastot\Utils\RefreshGames;
use App\Tilastot\Utils\RefreshPlayers;

class TilastotApi
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
			throw new \Exception('DEL API response http code: '.curl_getinfo($curl,CURLINFO_HTTP_CODE));
		}
		curl_close($curl);

    return $response;

  }
 
  public static function getGames($round) {
		$r = Rounds::findById($round);
    return self::call('league-team-matches/'.$r->year.'/'.$r->league.'/22.json', $round);
  }

  public static function getStandings($round) {
		$r = Rounds::findById($round);
    return self::call('tables/'.$r->standingsid.'.json', $round);
  }

	public static function updateTeam($tilastotTeam, $round) {

		$t = Standings::findAll(array (
	    'limit'   => 1,
	    'column'  => array('tilastotid=?','round=?'),
	    'value'   => array($tilastotTeam->id, $round)
	  ));
		if(!$t) {
			$t = new Standings();
			$t->tilastotid = $tilastotTeam->id;
		}

		$t->shortname = $tilastotTeam->shortcut;
		$t->tstamp = time();
		$t->name = $tilastotTeam->name;
		$t->round = $round;
		$t->alias = StringUtil::generateAlias($t->name);
		$t->save();

		return $t;
	}

	public static function refreshAll() {
		$r = Rounds::findAll(array (
	    'column'  => array('autorefresh=?'),
	    'value'   => array(1)
	  ));

//		foreach($r as $round) {
//				DelRefreshStandings::refresh($round->holemaid);
//				DelRefreshGames::refresh($round->holemaid);
//				DelRefreshPlayers::refresh($round->holemaid);
//		}

    \System::log('DEL Update done.', __METHOD__, TL_CRON);

	}


}
