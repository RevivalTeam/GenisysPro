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

namespace pocketmine\entity\neutral;

use pocketmine\entity\Monster;
use pocketmine\entity\behavior\{StrollBehavior, RandomLookaroundBehavior, LookAtPlayerBehavior, PanicBehavior};

class Enderman extends Monster {
	const NETWORK_ID = self::ENDERMAN;

	public $width = 0.3;
	public $height = 0;
	public $drag = 0.2;
	public $gravity = 0.3;
	
	public function initEntity(){
		$this->addBehavior(new PanicBehavior($this, 0.25, 2.0));
		$this->addBehavior(new StrollBehavior($this));
		$this->addBehavior(new LookAtPlayerBehavior($this));
		$this->addBehavior(new RandomLookaroundBehavior($this));
		parent::initEntity();
	}
	/**
	 * @return string
	 */
	public function getName() : string{
		return "Enderman";
	}

    public function getXpDropAmount(): int{
        return 5;
    }
}