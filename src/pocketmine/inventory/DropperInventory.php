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

use pocketmine\tile\Dropper;
use pocketmine\network\mcpe\protocol\types\WindowTypes;

class DropperInventory extends ContainerInventory {
    /** @var Dropper */
    protected $holder;

	public function __construct(Dropper $tile){
		parent::__construct($tile);
	}
	
	public function getName() : string{
		return "Dropper";
	}
	
	public function getDefaultSize() : int{
		return 9;
	}

	/**
	 * @return Dropper
	 */
	public function getHolder(){
		return $this->holder;
	}
	
	public function getNetworkType() : int{
		return WindowTypes::DROPPER;
	}
}