<?php

/*
 * This file is part of the TilastotClientBundle.
 *
 * (c) Dominik Sander <http://dominix-design.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tilastot\Utils;

use Contao\Database;
use App\Tilastot\Model\Players;
use Contao\StringUtil;
use Contao\Files;

class RefreshPlayers
{

	public static function refresh($round)
	{
		if (!$round) {
			return "round missing!";
		}

		$playerData = json_decode(TilastotApi::getPlayers($round));

		if (count($playerData) == 0) {
			return null;
		}

		foreach ($playerData as $player) {

			$p = Players::findAll(array(
				'limit'   => 1,
				'column'  => array('tilastotid=?', 'round=?'),
				'value'   => array($player->id, $round)
			));
			if (!$p) {
				$p = new Players();
				$p->tilastotid = $player->id;
			}
			$p->round = $round;
			$birthday = date_parse_from_format("Y-m-d", $player->birthday);
			// $p->eliteprospectsid = $player->{'@eliteprospectsid'};
			$p->birthday = mktime(0, 0, 0, $birthday['month'], $birthday['day'], $birthday['year']);
			$p->firstname = $player->firstname;
			$p->lastname = $player->surname;
			$p->jersey = $player->jersey;
			$p->position = $player->position;
			$p->nationality = $player->nationality;
			$p->shoots = $player->stick;
			$p->birthplace = $player->birthCountry;
			$p->height = $player->height;
			$p->weight = $player->weight;

			if ($player->statistics) {
				$p->games = $player->statistics->games;
				$p->goals = $player->statistics->goals->home + $player->statistics->goals->away;
				$p->assists = $player->statistics->assists->home + $player->statistics->assists->away;
				$p->points = $player->statistics->points->home + $player->statistics->points->away;
				$p->penalties = $player->statistics->penaltyMinutes;
				$p->plusminus = $player->statistics->positive -  $player->statistics->negative;
				$p->faceoffswon = $player->statistics->faceoffsWin;
				$p->faceoffslost = $player->statistics->faceoffsLosses;
				$p->shots = $player->statistics->shotsOnGoal->home + $player->statistics->shotsOnGoal->away;
			}

			$p->alias = StringUtil::generateAlias($p->firstname . " " . $p->lastname);

			if ($p->eliteprospectsid > 0) {
				$rss = new \SimpleXMLElement('http://eliteprospects.com/rss_player_stats2.php?player=' . $p->eliteprospectsid, null, true);
				foreach ($rss->xpath('channel/item') as $item) {
					$p->epstats = utf8_decode($item->description);
					break;
				}
			}

			$p->tstamp = time();
			$p->save();

			/*
			<games>52</games>
			<goals>23</goals>
			<assists>27</assists>
			<points>50</points>
			<penalties>66</penalties>
			<plusminus>+12</plusminus>
			<faceoffswon>568</faceoffswon>
			<faceoffslost>487</faceoffslost>
			<shots>190</shots>
			*/
		}
	}
}
