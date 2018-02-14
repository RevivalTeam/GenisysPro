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

use pocketmine\entity\Entity;
use pocketmine\item\TieredTool;
use pocketmine\item\Item;

class Cobweb extends Flowable{

	protected $id = self::COBWEB;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function hasEntityCollision() : bool{
		return true;
	}

	public function getName() : string{
		return "Cobweb";
	}

	public function getHardness() : float{
		return 4;
	}

	public function getToolType() : int{
        return BlockToolType::TYPE_SWORD | BlockToolType::TYPE_SHEARS;
	}

    public function getToolHarvestLevel() : int{
        return TieredTool::TIER_WOODEN;
    }

    public function onEntityCollide(Entity $entity){
		$entity->resetFallDistance();
	}

	public function getDropsForCompatibleTool(Item $item): array{
        return [
            Item::get(Item::STRING)
        ];
    }

    public function diffusesSkyLight(): bool{
        return true;
    }
}
