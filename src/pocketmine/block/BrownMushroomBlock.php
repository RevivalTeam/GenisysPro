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

use pocketmine\item\Item;

class BrownMushroomBlock extends Solid {

	const BROWN = 14;

	protected $id = self::BROWN_MUSHROOM_BLOCK;

	public function __construct(int $meta = 14){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Brown Mushroom Block";
	}

	public function getHardness() : float{
		return 0.2;
	}

	public function getDropsForCompatibleTool(Item $item) : array{
        return [
            Item::get(Item::BROWN_MUSHROOM, 0, mt_rand(0, 2))
        ];
	}
}
