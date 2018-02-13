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
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\tile\Hopper as TileHopper;
use pocketmine\tile\Tile;

class Hopper extends Transparent {

	protected $id = self::HOPPER_BLOCK;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function getToolType() : int{
		return BlockToolType::TYPE_PICKAXE;
	}

	public function getToolHarvestLevel(): int{
        return TieredTool::TIER_WOODEN;
    }

    public function getName() : string{
		return "Hopper";
	}

	public function getHardness() : float{
		return 3;
	}

	public function onActivate(Item $item, Player $player = null) : bool{
		if($player instanceof Player){
			$t = $this->getLevel()->getTile($this);
			if($t instanceof TileHopper){
				if($t->hasLock() and !$t->checkLock($item->getCustomName())){
					$player->getServer()->getLogger()->debug($player->getName() . " attempted to open a locked hopper");
					return true;
				}

				$player->addWindow($t->getInventory());
			}
		}
		return true;
	}

	/**
	 *
	 */
	public function activate(){
		//TODO: Hopper content freezing (requires basic redstone system upgrade)
	}

	public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
		$faces = [
			0 => 0,
			1 => 0,
			2 => 3,
			3 => 2,
			4 => 5,
			5 => 4
		];
		$this->meta = $faces[$face];
		$this->getLevel()->setBlock($blockReplace, $this, true, true);

		Tile::createTile(Tile::HOPPER, $this->getLevel(), TileHopper::createNBT($this, $face, $item, $player));

		return true;
	}
}
