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

class Rounds extends Model
{

    /**
     * Name of the table
     * @var string
     */
    protected static $strTable = 'tl_tilastot_client_rounds';

		public function findForSelect() {
			$ret = array();
			$ret[-1] = '';

			foreach(Rounds::findAll() as $round) {
				$ret[$round->id] = $round->name." ".$round->season;
			}

			return $ret;

		}

		public function findForDisplay($roundId) {
			$round = Rounds::findAll(array (
		    'limit'   => 1,
		    'column'  => array('id=?'),
		    'value'   => array($roundId)
		  ));

			return $round->name;
		}
}
