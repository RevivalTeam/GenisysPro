<?php

/*
 *
 *
 *    _______                    _
 *   |__   __|                  (_)
 *      | |_   _ _ __ __ _ _ __  _  ___
 *      | | | | | '__/ _` | '_ \| |/ __|
 *      | | |_| | | | (_| | | | | | (__
 *      |_|\__,_|_|  \__,_|_| |_|_|\___|
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author TuranicTeam
 * @link https://github.com/TuranicTeam/Turanic
 *
 *
*/

namespace pocketmine\command\overload;

class CommandEnum{
	
	protected $name;
	protected $values = [];
	protected $type;
	
	const TYPE_ITEM = 1;
	const TYPE_CUSTOM = 0;
	
	public function __construct(string $name, array $values = [], int $type = self::TYPE_CUSTOM){
		$this->name = $name;
		$this->values = $values;
		$this->type = $type;
	}
	
	public function getName() : string{
		return $this->name;
	}
	
	public function getValues() : array{
		return $this->values;
	}
	
	public function getType() : int{
		return $this->type;
	}
}
?>