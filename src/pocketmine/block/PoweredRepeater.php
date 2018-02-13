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

use pocketmine\item\Item;
use pocketmine\Player;

class PoweredRepeater extends RedstoneDiode {
	protected $id = self::POWERED_REPEATER_BLOCK;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
		$this->isPowered = true;
	}

	public function getName() : string{
		return "Powered Repeater";
	}

	public function getStrength(){
		return 15;
	}

	public function getFacing() : int{
		$direction = 0;
		switch($this->meta % 4){
			case 0:
				$direction = 3;
				break;
			case 1:
				$direction = 4;
				break;
			case 2:
				$direction = 2;
				break;
			case 3:
				$direction = 5;
				break;
		}
		return $direction;
	}

	public function getOppositeDirection() : int{
		return static::getOppositeSide($this->getFacing());
	}

	protected function isAlternateInput(Block $block) : bool {
        return $block instanceof RedstoneDiode;
	}

	public function getDelay() : int{
		return (1 + ($this->meta >> 2)) * 2;
	}

	protected  function getPowered(): Block{
        return $this;
    }

    protected  function getUnpowered(): Block{
        return new UnpoweredRepeater($this->meta);
    }

    public function getLightLevel() : int{
        return 7;
    }

	public function onActivate(Item $item, Player $player = null) : bool{
        $this->meta += 4;
        if($this->meta > 15) $this->meta = $this->meta % 4;

        $this->level->setBlock($this, $this, true, false);
        return true;
    }

    public function isLocked(): bool{
        return $this->getPowerOnSides() > 0;
    }
}
