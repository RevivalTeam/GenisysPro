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

class Image extends FormElement{
	
	public $texture;
	public $width;
	public $height;

	public function __construct($texture, $width = 0, $height = 0){
		parent::__construct("sign");
		
		$this->texture = $texture;
		$this->width = $width;
		$this->height = $height;
	}
	
	public function jsonSerialize(){
		$data = parent::jsonSerialize();
		$data["texture"] = $this->texture;
		$data["size"] = [$this->width, $this->height];
		return $data;
	}
	
	public function handleResponse($value, Player $player){
		return null;
	}
	
	public function getType() : string{
		return self::TYPE_IMAGE;
	}

}