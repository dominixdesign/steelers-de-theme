<?php

/*
 * This file is part of the DelClientBundle.
 *
 * (c) Dominik Sander <http://dominix-design.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Tilastot\Model\Partners;

$GLOBALS['TL_DCA']['tl_tilastot_partners'] = array(
    // Config
    'config'   => array(
        'dataContainer' => 'Table',
        'enableVersioning' => true,
        'onsubmit_callback' => array(array('tl_tilastot_partners', 'saveCallback')),
        'onload_callback' => array(array('tl_tilastot_partners', 'loadCallback')),
        'sql' => array(
            'keys' => array(
                'id' => 'primary'
            )
        )

    ),
    // List
    'list' => array(
        'sorting' => array(
            'mode'                    => 11,
            'fields'                  => array('name'),
            'panelLayout'             => 'filter;search,limit'
        ),
        'label' => array(
            'fields'                  => array('name', 'category'),
            'showColumns'             => true
        ),
        'global_operations' => array(
            'all' => array(
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array(
            'edit' => array(
                'label'               => &$GLOBALS['TL_LANG']['tl_tilastot_partners']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy'   => array(
                'label'               => &$GLOBALS['TL_LANG']['tl_tilastot_partners']['copy'],
                'href'                => 'act=paste&amp;mode=copy',
                'icon'                => 'copy.gif',
            ),
            'delete' => array(
                'label'               => &$GLOBALS['TL_LANG']['tl_tilastot_partners']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show' => array(
                'label'               => &$GLOBALS['TL_LANG']['tl_tilastot_partners']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),
    // Palettes
    'palettes' => array(
        'default' => 'name,displayname,category;logo;published'
    ),
    // Fields
    'fields'   => array(
        'id' => array(
            'sql'                     => "int(10) unsigned NOT NULL AUTO_INCREMENT"
        ),
        'tstamp' => array(
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'name' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_tilastot_partners']['name'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'displayname' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_tilastot_partners']['displayname'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'category' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_tilastot_partners']['category'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'checkbox',
            'options'                 => array(
                'premium' => 'Premiumpartner',
                'gold' => 'Businesspartner Gold',
                'silber' => 'Businesspartner Silber',
                'bronze' => 'Businesspartner Bronze',
                'business' => 'Businesspartner',
                'lounge' => 'Businesslounge',
                'medien' => 'Medienpartner',
                'carpool' => 'Carpool Partner',
                'team' => 'Teampartner',
                'supporter' => 'Supporter',
            ),
            'eval'                    => array('multiple' => true, 'mandatory' => true, 'maxlength' => 255, 'tl_class' => 'clr w50'),
            'sql'                     => "varchar(255) NULL"
        ),
        'logo' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_tilastot_partners']['logo'],
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType' => 'radio', 'filesOnly' => true, 'extensions' => '%contao.image.valid_extensions%', 'mandatory' => false),
            'sql'                     => "binary(16) NULL"
        ),
        'published' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_tilastot_partners']['published'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class' => 'w50'),
            'sql'                     => "int(1) NOT NULL default '0'"
        )
    )
);

class tl_tilastot_partners extends Backend
{
    function saveCallback(DataContainer $dc)
    {
        // Return if there is no ID
        if (!$dc->id) {
            return;
        }
        var_dump($dc->activeRecord->category);
        //$this->Database->prepare("UPDATE tl_tilastot_client_games %s WHERE id=?")->set($arrSet)->execute($dc->id);
    }
    function loadCallback(DataContainer $dc)
    {
        // Return if there is no ID
        if (!$dc->id) {
            return;
        }
        var_dump($dc->id);
        $element = Partners::findById($dc->id);
        var_dump($element);
        //$this->Database->prepare("UPDATE tl_tilastot_client_games %s WHERE id=?")->set($arrSet)->execute($dc->id);
    }
}
