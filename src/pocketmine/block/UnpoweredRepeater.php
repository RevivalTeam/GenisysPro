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

namespace pocketmine\block;

class UnpoweredRepeater extends PoweredRepeater {
	protected $id = self::UNPOWERED_REPEATER_BLOCK;

	public function __construct($meta = 0){
        parent::__construct($meta);
        $this->isPowered = false;
    }

    /**
	 * @return string
	 */
	public function getName() : string{
		return "Unpowered Repeater";
	}

	protected function getUnpowered(): Block{
        return $this;
    }

    protected function getPowered(): Block{
        return new PoweredRepeater($this->meta);
    }

	public function isActivated(Block $from = null){
		return false;
	}

	public function getLightLevel() : int{
        return 0;
    }
}