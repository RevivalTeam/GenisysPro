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

use pocketmine\inventory\AnvilInventory;
use pocketmine\item\Item;
use pocketmine\Player;

class AnvilInputAction extends InventoryAction{

    /** @var AnvilInventory */
    public $inventory;

    public function __construct(AnvilInventory $inventory, Item $sourceItem, Item $targetItem){
        parent::__construct($sourceItem, $targetItem);
        $this->inventory = $inventory;
    }

    public function isValid(Player $source): bool{
        $check = $this->inventory->getItem(0);
        return $check->equalsExact($this->sourceItem);
    }

    public function execute(Player $source): bool{
        return $this->inventory->setItem(0, $this->targetItem, false);
    }

    public function onExecuteSuccess(Player $source){}

    public function onExecuteFail(Player $source){}
}