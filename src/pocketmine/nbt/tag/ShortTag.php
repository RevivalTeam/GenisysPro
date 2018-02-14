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

namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;
use pocketmine\nbt\NBTStream;

#include <rules/NBT.h>

class ShortTag extends NamedTag{

    /**
     * ShortTag constructor.
     *
     * @param string $name
     * @param int    $value
     */
    public function __construct(string $name = "", int $value = 0){
        parent::__construct($name, $value);
    }

    public function getType() : int{
        return NBT::TAG_Short;
    }

    public function read(NBTStream $nbt){
        $this->value = $nbt->getSignedShort();
    }

    public function write(NBTStream $nbt){
        $nbt->putShort($this->value);
    }

    /**
     * @return int
     */
    public function &getValue() : int{
        return parent::getValue();
    }

    /**
     * @param int $value
     *
     * @throws \TypeError
     */
    public function setValue($value){
        if(!is_int($value)){
            throw new \TypeError("ShortTag value must be of type int, " . gettype($value) . " given");
        }elseif($value < -(2 ** 15) or $value > ((2 ** 15) - 1)){
            throw new \InvalidArgumentException("Value $value is too large!");
        }
        parent::setValue($value);
    }
}