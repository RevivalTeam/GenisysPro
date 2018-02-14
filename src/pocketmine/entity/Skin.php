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

namespace pocketmine\entity;

class Skin{

	/** @var string */
	private $skinId;
	/** @var string */
	private $skinData;
	/** @var string */
	private $capeData;
	/** @var string */
	private $geometryName;
	/** @var string */
	private $geometryData;

	public function __construct(string $skinId, string $skinData, string $capeData = "", string $geometryName = "", string $geometryData = ""){
		$this->skinId = $skinId;
		$this->skinData = $skinData;
		$this->capeData = $capeData;
		$this->geometryName = $geometryName;
		$this->geometryData = $geometryData;
	}

	public function isValid() : bool{
		return (
			$this->skinId !== "" and
			(($s = strlen($this->skinData)) === 16384 or $s === 8192) and
			($this->capeData === "" or strlen($this->capeData) === 8192)
		);
	}

	/**
	 * @return string
	 */
	public function getSkinId() : string{
		return $this->skinId;
	}

	/**
	 * @return string
	 */
	public function getSkinData() : string{
		return $this->skinData;
	}

	/**
	 * @return string
	 */
	public function getCapeData() : string{
		return $this->capeData;
	}

	/**
	 * @return string
	 */
	public function getGeometryName() : string{
		return $this->geometryName;
	}

	/**
	 * @return string
	 */
	public function getGeometryData() : string{
		return $this->geometryData;
	}

    public function debloatGeometryData(){
        if($this->geometryData !== ""){
            $this->geometryData = (string) json_encode(json_decode($this->geometryData));
        }
    }

}