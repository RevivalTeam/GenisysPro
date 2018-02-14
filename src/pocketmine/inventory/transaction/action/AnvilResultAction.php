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

namespace pocketmine\inventory\transaction\action;

use pocketmine\block\Block;
use pocketmine\inventory\AnvilInventory;
use pocketmine\item\Item;
use pocketmine\Player;

class AnvilResultAction extends InventoryAction{

    /** @var AnvilInventory */
    public $inventory;

    public function __construct(AnvilInventory $inventory, Item $sourceItem, Item $targetItem){
        parent::__construct($sourceItem, $targetItem);
        $this->inventory = $inventory;
    }

    public function isValid(Player $source): bool{
        return true;
    }

    public function execute(Player $source): bool{
        return $this->inventory->setItem(1, Item::get(Block::AIR), false);
    }

    public function onExecuteSuccess(Player $source){
    }

    public function onExecuteFail(Player $source){
    }

    public function getInventory(): AnvilInventory{
        return $this->inventory;
    }
}