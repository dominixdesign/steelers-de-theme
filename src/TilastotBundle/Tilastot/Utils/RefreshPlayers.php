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
use App\Tilastot\Model\PlayerStats;
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
				'column'  => array('tilastotid=?'),
				'value'   => array($player->id)
			));
			if (!$p) {
				$p = new Players();
				$p->tilastotid = $player->id;
			}
			$birthday = date_parse_from_format("Y-m-d", $player->birthday);
			// $p->eliteprospectsid = $player->{'@eliteprospectsid'};
			$p->birthday = mktime(0, 0, 0, $birthday['month'], $birthday['day'], $birthday['year']);
			$p->firstname = $player->firstname;
			$p->lastname = $player->surname;
			$p->position = $player->position;
			$p->nationality = $player->nationality;
			$p->shoots = $player->stick;
			$p->birthplace = $player->birthCountry;
			$p->height = $player->height;
			$p->weight = $player->weight;

			$p->alias = StringUtil::generateAlias($p->firstname . " " . $p->lastname);

			if ($p->eliteprospectsid > 0) {
				$rss = new \SimpleXMLElement('http://eliteprospects.com/rss_player_stats2.php?player=' . $p->eliteprospectsid, null, true);
				foreach ($rss->xpath('channel/item') as $item) {
					$p->epstats = utf8_decode($item->description);
					break;
				}
			}

			$p->tstamp = time();
			$savedPlayer = $p->save();

			
			if ($player->statistics) {
				$stats = PlayerStats::findAll(array(
					'limit'   => 1,
					'column'  => array('pid=?', 'round=?'),
					'value'   => array($savedPlayer->id, $round)
				));
				if (!$stats) {
					$stats = new PlayerStats();
					$stats->pid = $savedPlayer->id;
				}
				
				$stats->round = $round;
				$stats->jersey = $player->jersey;
				$stats->games = $player->statistics->games;
				$stats->goals = $player->statistics->goals->home + $player->statistics->goals->away;
				$stats->assists = $player->statistics->assists->home + $player->statistics->assists->away;
				$stats->points = $player->statistics->points->home + $player->statistics->points->away;
				$stats->penalties = $player->statistics->penaltyMinutes;
				$stats->plusminus = $player->statistics->positive -  $player->statistics->negative;
				$stats->faceoffswon = $player->statistics->faceoffsWin;
				$stats->faceoffslost = $player->statistics->faceoffsLosses;
				$stats->shots = $player->statistics->shotsOnGoal->home + $player->statistics->shotsOnGoal->away;
				$stats->tstamp = time();
				$stats->save();
			}
		}
	}
}
