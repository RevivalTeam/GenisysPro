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

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\level\Level;

class WallSign extends SignPost {

	protected $id = self::WALL_SIGN;

	public function getName() : string{
		return "Wall Sign";
	}

	public function onUpdate(int $type){
        if($type === Level::BLOCK_UPDATE_NORMAL){
            if($this->getSide($this->meta ^ 0x01)->getId() === self::AIR){
                $this->getLevel()->useBreakOn($this);
            }
            return Level::BLOCK_UPDATE_NORMAL;
        }
        return false;
	}
}