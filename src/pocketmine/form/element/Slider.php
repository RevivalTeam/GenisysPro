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

class Slider extends FormElement{
	
	protected $min = 0;
	protected $max = 0;
	protected $step = 0;
	protected $defaultValue = 0;
	
	public function __construct(string $text, float $min, float $max, float $step = 0.0){
		if ($min > $max){
			throw new \Exception(__METHOD__ . ' Borders are messed up');
		}
		$this->text = $text;
		$this->min = $min;
		$this->max = $max;
		$this->defaultValue = $min;
		$this->setStep($step);
	}
	
	public function setStep(float $step){
		if ($step < 0){
			throw new \Exception(__METHOD__ . ' Step should be positive');
		}
		$this->step = $step;
	}
	
	public function setDefaultValue(float $value){
		if ($value < $this->min or $value > $this->max){
			throw new \Exception(__METHOD__ . ' Default value out of borders');
		}
		$this->defaultValue = $value;
	}
	
	public function jsonSerialize(){
		$data = parent::jsonSerialize();
		$data["min"] = $this->min;
		$data["max"] = $this->max;
		if($this->step > 0){
			$data["step"] = $this->step;
		}
		if($this->defaultValue != $this->min){
			$data["default"] = $this->defaultValue;
		}
		return $data;
	}
	
	public function handleResponse($value, Player $player){
		return $value;
	}
	
	public function getType() : string{
		return self::TYPE_SLIDER;
	}
}