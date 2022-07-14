<?php

namespace dominix\DelClientBundle\Modules;

use Contao\Module;
use dominix\DelClientBundle\Models\DelGames;

class ScheduleModule extends Module {

	protected $strTemplate = 'mod_schedule';

	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			/** @var \BackendTemplate|object $objTemplate */
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### DEL SCHEDULE ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
			return $objTemplate->parse();
		}

		if (empty($this->del_round))
		{
			return '';
		}

		return parent::generate();
	}

  protected function compile()
  {

		if($this->del_my_team) {
			$games = DelGames::findAll(array (
				'order'   => ' gamedate ASC',
				'column'  => array('gamedate >= ? AND gamedate <= ? AND (awayteam = ? OR hometeam = ?)'),
				'value'   => array($this->del_from_date,$this->del_to_date,$this->del_my_team,$this->del_my_team)
			));
		} else {
			$games = DelGames::findAll(array (
				'order'   => ' gamedate ASC',
				'column'  => array('gamedate >= ? AND gamedate <= ?'),
				'value'   => array($this->del_from_date,$this->del_to_date)
			));

		}
		if(!$games) {
			return null;
		}

		$gameArray = $games->fetchAll();
		foreach($gameArray as $key => $game) {
			$gameArray[$key]['home'] = DelStandings::findByIdAndRound($game['hometeam'],$game['round']);
			$gameArray[$key]['away'] = DelStandings::findByIdAndRound($game['awayteam'],$game['round']);
		}

		$this->Template->my_team = $this->del_my_team;
		$this->Template->games = $gameArray;
		$this->Template->headline = $this->headline;
		$this->Template->headlineUnit = $this->hl;
		$this->Template->cssId = $this->cssID[0];
		$this->Template->cssClass = $this->cssID[1];

  }

}
