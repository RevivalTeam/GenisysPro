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

class DoubleTag extends NamedTag{

    /**
     * DoubleTag constructor.
     *
     * @param string $name
     * @param float  $value
     */
    public function __construct(string $name = "", float $value = 0.0){
        parent::__construct($name, $value);
    }

    public function getType() : int{
        return NBT::TAG_Double;
    }

    public function read(NBTStream $nbt){
        $this->value = $nbt->getDouble();
    }

    public function write(NBTStream $nbt){
        $nbt->putDouble($this->value);
    }

    /**
     * @return float
     */
    public function &getValue() : float{
        return parent::getValue();
    }

    /**
     * @param float $value
     *
     * @throws \TypeError
     */
    public function setValue($value){
        if(!is_float($value) and !is_int($value)){
            throw new \TypeError("DoubleTag value must be of type double, " . gettype($value) . " given");
        }
        parent::setValue((float) $value);
    }
}