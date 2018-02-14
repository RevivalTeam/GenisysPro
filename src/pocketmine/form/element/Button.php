<?php

/**
 *
 *
 *    _____            _               _____
 *   / ____|          (_)             |  __ \
 *  | |  __  ___ _ __  _ ___ _   _ ___| |__) | __ ___
 *  | | |_ |/ _ \ '_ \| / __| | | / __|  ___/ '__/ _ \
 *  | |__| |  __/ | | | \__ \ |_| \__ \ |   | | | (_) |
 *   \_____|\___|_| |_|_|___/\__, |___/_|   |_|  \___/
 *                           __/ |
 *                          |___/
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   @author GenisysPro
 *   @link https://github.com/GenisysPro/GenisysPro
 *
 *
 *
 */

namespace pocketmine\form\element;

use pocketmine\Player;

class Button extends FormElement{

	const IMAGE_TYPE_PATH = 'path';
	const IMAGE_TYPE_URL = 'url';
	
	protected $imageType;
	protected $image;
	
	public function setImage(string $imageType, string $image){
		if ($imageType != self::IMAGE_TYPE_PATH and $imageType != self::IMAGE_TYPE_URL){
			return false;
		}
		$this->imageType = $imageType;
		$this->image = $image;
	}
	
	 public function jsonSerialize(){
		$data = parent::jsonSerialize();
		
		if ($this->imageType != ""){
			$data['image'] = [
				'type' => $this->imageType,
				'data' => $this->image
			];
		}
		return $data;
	}
	
	public function handleResponse($value, Player $player){
		return $this->text;
	}
	
	public function getType() : string{
		return self::TYPE_BUTTON;
	}
	
	public function getImageType() : string{
		return $this->imageType;
	}
	
	public function getImage() : string{
		return $this->image;
	}

}