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

use pocketmine\entity\Entity;
use pocketmine\level\Level;
use pocketmine\math\Vector3;

abstract class Fallable extends Solid {

	public function onUpdate(int $type){
        if($type === Level::BLOCK_UPDATE_NORMAL){
            $down = $this->getSide(Vector3::SIDE_DOWN);
            if($down->getId() === self::AIR or $down instanceof Liquid or $down instanceof Fire){
                $this->level->setBlock($this, BlockFactory::get(Block::AIR), true);

                $nbt = Entity::createBaseNBT($this->add(0.5, 0, 0.5));
                $nbt->setInt("TileID", $this->getId());
                $nbt->setByte("Data", $this->getDamage());

                $fall = Entity::createEntity("FallingSand", $this->getLevel(), $nbt);

                if($fall !== null){
                    $fall->spawnToAll();
                }
            }
        }
	}

    public function tickFalling(){
        return null;
    }
}