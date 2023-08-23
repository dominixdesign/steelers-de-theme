<?php

namespace App\Tilastot\Module;

use App\Tilastot\Model\Partners;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\ModuleModel;
use Contao\Template;
use Contao\StringUtil;
use Contao\ArrayUtil;
use Contao\FilesModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PartnersModule extends AbstractFrontendModuleController
{
	protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
	{
		$partners = Partners::findAll(array(
			'column'  => array('published=1'),
			'order' => 'name ASC'
		));
		var_dump($model->tilastot_partners_category);
		$partnerslist = array();

		if (!$partners) {
			return new Response();
		}
		foreach ($partners->fetchAll() as $p) {

			$logo = StringUtil::deserialize($p['logo']);

			if (!empty($logo) || is_array($logo)) {
				$files = ArrayUtil::sortByOrderField($logo, StringUtil::deserialize($p['orderPictures']));
				$allPictures = FilesModel::findMultipleByUuids($files)->fetchAll();
				$p['logo'] = $allPictures;
			}

			$partnerslist[] = $p;
		}


		$template->partners = $partnerslist;

		$template->headline = $this->headline;
		$template->headlineUnit = $this->hl;
		$template->cssId = $this->cssID[0];
		$template->cssClass = $this->cssID[1];

		return $template->getResponse();
	}
}
