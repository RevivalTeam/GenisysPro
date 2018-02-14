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

class Input extends FormElement{

	protected $placeholder = '';
	protected $defaultText = '';
	
	public function __construct($text, $placeholder, $defaultText = ''){
		parent::__construct($text);
		$this->placeholder = $placeholder;
		$this->defaultText = $defaultText;
	}
	
	public function jsonSerialize(){
		$data = parent::jsonSerialize();
		$data["placeholder"] = $this->placeholder;
		$data["default"] = $this->defaultText;
		return $data;
	}
	
	public function handleResponse($value, Player $player){
		return $value;
	}
	
	public function getType() : string{
		return self::TYPE_INPUT;
	}

}