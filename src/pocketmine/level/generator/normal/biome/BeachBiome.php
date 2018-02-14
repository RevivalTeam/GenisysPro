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

namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\populator\Cactus;
use pocketmine\level\generator\populator\DeadBush;

class BeachBiome extends SandyBiome {

	/**
	 * BeachBiome constructor.
	 */
	public function __construct(){
		parent::__construct();

		$this->removePopulator(Cactus::class);
		$this->removePopulator(DeadBush::class);

		$this->setElevation(62, 65);
	}

	/**
	 * @return string
	 */
	public function getName() : string{
		return "Beach";
	}
} 