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

namespace pocketmine\form;

use pocketmine\Player;
use pocketmine\form\element\Button;

class SimpleForm extends Form{
	
	protected $content = '';
	protected $buttons = [];
	
	public function __construct(string $title, string $content = ''){
		parent::__construct($title);
		$this->content = $content;
	}
	
	public function addButton(Button $button){
		$this->buttons[] = $button;
	}
	
	public function getButtons() : array{
		return $this->buttons;
	}

	public function jsonSerialize(){
		$data = parent::jsonSerialize();
		
		$data["content"] = $this->content;
		$data["buttons"] = $this->buttons;
		
		return $data;
	}
	
	public function handleResponse($response, Player $player){
		return isset($this->buttons[$response]) ? $this->buttons[$response]->handleResponse($response, $player) : null;
	}
	
	public function getType() : string{
		return self::TYPE_SIMPLE;
	}
}