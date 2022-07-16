<?php

/*
 * This file is part of the DelClientBundle.
 *
 * (c) Dominik Sander <http://dominix-design.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Contao\Module;

use Contao\Database;
use Contao\BackendModule;
use App\Contao\Model\DelRounds;
use App\Contao\Utils\DelRefreshStandings;
use App\Contao\Utils\DelRefreshGames;

class ModuleRefresh extends BackendModule
{

	protected $strTemplate = 'be_refresh';

	public function compile() {

		if (\Input::post('FORM_SUBMIT') == 'tl_del_refresh') {
			$done = array();
			foreach(\Input::post('round') as $round) {
					DelRefreshStandings::refresh($round);
					DelRefreshGames::refresh($round);
					$done[$round] = DelRounds::findOneBy('delid', $round);
			}
			$this->Template->result = $done;
		}


		$this->Template->href = $this->getReferer(true);
		$this->Template->title = specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']);
		$this->Template->button = $GLOBALS['TL_LANG']['MSC']['backBT'];
		$this->Template->formSubmit = 'contao?do=del_refresh';
		$this->Template->rounds = DelRounds::findAll();
		
		return 'lorem ipüsum';

	}

}
