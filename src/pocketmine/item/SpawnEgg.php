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

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;

class SpawnEgg extends Item {
	/**
	 * SpawnEgg constructor.
	 *
	 * @param int $meta
	 */
	public function __construct(int $meta = 0){
		parent::__construct(self::SPAWN_EGG, $meta, "Spawn Egg");
	}

	/**
	 * @return bool
	 */
	public function canBeActivated() : bool{
		return true;
	}

	public function onActivate(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickPos) : bool{
		if($blockReplace->getId() == Block::MONSTER_SPAWNER){
			return true;
		}else{
            $nbt = Entity::createBaseNBT($blockReplace->add(0.5, 0, 0.5), null, lcg_value() * 360, 0);

			if($this->hasCustomName()){
				$nbt->setString("CustomName", $this->getCustomName());
			}

			$entity = Entity::createEntity($this->meta, $player->getLevel(), $nbt);

			if($entity instanceof Entity){
                --$this->count;
				$entity->spawnToAll();
				return true;
			}

			return false;
		}
	}
}