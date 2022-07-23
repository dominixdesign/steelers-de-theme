<?php

/*
 * This file is part of the TilastotBundle.
 *
 * (c) Dominik Sander <http://dominix-design.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tilastot\Model;

use Contao\Database;
use Contao\Model;
use App\Tilastot\Model\Rounds;

class Standings extends Model
{

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $strTable = 'tl_tilastot_client_standings';
	protected static $localCache = array();

	public function findTeamsForSelect()
	{
		$ret = array();
		$ret[-1] = "";
		$teams = Standings::findAll();
		foreach ($teams as $team) {
			$ret[$team->tilastotid] = $team->name;
		}

		return $ret;
	}

	public function findTeamsForDisplay($row, $label, $dc, $args)
	{
		$args[0] = date('d.m.Y', $args[0]);
		$args[1] = self::getTeamData($args[1], $args[3]);
		$args[2] = self::getTeamData($args[2], $args[3]);
		$args[3] = Rounds::findForDisplay($args[3]);
		return $args;
	}

	public static function getTeamData($tilastotId, $round, $data = 'name')
	{
		$team = self::findAll(array(
			'limit'   => 1,
			'column'  => array('tilastotid=?', 'round=?'),
			'value'   => array($tilastotId, $round)
		));
		if ($team) {
			$team = $team->fetchAll();
			return $team[0][$data];
		} else {
			return '## unknown team (' . $tilastotId . ', ' . $round . ') ##';
		}
	}

	public function findColumnsForSelect()
	{
		$ret = array();
		$objDatabase = Database::getInstance();
		$res = $objDatabase->prepare("SHOW COLUMNS FROM " . self::$strTable)->execute()->fetchAllAssoc();
		foreach ($res as $column) {
			$ret[$column['Field']] = $column['Field'];
		}
		return $ret;
	}

	public static function findByIdAndRound($tilastotid, $round)
	{
		if (self::$localCache['r' . $round]['t' . $tilastotid]) {
			return self::$localCache['r' . $round]['t' . $tilastotid];
		}
		$result = Standings::findAll(array(
			'limit'   => 1,
			'column'  => array('tilastotid=?', 'round=?'),
			'value'   => array($tilastotid, $round)
		));
		if ($result) {
			$return = $result->fetchAll()[0];
			foreach ([20, 50, 100, 200] as $width) {
				if (file_exists(TL_ROOT . $filename)) {
					$return['logos'][$width] = Standings::getLogoFilename($return['alias'], $width);
				}
			}
			self::$localCache['r' . $round]['t' . $tilastotid] = $return;
			return $return;
		}
		return null;
	}

	public static function getLogoFilename($alias, $width)
	{
		return '/files/holema_logos/' . $alias . "_" . $width . ".png";
	}
}