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
use App\Tilastot\Model\Rounds;
use App\Tilastot\Model\Games;
use App\Tilastot\Model\Standings;
use App\Tilastot\Model\Players;
use App\Tilastot\Model\PlayerStats;

class ApiHockeydata
{
    const API_URL = 'https://api.hockeydata.net/data/ebel/Standings';
    const TEAM_ID = 36;
    const IGNORED_GAMES = [];

    private static function call($standingsid, $apiKey)
    {
        $url = self::API_URL;
        if (!$params) {
            $params = [
                'apiKey' => '3c5a99d835fcb70156d40cd60d03f350', // $apiKey
                'referer' => 'deb-online.live',
                'divisionId' => $standingsid
            ];
        }

        $params = array_merge($params, [], $params);


        return TilastotApi::call($url, array('apikey: ' . $apiKey));
    }

    public static function refreshAll($round)
    {
        self::refreshStandings($round);
        self::refreshGames($round);
        self::refreshPlayers($round);
    }

    private static function updateTeam($team, $round)
    {
        $obj = new \stdClass();
        $obj->id = $team->id;
        $obj->shortcut = $team->teamShortname;
        $obj->name = $team->teamLongname;
        return TilastotApi::updateTeam($obj, $round);
    }

    public static function refreshStandings($round)
    {
        if (!$round) {
            return "round missing!";
        }
        $r = Rounds::findById($round);

        $data = json_decode(self::call('Standings', $r->standingsid, $r->apikey));

        foreach ($data->data->rows as $team) {

            $t = Standings::findAll(array(
                'limit'   => 1,
                'column'  => array('tilastotid=?', 'round=?'),
                'value'   => array($team->id, $round)
            ));

            if (!$t) {
                $t = self::updateTeam($team, $round);
            }

            $t->name = $team->teamLongname;
            $t->tilastotid = $team->id;
            $t->round = $round;
            $t->shortname = $team->teamShortname;
            $t->games = $team->gamesPlayed;
            $t->rw = $team->gamesWon;
            $t->ow = $team->gamesWonInOt;
            //          $t->pw = $team->pw;
            //          $t->pl = $team->pl;
            $t->ol = $team->gamesLostInOt;
            $t->rl = $team->gamesLost;
            $t->points = $team->points;
            $t->goalsfor = $team->goalsFor;
            $t->goalsagainst = $team->goalsAgainst;
            $t->save();
        }
    }

    public static function refreshPlayers($round)
    {
        if (!$round) {
            return "round missing!";
        }
        $r = Rounds::findById($round);

        $rosterData = json_decode(self::call('roster.json/' . $r->standingsid . '/' . self::TEAM_ID, $r->apikey));
        $statsData = json_decode(self::call('playerstats.json/' . $r->standingsid . '/' . self::TEAM_ID, $r->apikey));
        if ($rosterData->teamroster->players == "") {
            return null;
        }

        foreach ($rosterData->teamroster->players->player as $player) {

            $p = Players::findAll(array(
                'limit'   => 1,
                'column'  => array('tilastotid=?'),
                'value'   => array($player->{'@id'})
            ));
            if (!$p) {
                $p = new Players();
                $p->tilastotid = $player->{'@id'};
            }
            $birthday = date_parse_from_format("d.m.Y", $player->birthday);
            if ($player->{'@eliteprospectsid'} > 0) {
                $p->eliteprospectsid = $player->{'@eliteprospectsid'};
            }
            $p->firstname = $player->firstname;
            $p->lastname = $player->lastname;
            $p->jersey = $player->jersey;
            $p->position = $player->position;
            $p->nationality = $player->nationality;
            $p->shoots = $player->shoots;
            $p->birthday = mktime(0, 0, 0, $birthday['month'], $birthday['day'], $birthday['year']);
            $p->birthplace = $player->birthplace ? $player->birthplace : '';
            $p->height = $player->height;
            $p->weight = $player->weight;

            $p->alias = StringUtil::generateAlias($p->firstname . " " . $p->lastname);

            if ($p->eliteprospectsid) {
                $rss = new \SimpleXMLElement('http://eliteprospects.com/rss_player_stats2.php?player=' . $p->eliteprospectsid, 0, true);
                foreach ($rss->xpath('channel/item') as $item) {
                    $p->epstats = mb_convert_encoding($item->description, 'ISO-8859-1', 'UTF-8');
                    break;
                }
            }

            $p->tstamp = time();
            $savedPlayer = $p->save();

            if ($statsData->playerstats->players != '') {
                foreach ($statsData->playerstats->players->player as $stat) {
                    if ($player->{'@id'} == $stat->{'@id'}) {
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
                        $stats->games = $stat->games;
                        $stats->goals = $stat->goals;
                        $stats->assists = $stat->assists;
                        $stats->points = $stat->points;
                        $stats->penalties = $stat->penalties;
                        $stats->plusminus = $stat->plus - $stat->minus;
                        $stats->faceoffswon = $stat->faceoffswon;
                        $stats->faceoffslost = $stat->faceoffslost;
                        $stats->shots = $stat->shots;
                        $stats->tstamp = time();
                        $stats->save();
                        break;
                    }
                }
            }
        }
    }

    public static function refreshGames($round)
    {
        if (!$round) {
            return "round missing!";
        }
        $r = Rounds::findById($round);

        $data = json_decode(self::call('Schedule', $r->standingsid, $r->apikey));

        foreach ($data->data->games as $game) {
            if (in_array($game->id, self::IGNORED_GAMES)) {
                // skip games from the ignored list
                continue;
            }
            if ($game->awayTeamId != self::TEAM_ID && $game->homeTeamId != self::TEAM_ID) {
                // skip non steelers games
                continue;
            }
            $date = date_parse_from_format("d.m.Y", $game->scheduledDate->value);
            $time = explode(':', $game->scheduledTime);
            $g = Games::findById($game->id);
            if (!$g) {
                $g = new Games();
                $g->id = $game->id;
            }
            self::updateTeam([
                id => $game->awayTeamId,
                teamShortname => $game->awayTeamShortname,
                teamLongname => $game->awayTeamLongname
            ], $round);
            self::updateTeam([
                id => $game->homeTeamId,
                teamShortname => $game->homeTeamShortname,
                teamLongname => $game->homeTeamLongname
            ], $round);
            $g->hometeam = $game->homeTeamId;
            $g->awayteam = $game->awayTeamId;
            $g->gamedate = mktime($time[0], $time[1], 0, $date['month'], $date['day'], $date['year']);
            $g->gametime = $game->scheduledTime;
            $g->round = $round;
            $g->periodscore = $game->periodResults;
            $g->gameday = $game->gameDay;
            $g->gamestatus = $game->gameStatus; // 4 = ended
            if ($game->isOvertime) {
                $g->resulttype = 'OT';
            } else if ($game->isShootOut) {
                $g->resulttype = 'SO';
            }
            $g->homescore = $game->homeTeamScore;
            $g->awayscore = $game->awayTeamScore;
            $g->ended = ($game->gameStatus == 4) ? 0 : 1;
            $g->tstamp = time();
            $g->save();
        }
    }
}
