<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2011
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id: tl_content.php 43 2011-12-19 18:12:53Z A.Schempp $
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['mediaelement_video'] = '{type_legend},type,headline;{source_legend},multiSRC;{image_legend},alt,mejs_size;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes']['mediaelement_youtube'] = '{type_legend},type,headline;{source_legend},mejs_youtube;{image_legend},alt,mejs_size;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes']['mediaelement_audio'] = '{type_legend},type,headline;{source_legend},multiSRC;{image_legend},alt,mejs_size;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['mejs_size'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_content']['mejs_size'],
	'exclude'		=> true,
	'inputType'		=> 'text',
	'eval'			=> array('mandatory'=>true, 'multiple'=>true, 'size'=>2, 'maxlength'=>10),
);

$GLOBALS['TL_DCA']['tl_content']['fields']['mejs_youtube'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_content']['mejs_youtube'],
	'exclude'		=> true,
	'inputType'		=> 'text',
	'eval'			=> array('mandatory'=>true, 'maxlength'=>16),
);

