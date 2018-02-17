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

namespace pocketmine\event\form;

use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\event\Event;

abstract class FormEvent extends Event{

	protected $player;
	protected $form;

	public function __construct(Player $player, Form $form){
		$this->form = $form;
		$this->player = $player;
	}

	public function getPlayer() : Player{
		return $this->player;
	}

	public function getForm(){
		return $this->form;
	}
	
	public function setForm(Form $form){
		$this->form = $form;
	}
}
