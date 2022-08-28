<?php

namespace App\Tilastot\Module;

use App\Tilastot\Model\Players;
use App\Tilastot\Model\Stats;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\ModuleModel;
use Contao\Template;
use Contao\System;
use Contao\CoreBundle\Routing\ResponseContext\HtmlHeadBag\HtmlHeadBag;
use Contao\Input;
use Contao\Config;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlayerModule extends AbstractFrontendModuleController
{

  protected $strTemplate = 'mod_player';
  protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
  {
    $player = Players::findByAlias(\Input::get('auto_item'));
    if (!$player) {
      throw new PageNotFoundException('Page not found: ' . \Environment::get('uri'));
    }
    $responseContext = System::getContainer()->get('contao.routing.response_context_accessor')->getResponseContext();

    if ($responseContext && $responseContext->has(HtmlHeadBag::class)) {
      /** @var HtmlHeadBag $htmlHeadBag */
      $htmlHeadBag = $responseContext->get(HtmlHeadBag::class);
      $htmlDecoder = System::getContainer()->get('contao.string.html_decoder');

      $htmlHeadBag->setTitle(strip_tags(\StringUtil::stripInsertTags($player->firstname) . ' ' . \StringUtil::stripInsertTags($player->lastname)));
    }

    $template->player = $player;
    $template->headlineUnit = $this->hl;
    $template->cssId = $this->cssID[0];
    $template->cssClass = $this->cssID[1];
    return $template->getResponse();
  }

  public function generate()
  {
    if (TL_MODE == 'BE') {
      /** @var \BackendTemplate|object $objTemplate */
      $objTemplate = new \BackendTemplate('be_wildcard');
      $objTemplate->wildcard = '### HOLEMA SPIELERDETAILS ###';
      $objTemplate->title = $this->headline;
      $objTemplate->id = $this->id;
      $objTemplate->link = $this->name;
      $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
      return $objTemplate->parse();
    }
  }
}