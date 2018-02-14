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

namespace pocketmine\entity\tameable;

use pocketmine\entity\Animal;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;

class Ocelot extends Animal {
	const NETWORK_ID = self::OCELOT;

	const DATA_CAT_TYPE = 18;

	const TYPE_WILD = 0;
	const TYPE_TUXEDO = 1;
	const TYPE_TABBY = 2;
	const TYPE_SIAMESE = 3;

	public $width = 0.312;
	public $height = 0;

	/**
	 * @return string
	 */
	public function getName() : string{
		return "Ocelot";
	}

	/**
	 * Ocelot constructor.
	 *
	 * @param Level       $level
	 * @param CompoundTag $nbt
	 */
	public function __construct(Level $level, CompoundTag $nbt){
		if(!$nbt->hasTag("CatType")){
			$nbt->setByte("CatType", mt_rand(0, 3));
		}
		parent::__construct($level, $nbt);

		$this->propertyManager->setByte(self::DATA_CAT_TYPE, $this->getCatType());
	}

	/**
	 * @param int $type
	 */
	public function setCatType(int $type){
		$this->namedtag->setByte("CatType", $type);
	}

	/**
	 * @return int
	 */
	public function getCatType() : int{
		return $this->namedtag->getByte("CatType");
	}

    public function getXpDropAmount(): int{
        return !$this->isBaby() ? mt_rand(1,3) : 0;
    }
}
