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

namespace pocketmine\command\overload;

class CommandOverload{
	
	protected $name;
	protected $params = [];
	
	public function __construct(string $name, array $params = []){
		$this->params = $params;
		$this->name = $name;
	}
	
	public function getName() : string{
		return $this->name;
	}
	
	public function getParameters() : array{
		return $this->params;
	}
	
	public function setParameter(int $index, CommandParameter $param){
		$this->params[$index] = $param;
	}
}
