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

class ByteArrayTag extends NamedTag{

    /**
     * ByteArrayTag constructor.
     *
     * @param string $name
     * @param string $value
     */
    public function __construct(string $name = "", string $value = ""){
        parent::__construct($name, $value);
    }

    public function getType() : int{
        return NBT::TAG_ByteArray;
    }

    public function read(NBTStream $nbt){
        $this->value = $nbt->get($nbt->getInt());
    }

    public function write(NBTStream $nbt){
        $nbt->putInt(strlen($this->value));
        $nbt->put($this->value);
    }

    /**
     * @return string
     */
    public function &getValue() : string{
        return parent::getValue();
    }

    /**
     * @param string $value
     *
     * @throws \TypeError
     */
    public function setValue($value){
        if(!is_string($value)){
            throw new \TypeError("ByteArrayTag value must be of type string, " . gettype($value) . " given");
        }
        parent::setValue($value);
    }
}