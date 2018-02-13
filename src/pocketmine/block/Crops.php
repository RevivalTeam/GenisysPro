<?php

/*
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
 */

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\event\block\BlockGrowEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;

abstract class Crops extends Flowable {

	public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
        if($blockReplace->getSide(Vector3::SIDE_DOWN)->getId() === Block::FARMLAND){
            return $this->getLevel()->setBlock($blockReplace, $this, true, true);
        }

        return false;
	}

	public function onActivate(Item $item, Player $player = null) : bool{
        if($item->getId() === Item::DYE and $item->getDamage() === 0x0F){ //Bonemeal
            $block = clone $this;
            $block->meta += mt_rand(2, 5);
            if($block->meta > 7){
                $block->meta = 7;
            }

            Server::getInstance()->getPluginManager()->callEvent($ev = new BlockGrowEvent($this, $block));

            if(!$ev->isCancelled()){
                $this->getLevel()->setBlock($this, $ev->getNewState(), true, true);
            }

            $item->count--;

            return true;
        }

        return false;
	}

    public function ticksRandomly() : bool{
        return true;
    }

	/**
	 * @param int $type
	 *
	 * @return bool|int
	 */
	public function onUpdate(int $type){
        if($type === Level::BLOCK_UPDATE_NORMAL){
            if($this->getSide(Vector3::SIDE_DOWN)->getId() !== Block::FARMLAND){
                $this->getLevel()->useBreakOn($this);
                return Level::BLOCK_UPDATE_NORMAL;
            }
        }elseif($type === Level::BLOCK_UPDATE_RANDOM){
            if(mt_rand(0, 2) === 1){
                if($this->meta < 0x07){
                    $block = clone $this;
                    ++$block->meta;
                    Server::getInstance()->getPluginManager()->callEvent($ev = new BlockGrowEvent($this, $block));

                    if(!$ev->isCancelled()){
                        $this->getLevel()->setBlock($this, $ev->getNewState(), true, true);
                    }else{
                        return Level::BLOCK_UPDATE_RANDOM;
                    }
                }
            }else{
                return Level::BLOCK_UPDATE_RANDOM;
            }
        }

        return false;
	}

    public function isAffectedBySilkTouch(): bool{
        return false;
    }
}