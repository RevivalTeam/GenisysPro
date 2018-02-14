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

namespace pocketmine\inventory;

use pocketmine\entity\Human;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\nbt\tag\ListTag;
use pocketmine\Player;

class EnderChestInventory extends ChestInventory{

	/** @var Human|Player */
	private $owner;

	/**
	 * EnderChestInventory constructor.
	 *
	 * @param Human $owner
	 * @param null  $contents
	 */
	public function __construct(Human $owner, $contents = null){
		$this->owner = $owner;
		ContainerInventory::__construct(new Position());

		if($contents !== null){
			if($contents instanceof ListTag){ //Saved data to be loaded into the inventory
				foreach($contents as $item){
					$this->setItem($item["Slot"], Item::nbtDeserialize($item));
				}
			}else{
				throw new \InvalidArgumentException("Expecting ListTag, received " . gettype($contents));
			}
		}
	}
	
	public function getName() : string{
		return "EnderChest";
	}
	
	public function getDefaultSize() : int{
		return 27;
	}

	/**
	 * @return Human|Player
	 */
	public function getOwner(){
		return $this->owner;
	}

	/**
	 * Set the fake block menu's position to a valid tile position
	 * and send the inventory window to the owner
	 *
	 * @param Position $pos
	 */
	public function openAt(Position $pos){
		$this->getHolder()->setComponents($pos->x, $pos->y, $pos->z);
		$this->getHolder()->setLevel($pos->getLevel());
		$this->owner->addWindow($this);
	}

    /**
     * @return Position
     */
    public function getHolder(){
        return $this->holder;
    }
}