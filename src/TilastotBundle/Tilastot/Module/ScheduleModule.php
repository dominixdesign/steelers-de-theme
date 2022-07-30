<?php

namespace App\Tilastot\Module;

use Contao\Module;
use App\Tilastot\Model\Games;
use App\Tilastot\Model\Standings;


use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\Exception\RedirectResponseException;
use Contao\CoreBundle\ServiceAnnotation\FrontendModule;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @FrontendModule(category="texts")
 */
class ScheduleModule extends AbstractFrontendModuleController
{
	protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
	{
		if ($model->tilastot_my_team) {
			$games = Games::findAll(array(
				'order'   => ' gamedate ASC',
				'column'  => array('gamedate >= ? AND gamedate <= ? AND (awayteam = ? OR hometeam = ?)'),
				'value'   => array($model->tilastot_from_date, $model->tilastot_to_date, $model->tilastot_my_team, $model->tilastot_my_team)
			));
		} else {
			$games = Games::findAll(array(
				'order'   => ' gamedate ASC',
				'column'  => array('gamedate >= ? AND gamedate <= ?'),
				'value'   => array($model->tilastot_from_date, $model->tilastot_to_date)
			));
		}

		if (!$games) {
			return new Response();
		}

		$gameArray = $games->fetchAll();
		foreach ($gameArray as $key => $game) {
			$gameArray[$key]['home'] = Standings::findByIdAndRound($game['hometeam'], $game['round']);
			$gameArray[$key]['away'] = Standings::findByIdAndRound($game['awayteam'], $game['round']);
		}

		$template->my_team = $model->tilastot_my_team;
		$template->games = $gameArray;
		$template->headline = unserialize($model->headline);
		$template->headlineUnit = $model->hl;
		$template->cssId = $model->cssID[0];
		$template->cssClass = $model->cssID[1];

		return $template->getResponse();
	}
}