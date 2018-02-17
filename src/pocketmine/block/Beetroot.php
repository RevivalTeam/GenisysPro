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

class Beetroot extends Crops {

	protected $id = self::BEETROOT_BLOCK;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Beetroot Block";
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		if($this->meta >= 0x07){
            return [
                Item::get(Item::BEETROOT),
                Item::get(Item::BEETROOT_SEEDS, 0, mt_rand(0, 3))
            ];
		}

		return [
		    Item::get(Item::BEETROOT_SEEDS)
        ];
	}

	public function getPickedItem(): Item{
        return Item::get(Item::BEETROOT_SEEDS);
    }
}