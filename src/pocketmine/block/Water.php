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
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

class Water extends Liquid {

	protected $id = self::FLOWING_WATER;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Water";
	}

	public function getLightFilter(): int{
        return 2;
    }

    public function tickRate(): int{
        return 5;
    }

    /**
	 * @param Entity $entity
	 */
	public function onEntityCollide(Entity $entity){
		$entity->resetFallDistance();
		if($entity->fireTicks > 0){
			$entity->extinguish();
		}

		$entity->resetFallDistance();
	}

	public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
		$ret = $this->getLevel()->setBlock($this, $this, true, false);
		$this->getLevel()->scheduleDelayedBlockUpdate($this, $this->tickRate());

		return $ret;
	}

    public function getStillForm(): Block{
        return BlockFactory::get(Block::STILL_WATER, $this->meta);
    }

    public function getFlowingForm(): Block{
        return BlockFactory::get(Block::FLOWING_WATER, $this->meta);
    }

    public function getBucketFillSound(): int{
        return LevelSoundEventPacket::SOUND_BUCKET_FILL_WATER;
    }

    public function getBucketEmptySound(): int{
        return LevelSoundEventPacket::SOUND_BUCKET_EMPTY_WATER;
    }
}
