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

class StepSlider extends FormElement{
	
	protected $steps = [];
	protected $defaultStepIndex = 0;
	
	public function __construct($text, $steps = []){
		$this->text = $text;
		$this->steps = $steps;
	}
	
	public function addStep(string $stepText, bool $isDefault = false){
		if ($isDefault){
			$this->defaultStepIndex = count($this->steps);
		}
		$this->steps[] = $stepText;
	}
	
	public function setStepAsDefault(string $stepText){
		$index = array_search($stepText, $this->steps);
		if ($index === false){
			return false;
		}
		$this->defaultStepIndex = $index;
		return true;
	}
	
	public function setSteps(array $steps){
		$this->steps = $steps;
	}
	
	public function getStep(int $index) : string{
		return $this->steps[$index] ?? null;
	}
	
	public function jsonSerialize(){
		$data = parent::jsonSerialize();
		$data["steps"] = array_map('strval', $this->steps);
		$data["default"] = $this->defaultStepIndex;
		return $data;
	}
	
	public function handleResponse($value, Player $player){
		return $this->steps[$value];
	}
	
	public function getType() : string{
		return self::TYPE_STEP_SLIDER;
	}
}