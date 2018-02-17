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

use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

class SplashPotion extends ProjectileItem {

	/**
	 * SplashPotion constructor.
	 *
	 * @param int $meta
	 */
	public function __construct(int $meta = 0){
		parent::__construct(self::SPLASH_POTION, $meta, $this->getNameByMeta($meta));
	}

	/**
	 * @return int
	 */
	public function getMaxStackSize() : int{
		return 1;
	}

	/**
	 * @param int $meta
	 *
	 * @return string
	 */
	public function getNameByMeta(int $meta){
		return "Splash " . Potion::getNameByMeta($meta);
	}

    public function getProjectileEntityType() : string{
        return "ThrownPotion";
    }

    public function getThrowForce() : float{
        return 1.1;
    }

    public function onClickAir(Player $player, Vector3 $directionVector, CompoundTag $nbt = null): bool{
        if($player->server->allowSplashPotion) {
            if($nbt == null){
                $nbt = Entity::createBaseNBT($player->add(0,$player->getEyeHeight(),0), $directionVector, $player->yaw, $player->pitch);
                $nbt->setShort("PotionId", $this->getDamage());
            }
            return parent::onClickAir($player, $directionVector, $nbt);
        }
        return true;
    }
}