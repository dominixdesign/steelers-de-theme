<?php


$GLOBALS['TL_DCA']['tl_module']['fields']['tilastot_round'] = array
(
	 'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tilastot_round'],
	 'exclude'                 => true,
	 'search'                  => true,
	 'inputType'               => 'select',
	 'options_callback'        => array('App\\Tilastots\\Model\\Rounds', 'findForSelect'),
	 'eval'										 => array('onchange' => 'Backend.autoSubmit(\'tl_module\')'),
	 'sql'                     => "varchar(64) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['tilastot_table_rows'] = array
(
	 'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tilastot_table_rows'],
	 'exclude'                 => true,
	 'inputType'               => 'text',
	 'eval'                    => array('mandatory'=>false, 'rgxp'=>'numeric', 'tl_class'=>'w50'),
	 'sql'                     => "int(3) NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['tilastot_my_team'] = array
(
	 'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tilastot_my_team'],
	 'exclude'                 => true,
	 'inputType'               => 'select',
	 'options_callback'        => array('App\\Tilastot\\Model\\Standings', 'findTeamsForSelect'),
	 'eval'                    => array('tl_class'=>'w50'),
	 'sql'                     => "int(5) NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['tilastot_config_json'] = array
(
	 'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tilastot_config_json'],
	 'inputType'               => 'textarea',
	 'reference'               => &$GLOBALS['TL_LANG']['tilastot_config_json'],
	 'eval'                    => array('style'=>'height:60px', 'preserveTags'=>true, 'rte'=>'ace|html', 'tl_class'=>'clr'),
	 'sql'                     => "text NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['tilastot_from_date'] = array
(
	 'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tilastot_from_date'],
	 'inputType'               => 'text',
	 'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
	 'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tilastot_to_date'] = array
(
	 'label'                   => &$GLOBALS['TL_LANG']['tl_module']['tilastot_to_date'],
	 'inputType'               => 'text',
	 'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
	 'sql'                     => "varchar(10) NOT NULL default ''"
);


$GLOBALS['TL_DCA']['tl_module']['palettes']['schedule'] = '{title_legend},name,headline,type;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['schedule'].= '{tilastot_legend},tilastot_my_team,tilastot_from_date,tilastot_to_date;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['schedule'].= '{template_legend:hide},customTpl;{expert_legend:hide},cssID,space';
