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

class GoldHelmet extends Armor {
	/**
	 * GoldHelmet constructor.
	 *
	 * @param int $meta
	 */
	public function __construct(int $meta = 0){
		parent::__construct(self::GOLD_HELMET, $meta, "Gold Helmet");
	}

	/**
	 * @return int
	 */
	public function getArmorTier(){
		return Armor::TIER_GOLD;
	}

	/**
	 * @return int
	 */
	public function getArmorType(){
		return Armor::TYPE_HELMET;
	}

	/**
	 * @return int
	 */
	public function getMaxDurability(){
		return 78;
	}

	/**
	 * @return int
	 */
	public function getDefensePoints() : int{
		return 1;
	}

	/**
	 * @return bool
	 */
	public function isHelmet(){
		return true;
	}
}