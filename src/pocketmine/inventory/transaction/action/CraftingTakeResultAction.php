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

use pocketmine\inventory\transaction\CraftingTransaction;
use pocketmine\inventory\transaction\InventoryTransaction;
use pocketmine\Player;

/**
 * Action used to take the primary result item during crafting.
 */
class CraftingTakeResultAction extends InventoryAction{

    public function onAddToTransaction(InventoryTransaction $transaction){
        if($transaction instanceof CraftingTransaction){
            $transaction->setPrimaryOutput($this->getSourceItem());
        }else{
            throw new \InvalidStateException(get_class($this) . " can only be added to CraftingTransactions");
        }
    }

    public function isValid(Player $source) : bool{
        return true;
    }

    public function execute(Player $source) : bool{
        return true;
    }

    public function onExecuteSuccess(Player $source){

    }

    public function onExecuteFail(Player $source){

    }

}