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

use pocketmine\item\TieredTool;

class StoneBricks extends Solid{
	const NORMAL = 0;
	const MOSSY = 1;
	const CRACKED = 2;
	const CHISELED = 3;

	protected $id = self::STONE_BRICKS;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function getHardness() : float{
		return 1.5;
	}

	public function getToolType() : int{
		return BlockToolType::TYPE_PICKAXE;
	}

    public function getToolHarvestLevel() : int{
        return TieredTool::TIER_WOODEN;
    }

	public function getName() : string{
		static $names = [
			self::NORMAL => "Stone Bricks",
			self::MOSSY => "Mossy Stone Bricks",
			self::CRACKED => "Cracked Stone Bricks",
			self::CHISELED => "Chiseled Stone Bricks",
		];
		return $names[$this->getVariant()] ?? "Unknown";
	}
}