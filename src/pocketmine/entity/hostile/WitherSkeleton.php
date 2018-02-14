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

namespace pocketmine\entity\hostile;

use pocketmine\entity\Monster;
use pocketmine\item\Item as ItemItem;

class WitherSkeleton extends Monster {
	const NETWORK_ID = self::WITHER_SKELETON;

	public $width = 0.3;
	public $height = 0;

	/**
	 * @return string
	 */
	public function getName(){
		return "Wither Skeleton";
	}

	public function initEntity(){
		$this->setMaxHealth(20);
		parent::initEntity();
	}

    /**
     * @return array|ItemItem[]
     * @throws \TypeError
     */
    public function getDrops(){
		$drops = [
			ItemItem::get(ItemItem::COAL, 0, mt_rand(0, 1))
		];
		$drops[] = ItemItem::get(ItemItem::BONE, 0, mt_rand(0, 2));

		return $drops;
	}

    public function getXpDropAmount(): int{
        return 5;
    }
}