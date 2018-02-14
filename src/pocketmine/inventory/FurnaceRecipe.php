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

use pocketmine\item\Item;

class FurnaceRecipe implements Recipe{

	/** @var Item */
	private $output;

	/** @var Item */
	private $ingredient;

	/**
	 * @param Item $result
	 * @param Item $ingredient
	 */
	public function __construct(Item $result, Item $ingredient){
		$this->output = clone $result;
		$this->ingredient = clone $ingredient;
	}

	/**
	 * @param Item $item
	 */
	public function setInput(Item $item){
		$this->ingredient = clone $item;
	}

	/**
	 * @return Item
	 */
	public function getInput() : Item{
		return clone $this->ingredient;
	}

	/**
	 * @return Item
	 */
	public function getResult() : Item{
		return clone $this->output;
	}

	public function registerToCraftingManager(CraftingManager $manager){
		$manager->registerFurnaceRecipe($this);
	}
}