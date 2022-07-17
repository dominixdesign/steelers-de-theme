<?php

/*
 * This file is part of the TilasotBundle.
 *
 * (c) Dominik Sander <http://dominix-design.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tilastot\Utils;

use Contao\Database;
use App\Tilastot\Model\Standings;

class RefreshStandings
{

  const TABLE = 'tl_tilastot_client_standings';

  public static function refresh($round) {
		if(!$round) {return "round missing!";}

    $data = json_decode(TilastotApi::getStandings($round));

    $objDatabase = Database::getInstance();

    foreach($data->table as $team) {

			$t = Standings::findAll(array (
		    'limit'   => 1,
		    'column'  => array('tilastotid=?','round=?'),
		    'value'   => array($team->id, $round)
		  ));

			if(!$t) {
				$t = TilastotApi::updateTeam($team, $round, true);
			}

			$t->name = $team->name;
			$t->tilastotid = $team->id;
			$t->round = $round;
			$t->shortname = $team->shortcut;
			$t->games = $team->games;
			$t->rw = $team->wins;
			$t->ow = $team->onlyOTwins;
			$t->pw = $team->onlySOwins;
			$t->pl = $team->onlySOlosts;
			$t->ol = $team->onlyOTlosts;
			$t->rl = $team->losses;
			$t->points = $team->points;
			$t->goalsfor = $team->score1;
			$t->goalsagainst = $team->score2; 
			$t->save();

    }

  }


}
