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

class ModalForm extends Form{
	
	protected $content = '';
	protected $trueButtonText = '';
	protected $falseButtonText = '';
	
	public function __construct(string $title, string $content, string $trueButtonText, string $falseButtonText){
		parent::__construct($title);
		
		$this->content = $content;
		$this->trueButtonText = $trueButtonText;
		$this->falseButtonText = $falseButtonText;
	}

    public function jsonSerialize(){
    	$data = parent::jsonSerialize();
    
		$data["content"] = $this->content;
		$data["button1"] = $this->trueButtonText;
		$data["button2"] = $this->falseButtonText;
		
		return $data;
	}
	
	public function handleResponse($response, Player $player){
		if($response === true){
			return $this->trueButtonText;
		}else{
			return $this->falseButtonText;
		}
	}
	
	public function getType() : string{
		return self::TYPE_MODAL;
	}
	
	public function getTrueButtonText() : string{
		return $this->trueButtonText;
	}
	
	public function getFalseButtonText() : string{
		return $this->falseButtonText;
	}
}