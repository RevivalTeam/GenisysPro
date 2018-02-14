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

namespace pocketmine\inventory;

use pocketmine\Player;

class CraftingGrid extends BaseInventory{
    /** @var Player */
    protected $holder;

    protected $result = null;

    public function __construct(Player $holder){
        $this->holder = $holder;
        parent::__construct();
    }

    public function getGridWidth() : int{
        return 2;
    }

    public function getDefaultSize() : int{
        return $this->getGridWidth() ** 2;
    }

    public function setSize(int $size){
        throw new \BadMethodCallException("Cannot change the size of a crafting grid");
    }

    public function getName() : string{
        return "Crafting";
    }

    public function sendSlot(int $index, $target){
        //we can't send a slot of a client-sided inventory window
    }

    public function sendContents($target){
        //no way to do this
    }

    /**
     * @return Player
     */
	public function getHolder(){
        return $this->holder;
    }
}