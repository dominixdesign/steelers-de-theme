<?php
namespace App\Tilastot\Module;

use App\Tilastot\Model\Players;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\ModuleModel;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RosterModule extends AbstractFrontendModuleController
{
	protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
	{
		$players = Players::findByRound($model->tilastot_round,array('order' => 'jersey ASC'));
		$playerlist = array();

		if(!$players) {
			return new Response();
		}
		foreach($players->fetchAll() as $p) {
			switch($p['position']) {
				case 'RW':
				case 'C':
				case 'LW':
					$playerlist['F'][] = $p;
					break;
				default:
					$playerlist[$p['position']][] = $p;
					break;
			}
		}

		$playerlist['0G'] = $playerlist['GK'];
		$playerlist['2D'] = $playerlist['DE'];
		$playerlist['4F'] = $playerlist['FO'];
		unset($playerlist['GK']);
		unset($playerlist['DE']);
		unset($playerlist['F']);
		ksort($playerlist);

		$template->players = $playerlist;
		$template->configData = json_decode(preg_replace('/(\v|\s)+/', ' ', $this->tilastot_config_json),true);

		$template->headline = $this->headline;
		$template->headlineUnit = $this->hl;
		$template->cssId = $this->cssID[0];
		$template->cssClass = $this->cssID[1];

		return $template->getResponse();
	}
}