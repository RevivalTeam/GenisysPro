<?php

/*
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