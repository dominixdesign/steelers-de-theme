<?php

/*
 * This file is part of the DelClientBundle.
 *
 * (c) Dominik Sander <http://dominix-design.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tilastot\Module;

use Contao\Database;
use Contao\BackendModule;
use App\Tilastot\Model\Rounds;
use App\Tilastot\Utils\RefreshStandings;
use App\Tilastot\Utils\RefreshGames;
use App\Tilastot\Utils\RefreshPlayers;

class RefreshModule extends BackendModule
{

	protected $strTemplate = 'be_refresh';

	public function compile() {

		if (\Input::post('FORM_SUBMIT') == 'tl_tilastot_refresh') {
			$done = array();
			foreach(\Input::post('round') as $round) {
					RefreshStandings::refresh($round);
					RefreshGames::refresh($round);
					RefreshPlayers::refresh($round);
					$done[$round] = Rounds::findOneBy('id', $round);
			}
			$this->Template->result = $done;
		}


		$this->Template->href = $this->getReferer(true);
		$this->Template->title = specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']);
		$this->Template->button = $GLOBALS['TL_LANG']['MSC']['backBT'];
		$this->Template->formSubmit = 'contao?do=tilastot_refresh';
		$this->Template->rounds = Rounds::findAll();
		
		return 'lorem ipüsum';

	}

}
