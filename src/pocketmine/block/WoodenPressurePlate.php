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

class WoodenPressurePlate extends PressurePlate {
	protected $id = self::WOODEN_PRESSURE_PLATE;

	public function getName() : string{
		return "Wooden Pressure Plate";
	}

    protected function computeRedstoneStrength(): int{
        $bbs = $this->getCollisionBoxes();

        foreach($bbs as $bb){
            foreach($this->level->getCollidingEntities($bb) as $entity){
                if($entity->doesTriggerPressurePlate()){
                    return 15;
                }
            }
        }
        return 0;
    }

    public function getFuelTime(): int{
        return 300;
    }

    public function getToolType() : int{
        return BlockToolType::TYPE_AXE;
    }

    public function getToolHarvestLevel() : int{
        return 0; //TODO: fix hierarchy problem
    }
}