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

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\entity\Effect;
use pocketmine\entity\Living;

/**
 * Interface implemented by objects that can be consumed by mobs.
 */
interface Consumable{

    /**
     * Returns the leftover that this Consumable produces when it is consumed. For Items, this is usually air, but could
     * be an Item to add to a Player's inventory afterwards (such as a bowl).
     *
     * @return Item|Block|mixed
     */
    public function getResidue();

    /**
     * @return Effect[]
     */
    public function getAdditionalEffects() : array;

    /**
     * Called when this Consumable is consumed by mob, after standard resulting effects have been applied.
     *
     * @param Living $consumer
     */
    public function onConsume(Living $consumer);
}