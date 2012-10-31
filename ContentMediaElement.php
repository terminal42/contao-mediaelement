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


class ContentMediaElement extends ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_mediaelement';
	
	/**
	 * Element type
	 * @param string
	 */
	protected $strType;
	
	/**
	 * Supported file types
	 * @var array
	 */
	protected $arrFileTypes = array
	(
		'video' => array
		(
			'mp4'	=> 'video/mp4',
			'webm'	=> 'video/webm',
			'ogv'	=> 'video/ogg',
		),
		'audio' => array
		(
			'mp3'	=> 'audio/mpeg',
			'ogg'	=> 'audio/ogg',
		),
		'flash' => array
		(
			'mp4',
		),
	);
	
	
	public function generate()
	{
		$this->strType = $this->type == 'mediaelement_audio' ? 'audio' : 'video';
		
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### MEDIA ELEMENT (' . strtoupper($this->strType) . ') ###';

			return $objTemplate->parse();
		}
		
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/mediaelement/html/mediaelement-and-player.min.js';
		$GLOBALS['TL_CSS'][] = 'system/modules/mediaelement/html/mediaelementplayer.min.css';
		
		$this->multiSRC = deserialize($this->multiSRC, true);
		$this->arrFileTypes['poster'] = trimsplit(',', $GLOBALS['TL_CONFIG']['validImageTypes']);
		
		return parent::generate();
	}
	
	
	protected function compile()
	{
		$arrSize = deserialize($this->mejs_size, true);
		
		$arrFiles = array();
		$strFlash = null;
		$strPoster = null;
		
		foreach( $this->multiSRC as $file )
		{
			if (!file_exists(TL_ROOT . '/' . $file))
				continue;
			
			if (is_dir(TL_ROOT . '/' . $file))
			{
				foreach( scan(TL_ROOT . '/' . $file) as $subfile )
				{
					$type = pathinfo(TL_ROOT . '/' . $file . '/' . $subfile, PATHINFO_EXTENSION);

					if (isset($this->arrFileTypes[$this->strType][$type]))
					{
						$arrFiles[$type] = array('type'=>$this->arrFileTypes[$this->strType][$type], 'src'=>$file . '/' . $subfile);
					}
					
					if (in_array($type, $this->arrFileTypes['flash']))
					{
						$strFlash = $file . '/' . $subfile;
					}
					
					if (in_array($type, $this->arrFileTypes['poster']))
					{
						$strPoster = $file . '/' . $subfile;
					}
				}
				
				continue;
			}
			
			$type = pathinfo(TL_ROOT . '/' . $file, PATHINFO_EXTENSION);
					
			if (isset($this->arrFileTypes[$this->strType][$type]))
			{
				$arrFiles[$type] = array('type'=>$this->arrFileTypes[$this->strType][$type], 'src'=>$file);
			}
			
			if (in_array($type, $this->arrFileTypes['flash']))
			{
				$strFlash = $file;
			}
			
			if (in_array($type, $this->arrFileTypes['poster']))
			{
				$strPoster = $file;
			}
		}
		
		$this->Template->id = $this->id;
		$this->Template->type = $this->strType;
		$this->Template->hasPoster = false;
		$this->Template->hasFlash = $strFlash !== null;
		$this->Template->flash = $strFlash;
		$this->Template->files = $arrFiles;
		$this->Template->width = (int) $arrSize[0];
		$this->Template->height = (int) $arrSize[1];
		
		if ($strPoster !== null)
		{
			$this->Template->hasPoster = true;
			$this->Template->poster = $this->getImage($strPoster, $arrSize[0], $arrSize[1]);
		}
	}
}

