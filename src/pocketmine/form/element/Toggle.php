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

class Toggle extends FormElement{
	
	protected $defaultValue = false;
	
	public function __construct(string $text, bool $value = false){
		$this->text = $text;
		$this->defaultValue = $value;
	}
	
	public function setDefaultValue(bool $value){
		$this->defaultValue = $value;
	}
	
	public function jsonSerialize(){
		$data = parent::jsonSerialize();
		$data["default"] = $this->defaultValue;
		return $data;
	}
	
	public function handleResponse($value, Player $player){
		return $value;
	}
	
	public function getType() : string{
		return self::TYPE_TOGGLE;
	}

}