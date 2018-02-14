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


abstract class NamedTag extends Tag{
    /** @var string */
    protected $__name;

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function __construct(string $name = "", $value = null){
        $this->__name = ($name === null or $name === false) ? "" : $name;
        if($value !== null){
            $this->setValue($value);
        }
    }

    /**
     * @return string
     */
    public function getName() : string{
        return $this->__name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name){
        $this->__name = $name;
    }
}