<?php

/*
 * This file is part of the DelClientBundle.
 *
 * (c) Dominik Sander <http://dominix-design.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dominix\DelClientBundle\Models;

use Contao\Database;
use Contao\Model;

class DelRounds extends Model
{

    /**
     * Name of the table
     * @var string
     */
    protected static $strTable = 'tl_del_client_rounds';

		public function findForSelect() {
			$ret = array();
			$ret[-1] = '';

			foreach(DelRounds::findAll() as $round) {
				$ret[$round->id] = $round->name." ".$round->season;
			}

			return $ret;

		}
}
