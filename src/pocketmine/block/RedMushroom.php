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

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;

class RedMushroom extends Flowable {

	protected $id = self::RED_MUSHROOM;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Red Mushroom";
	}

	public function ticksRandomly(): bool{
        return true;
    }

	public function onUpdate(int $type){
        if($type === Level::BLOCK_UPDATE_NORMAL){
            if($this->getSide(Vector3::SIDE_DOWN)->isTransparent() === true){
                $this->getLevel()->useBreakOn($this);

                return Level::BLOCK_UPDATE_NORMAL;
            }
        }

        return false;
	}

	public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
        $down = $this->getSide(Vector3::SIDE_DOWN);
        if($down->isTransparent() === false){
            $this->getLevel()->setBlock($blockReplace, $this, true, true);

            return true;
        }

        return false;
	}
}