<?php

/*
 *
 *    _______                                _
 *   |__   __|                              | |
 *      | | ___  ___ ___  ___ _ __ __ _  ___| |_
 *      | |/ _ \/ __/ __|/ _ \  __/ _` |/ __| __|
 *      | |  __/\__ \__ \  __/ | | (_| | (__| |_
 *      |_|\___||___/___/\___|_|  \__,_|\___|\__|
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Tesseract Team
 * @link http://www.github.com/TesseractTeam/Tesseract
 * 
 *
 */

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

class PlaySoundPacket extends DataPacket {

	const NETWORK_ID = ProtocolInfo::PLAY_SOUND_PACKET;

	public $sound;
	public $x;
	public $y;
	public $z;
	public $volume = 1.0;
	public $pitch = 1.0;

	/**
	 *
	 */
	public function decode(){
		$this->sound = $this->getString();
		$this->getBlockCoords($this->x / 8, $this->y / 8, $this->z / 8);
		$this->volume = $this->getLFloat();
		$this->pitch = $this->getLFloat();
	}

	/**
	 *
	 */
	public function encode(){
		$this->reset();
		$this->putString($this->sound);
		$this->putBlockCoords($this->x * 8, $this->y * 8, $this->z * 8);
		$this->putLFloat($this->volume);
		$this->putLFloat($this->pitch);
	}

	/**
	 * @return PacketName|string
	 */
	public function getName(){
		return "PlaySoundPacket";
	}

}
