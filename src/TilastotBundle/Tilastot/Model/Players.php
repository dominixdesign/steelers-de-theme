<?php

/*
 * This file is part of the TilastotClientBundle.
 *
 * (c) Dominik Sander <http://dominix-design.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tilastot\Model;

use Contao\Database;
use Contao\Model;

class Players extends Model
{

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $strTable = 'tl_tilastot_client_players';

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
}
