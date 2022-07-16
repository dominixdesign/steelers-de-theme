<?php


$GLOBALS['TL_DCA']['tl_module']['fields']['del_round'] = array
(
	 'label'                   => &$GLOBALS['TL_LANG']['tl_module']['del_round'],
	 'exclude'                 => true,
	 'search'                  => true,
	 'inputType'               => 'select',
	 'options_callback'        => array('dominix\\DelClientBundle\\Model\\DelRounds', 'findForSelect'),
	 'eval'										 => array('onchange' => 'Backend.autoSubmit(\'tl_module\')'),
	 'sql'                     => "varchar(64) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['del_table_rows'] = array
(
	 'label'                   => &$GLOBALS['TL_LANG']['tl_module']['del_table_rows'],
	 'exclude'                 => true,
	 'inputType'               => 'text',
	 'eval'                    => array('mandatory'=>false, 'rgxp'=>'numeric', 'tl_class'=>'w50'),
	 'sql'                     => "int(3) NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['del_config_json'] = array
(
	 'label'                   => &$GLOBALS['TL_LANG']['tl_module']['del_config_json'],
	 'inputType'               => 'textarea',
	 'reference'               => &$GLOBALS['TL_LANG']['del_config_json'],
	 'eval'                    => array('style'=>'height:60px', 'preserveTags'=>true, 'rte'=>'ace|html', 'tl_class'=>'clr'),
	 'sql'                     => "text NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['del_from_date'] = array
(
	 'label'                   => &$GLOBALS['TL_LANG']['tl_module']['del_from_date'],
	 'inputType'               => 'text',
	 'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
	 'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['del_to_date'] = array
(
	 'label'                   => &$GLOBALS['TL_LANG']['tl_module']['del_to_date'],
	 'inputType'               => 'text',
	 'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
	 'sql'                     => "varchar(10) NOT NULL default ''"
);


$GLOBALS['TL_DCA']['tl_module']['palettes']['schedule'] = '{title_legend},name,headline,type;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['schedule'].= '{del_legend},del_from_date,del_to_date;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['schedule'].= '{template_legend:hide},customTpl;{expert_legend:hide},cssID,space';
