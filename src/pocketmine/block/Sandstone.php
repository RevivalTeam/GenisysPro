<?php

/*
 *
 *
 *    _______                    _
 *   |__   __|                  (_)
 *      | |_   _ _ __ __ _ _ __  _  ___
 *      | | | | | '__/ _` | '_ \| |/ __|
 *      | | |_| | | | (_| | | | | | (__
 *      |_|\__,_|_|  \__,_|_| |_|_|\___|
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author TuranicTeam
 * @link https://github.com/TuranicTeam/Turanic
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\TieredTool;

class Sandstone extends Solid {

	const NORMAL = 0;
	const CHISELED = 1;
	const SMOOTH = 2;

	protected $id = self::SANDSTONE;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function getHardness() : float{
		return 0.8;
	}

	public function getName() : string{
		static $names = [
			self::NORMAL => "Sandstone",
			self::CHISELED => "Chiseled Sandstone",
			self::SMOOTH => "Smooth Sandstone"
		];
        return $names[$this->getVariant()] ?? "Unknown";
	}

	public function getToolType() : int{
		return BlockToolType::TYPE_PICKAXE;
	}

    public function getToolHarvestLevel() : int{
        return TieredTool::TIER_WOODEN;
    }

    public function getVariantBitmask() : int{
        return 0x03;
    }
}