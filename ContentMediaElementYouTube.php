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
 * @version    $Id: ContentMediaElement.php 43 2011-12-19 18:12:53Z A.Schempp $
 */


class ContentMediaElementYouTube extends ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_mediaelement';
	
	
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### MEDIA ELEMENT (YouTube) ###';

			return $objTemplate->parse();
		}
		
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/mediaelement/html/mediaelement-and-player.js';
		$GLOBALS['TL_CSS'][] = 'system/modules/mediaelement/html/mediaelementplayer.css';
		
		return parent::generate();
	}
	
	
	protected function compile()
	{
		$arrSize = deserialize($this->mejs_size, true);
		
		$this->Template->id = $this->id;
		$this->Template->type = 'video';
		$this->Template->hasPoster = false;
		$this->Template->hasFlash = false;
		$this->Template->files = array(array('type'=>'video/youtube', 'src'=>'http://www.youtube.com/watch?v='.$this->mejs_youtube));
		$this->Template->width = (int) $arrSize[0];
		$this->Template->height = (int) $arrSize[1];
		
		if ($strPoster !== null)
		{
			$this->Template->hasPoster = true;
			$this->Template->poster = $this->getImage($strPoster, $arrSize[0], $arrSize[1]);
		}
	}
}

