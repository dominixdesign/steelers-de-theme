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

use Contao\Database;
use App\Tilastot\Model\Games;
use App\Tilastot\Model\Standings;

class RefreshGames
{

	const TABLE = 'tl_tilastot_client_standings';

	public static function refresh($round)
	{
		if (!$round) {
			return "round missing!";
		}

		$data = json_decode(TilastotApi::getGames($round));

		foreach ($data->matches as $game) {
			$date = date_parse_from_format("Y-m-d H:i:s", $game->start_date);
			$g = Games::findById($game->id);
			if (!$g) {
				$g = new Games();
				$g->id = $game->id;
			}
			TilastotApi::updateTeam($game->home, $round);
			TilastotApi::updateTeam($game->guest, $round);
			if ($game->results->extra_time && !$game->results->shooting) {
				$g->resulttype = 'OT';
			} elseif ($game->results->extra_time && $game->results->shooting) {
				$g->resulttype = 'SO';
			}
			$g->hometeam = $game->home->id;
			$g->awayteam = $game->guest->id;
			$g->gamedate = mktime($date['hour'], $date['minute'], 0, $date['month'], $date['day'], $date['year']);
			$g->gametime = $date['hour'] . ":" . $date['minute'];
			$g->round = $round;
			$g->periodscore = $game->periodscore;
			$g->gamestatus = $game->status;
			$g->homescore = $game->results->score->final->score_home;
			$g->awayscore = $game->results->score->final->score_guest;
			$g->ended = ($game->status === 'AFTER_MATCH') ? 1 : 0;
			$g->tstamp = time();
			$g->save();
		}
	}
}
