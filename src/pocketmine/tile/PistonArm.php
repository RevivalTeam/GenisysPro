<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
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
use pocketmine\nbt\tag\FloatTag;

class PistonArm extends Spawnable{

	public function __construct(Level $level, CompoundTag $nbt){
		if (!isset($nbt->Sticky)){
			$nbt->Sticky = new ByteTag("Sticky", (bool)false);
		}
		//TODO init extra nbt
		parent::__construct($level, $nbt);
	}

	public function addAdditionalSpawnData(CompoundTag $nbt): void{
		//TODO extended or not extended
		$nbt->AttachedBlocks = new CompoundTag("AttachedBlocks", []);
		$nbt->BreakBlocks = new CompoundTag("BreakBlocks", []);
		$nbt->LastProgress = new FloatTag("LastProgress", 0.0);//extended 1
		$nbt->NewState = new ByteTag("NewState", 0);//extended 2
		$nbt->Progress = new FloatTag("Progress", 0.0);//extended 1
		$nbt->State = new ByteTag("State", 0);//extended 2
		$nbt->Sticky = $this->namedtag->Sticky;
		//TODO: isMovable
	}
}
