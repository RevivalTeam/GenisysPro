<?php

/*
 * RakLib network library
 *
 *
 * This project is not affiliated with Jenkins Software LLC nor RakNet.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 */

declare(strict_types=1);

namespace raklib\protocol;

#include <rules/RakLibPacket.h>

abstract class DataPacket extends Packet{

	/** @var EncapsulatedPacket[] */
	public $packets = [];

	/** @var int */
	public $seqNumber;

	protected function encodePayload(){
        $this->putLTriad($this->seqNumber);
		foreach($this->packets as $packet){
			$this->put($packet instanceof EncapsulatedPacket ? $packet->toBinary() : (string) $packet);
		}
	}

	public function length(){
		$length = 4;
		foreach($this->packets as $packet){
			$length += $packet instanceof EncapsulatedPacket ? $packet->getTotalLength() : strlen($packet);
		}

		return $length;
	}

    protected function decodePayload(){
		$this->seqNumber = $this->getLTriad();

		while(!$this->feof()){
            $packet = EncapsulatedPacket::fromBinary($this->buffer, false, $this->offset);
			if($packet->buffer === ''){
				break;
			}
			$this->packets[] = $packet;
		}
	}

	public function clean(){
		$this->packets = [];
		$this->seqNumber = null;

		return parent::clean();
	}
}