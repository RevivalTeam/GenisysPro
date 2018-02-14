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

namespace pocketmine\item;

class RawSalmon extends Food{

    /**
     * RawSalmon constructor.
     *
     * @param int $meta
     */
    public function __construct(int $meta = 0){
        parent::__construct(self::RAW_SALMON, $meta, "Raw Salmon");
    }

    /**
     * @return int
     */
    public function getFoodRestore(): int{
        return 2;
    }

    /**
     * @return float
     */
    public function getSaturationRestore(): float{
        return 0.2;
    }
}