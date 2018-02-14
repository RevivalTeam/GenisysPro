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

namespace pocketmine\tile;

use pocketmine\nbt\tag\CompoundTag;

/**
 * This trait implements most methods in the {@link Nameable} interface. It should only be used by Tiles.
 */
trait NameableTrait{

    /**
     * @return string
     */
    abstract public function getDefaultName() : string;

    /**
     * @return CompoundTag
     */
    abstract public function getNBT() : CompoundTag;

    /**
     * @return string
     */
    public function getName() : string{
        $nbt = $this->getNBT();
        return $nbt->getString("CustomName") ?? $this->getDefaultName();
    }

    /**
     * @param string $name
     */
    public function setName(string $name){
        $nbt = $this->getNBT();
        if($name === ""){
            $nbt->removeTag("CustomName");
            return;
        }

        $nbt->setString("CustomName", $name);
    }

    /**
     * @return bool
     */
    public function hasName() : bool{
        return $this->getNBT()->hasTag("CustomName");
    }
}