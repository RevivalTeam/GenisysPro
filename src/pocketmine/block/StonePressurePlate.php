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

use pocketmine\entity\Living;

class StonePressurePlate extends PressurePlate {
	protected $id = self::STONE_PRESSURE_PLATE;

	public function __construct(int $meta = 0){
        parent::__construct($meta);
        $this->onPitch = 0.6;
        $this->offPitch = 0.5;
    }

	public function getName() : string{
		return "Stone Pressure Plate";
	}

    protected function computeRedstoneStrength(): int{
        $bbs = $this->getCollisionBoxes();

        foreach($bbs as $bb){
            foreach($this->level->getCollidingEntities($bb) as $entity){
                if($entity instanceof Living && $entity->doesTriggerPressurePlate()){
                    return 15;
                }
            }
        }
        return 0;
    }
}