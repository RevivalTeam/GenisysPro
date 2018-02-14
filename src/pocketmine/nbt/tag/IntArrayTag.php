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

class IntArrayTag extends NamedTag{

    /**
     * IntArrayTag constructor.
     *
     * @param string $name
     * @param int[]  $value
     */
    public function __construct(string $name = "", array $value = []){
        parent::__construct($name, $value);
    }

    public function getType() : int{
        return NBT::TAG_IntArray;
    }

    public function read(NBTStream $nbt){
        $this->value = $nbt->getIntArray();
    }

    public function write(NBTStream $nbt){
        $nbt->putIntArray($this->value);
    }

    public function __toString(){
        $str = get_class($this) . "{\n";
        $str .= implode(", ", $this->value);
        return $str . "}";
    }

    /**
     * @return int[]
     */
    public function &getValue() : array{
        return parent::getValue();
    }

    /**
     * @param int[] $value
     *
     * @throws \TypeError
     */
    public function setValue($value){
        if(!is_array($value)){
            throw new \TypeError("IntArrayTag value must be of type int[], " . gettype($value) . " given");
        }
        assert(count(array_filter($value, function($v){
                return !is_int($v);
            })) === 0);

        parent::setValue($value);
    }
}