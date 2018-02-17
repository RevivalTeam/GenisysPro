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

namespace pocketmine\item\enchantment;


class EnchantmentEntry {

	/** @var Enchantment[] */
	private $enchantments;
	/** @var int */
	private $cost;
	/** @var string */
	private $randomName;

	/**
	 * @param Enchantment[] $enchantments
	 * @param               $cost
	 * @param               $randomName
	 */
	public function __construct(array $enchantments, int $cost, string $randomName){
		$this->enchantments = $enchantments;
		$this->cost = $cost;
		$this->randomName = $randomName;
	}

	/**
	 * @return array|Enchantment[]
	 */
	public function getEnchantments(){
		return $this->enchantments;
	}

	/**
	 * @return int
	 */
	public function getCost(){
		return $this->cost;
	}

	public function getRandomName(){
		return $this->randomName;
	}

}