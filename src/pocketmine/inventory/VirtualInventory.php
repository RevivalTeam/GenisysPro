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
use pocketmine\tile\VirtualHolder;
use pocketmine\network\mcpe\protocol\types\WindowTypes;

class VirtualInventory extends CustomInventory {

    /** @var  VirtualHolder */
    protected $holder;

    public function __construct(VirtualHolder $tile){
        parent::__construct($tile);
    }

    public function getHolder(){
        return $this->holder;
    }

    public function onClose(Player $who){
        $this->holder->cevir($who);
        parent::onClose($who);
        $this->holder->close();
    }
    
    public function getNetworkType() : int{
    	return WindowTypes::CONTAINER;
    }

    public function getName(): string{
        return "TuranicVirtualInventory";
    }

    public function getDefaultSize(): int{
        return 27;
    }
}