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

class Planks extends Solid {
	const OAK = 0;
	const SPRUCE = 1;
	const BIRCH = 2;
	const JUNGLE = 3;
	const ACACIA = 4;
	const DARK_OAK = 5;

	protected $id = self::WOODEN_PLANKS;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function getHardness() : float{
		return 2;
	}

	public function getToolType() : int{
		return BlockToolType::TYPE_AXE;
	}

	public function getBurnChance() : int{
		return 5;
	}

	public function getBurnAbility() : int{
		return 20;
	}

	public function getName() : string{
		static $names = [
			self::OAK => "Oak Wood Planks",
			self::SPRUCE => "Spruce Wood Planks",
			self::BIRCH => "Birch Wood Planks",
			self::JUNGLE => "Jungle Wood Planks",
			self::ACACIA => "Acacia Wood Planks",
			self::DARK_OAK => "Dark Oak Wood Planks"
		];
		return $names[$this->getVariant()] ?? "Unknown";
	}

	public function getFuelTime(): int{
        return 300;
    }

}