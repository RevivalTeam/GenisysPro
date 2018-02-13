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

use pocketmine\item\TieredTool;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;

class SnowLayer extends Flowable{

	protected $id = self::SNOW_LAYER;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Snow Layer";
	}

	public function canBeReplaced() : bool{
		return true;
	}

	public function getHardness() : float{
		return 0.1;
	}

	public function getToolType() : int{
		return BlockToolType::TYPE_SHOVEL;
	}

    public function getToolHarvestLevel() : int{
        return TieredTool::TIER_WOODEN;
    }

	public function ticksRandomly(): bool{
        return true;
    }

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
        if($blockReplace->getSide(Vector3::SIDE_DOWN)->isSolid()){
            //TODO: fix placement
            $this->getLevel()->setBlock($blockReplace, $this, true);

            return true;
        }

        return false;
	}

	public function onUpdate(int $type){
        if($type === Level::BLOCK_UPDATE_NORMAL){
            if(!$this->getSide(Vector3::SIDE_DOWN)->isSolid()){
                $this->getLevel()->setBlock($this, BlockFactory::get(Block::AIR), false, false);

                return Level::BLOCK_UPDATE_NORMAL;
            }
        }elseif($type === Level::BLOCK_UPDATE_RANDOM){
            if($this->level->getBlockLightAt($this->x, $this->y, $this->z) >= 12){
                $this->getLevel()->setBlock($this, BlockFactory::get(Block::AIR), false, false);

                return Level::BLOCK_UPDATE_RANDOM;
            }
        }

        return false;
	}

	public function getDropsForCompatibleTool(Item $item): array{
        return [
            Item::get(Item::SNOWBALL) //TODO: check layer count
        ];
    }

    public function isAffectedBySilkTouch(): bool{
        return false;
    }
}