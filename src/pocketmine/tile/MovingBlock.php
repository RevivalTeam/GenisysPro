<?php

/*
 *
 *  ____			_		_   __  __ _				  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___	  |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|	 |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

namespace pocketmine\tile;

use pocketmine\level\Level;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;

class MovingBlock extends Spawnable{

	public function __construct(Level $level, CompoundTag $nbt){
		//TODO init extra nbt
		parent::__construct($level, $nbt);
	}

	public function addAdditionalSpawnData(CompoundTag $nbt): void{
		$nbt->movingBlockData = new ByteTag("movingBlockData", (bool)0);
		$nbt->movingBlockId = new ByteTag("movingBlockId", (bool)0);
		$nbt->pistonPosX = new IntTag("pistonPosX", (int)$this->x);
		$nbt->pistonPosY = new IntTag("pistonPosY", (int)$this->y);
		$nbt->pistonPosZ = new IntTag("pistonPosZ", (int)$this->z);
		//TODO: isMovable
	}
}
