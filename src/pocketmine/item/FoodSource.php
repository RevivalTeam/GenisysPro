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

/**
 *  Interface implemented by objects that can be consumed by players, giving them food and saturation.
 */
interface FoodSource extends Consumable {

	/**
	 * @return int
	 */
	public function getFoodRestore() : int;

	/**
	 * @return float
	 */
	public function getSaturationRestore() : float;

    /**
     * Returns whether a Human eating this FoodSource must have a non-full hunger bar.
     * @return bool
     */
	public function requiresHunger() : bool;

}
