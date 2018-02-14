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

namespace pocketmine\block;

use pocketmine\level\Level;

class LitRedstoneLamp extends RedstoneLamp implements ElectricalAppliance, SolidLight{

	protected $id = self::LIT_REDSTONE_LAMP;

	public function getName() : string{
		return "Lit Redstone Lamp";
	}

	public function getLightLevel() : int{
		return 15;
	}

	public function onUpdate(int $type){
	    switch($type){
            case Level::BLOCK_UPDATE_NORMAL:
            case Level::BLOCK_UPDATE_REDSTONE:
                if (!$this->level->isBlockPowered($this))
                    $this->level->scheduleDelayedBlockUpdate($this, 4);
                break;
            case Level::BLOCK_UPDATE_SCHEDULED:
                if (!$this->level->isBlockPowered($this))
                    $this->level->setBlock($this, new RedstoneLamp(), false, false);
                break;
        }
	}
}
