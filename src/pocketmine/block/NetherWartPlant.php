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

use pocketmine\event\block\BlockGrowEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;

class NetherWartPlant extends Flowable {

	protected $id = self::NETHER_WART_PLANT;

    protected $itemId = Item::NETHER_WART;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Nether Wart";
	}

    public function ticksRandomly() : bool{
        return true;
    }

	public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
        $down = $this->getSide(Vector3::SIDE_DOWN);
        if($down->getId() === Block::SOUL_SAND){
            $this->getLevel()->setBlock($blockReplace, $this, false, true);

            return true;
        }

        return false;
	}

	public function onUpdate(int $type){
        switch($type){
            case Level::BLOCK_UPDATE_RANDOM:
                if($this->meta < 3 and mt_rand(0, 10) === 0){ //Still growing
                    $block = clone $this;
                    $block->meta++;
                    $this->getLevel()->getServer()->getPluginManager()->callEvent($ev = new BlockGrowEvent($this, $block));

                    if(!$ev->isCancelled()){
                        $this->getLevel()->setBlock($this, $ev->getNewState(), false, true);

                        return $type;
                    }
                }
                break;
            case Level::BLOCK_UPDATE_NORMAL:
                if($this->getSide(Vector3::SIDE_DOWN)->getId() !== Block::SOUL_SAND){
                    $this->getLevel()->useBreakOn($this);
                    return $type;
                }
                break;
        }

		return false;
	}

	public function getDropsForCompatibleTool(Item $item) : array{
        return [
            Item::get($this->getItemId(), 0, ($this->getDamage() === 3 ? mt_rand(2, 4) : 1))
        ];
	}

    public function isAffectedBySilkTouch(): bool{
        return false;
    }
}
