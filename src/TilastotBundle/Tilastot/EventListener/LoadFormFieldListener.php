<?php

namespace App\Tilastot\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Form;
use Contao\Widget;

use App\Tilastot\Model\Games;
use App\Tilastot\Model\Standings;

/**
 * @Hook("loadFormField")
 */
class LoadFormFieldListener
{
    public function __invoke(Widget $widget, string $formId, array $formData, Form $form): Widget
    {
        if (is_array($widget->options) && $widget->options[0]['value'] == 'gamedays') {
            $column = array('gamedate >= ? AND hometeam = ?');
            $games = Games::findAll(array(
                'order'   => ' gamedate ASC',
                'column'  => $column,
                'value'   => array(time(), 54744)
            ));
            if (!$games) {
                $widget->options = array('value' => 'no-game-found', 'label' => "Kein Spiel gefunden.");
            } else {
                $gameArray = $games->fetchAll();
                $widget->options = array_map(function ($game) {
                    $away = Standings::findByIdAndRound($game['awayteam'], $game['round'], true);
                    $date = \Contao\Date::parse('d.m.Y', $game['gamedate']);
                    $text = $date . ' - '  . $away['name'];
                    return array('value' => $text, 'label' => $text);
                }, $gameArray);
            }
        }
        return $widget;
    }
}
