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

/**
 * All the NBT Tags
 */
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBTStream;

abstract class Tag extends \stdClass{

    protected $value;

    public function &getValue(){
        return $this->value;
    }

    abstract public function getType() : int;

    public function setValue($value){
        $this->value = $value;
    }

    abstract public function write(NBTStream $nbt);

    abstract public function read(NBTStream $nbt);

    public function __toString(){
        return (string) $this->value;
    }
}