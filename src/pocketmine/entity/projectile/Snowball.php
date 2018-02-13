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

namespace pocketmine\entity\projectile;

use pocketmine\level\particle\ItemBreakParticle;
use pocketmine\item\Item as ItemItem;

class Snowball extends Throwable {
	const NETWORK_ID = self::SNOWBALL;

	public function hitParticles(){
        $this->level->addParticle(new ItemBreakParticle($this->add(0, 1, 0), ItemItem::get(ItemItem::SNOWBALL)));
    }
}
