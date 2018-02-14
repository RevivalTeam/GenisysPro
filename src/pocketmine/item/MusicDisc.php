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

namespace pocketmine\item;

abstract class MusicDisc extends Item{
	
	const NO_RECORD = 0;

    /**
     * MusicDisc constructor.
     *
     * @param int $discId
     * @param string $name
     */
	public function __construct($discId, $name = "Music Disc"){
		parent::__construct($this->verifyDisc($discId), 0, $name);
	}
	
	public function verifyDisc(int $discId) : int{
		if($discId >= 500 and $discId <= 511){
			return $discId;
		}
		return 500;
	}
	
	public function getRecordId() : int{
		return 90 + ($this->id - 500);
	}

	public function getSoundId(){
        return 90 + ($this->getRecordId() - 2256);
    }
	
	public function getRecordName() : string{
		return str_ireplace("Music Disc ", "", $this->getName()); // to easy :D
	}
}