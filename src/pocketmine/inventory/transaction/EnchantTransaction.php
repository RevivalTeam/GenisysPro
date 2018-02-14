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

namespace pocketmine\inventory\transaction;

use pocketmine\inventory\transaction\action\SlotChangeAction;

class EnchantTransaction extends InventoryTransaction{

    public function canExecute(): bool{
        $rm = [];
        foreach($this->getActions() as $action){
            if($action instanceof SlotChangeAction){
                if($action->getSlot() == -1){
                    $rm[] = $action;
                }
            }
        }

        foreach($rm as $action){
            $key = array_search($action, $this->actions);
            unset($this->actions[$key]);
        }
        $this->squashDuplicateSlotChanges();
        if (count($rm) > 0) {
            return true;
        } else {
            return parent::canExecute();
        }
    }
}