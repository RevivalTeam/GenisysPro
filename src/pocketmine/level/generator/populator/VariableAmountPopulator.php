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

namespace pocketmine\level\generator\populator;

use pocketmine\utils\Random;

abstract class VariableAmountPopulator extends Populator{
    protected $baseAmount;
    protected $randomAmount;
    protected $odd;

    public function __construct(int $baseAmount = 0, int $randomAmount = 0, int $odd = 0){
        $this->baseAmount = $baseAmount;
        $this->randomAmount = $randomAmount;
        $this->odd = $odd;
    }

    public function setOdd(int $odd){
        $this->odd = $odd;
    }

    public function checkOdd(Random $random): bool{
        if ($random->nextRange(0, $this->odd) == 0) {
            return true;
        }
        return false;
    }

    public function getAmount(Random $random){
        return $this->baseAmount + $random->nextRange(0, $this->randomAmount + 1);
    }

    public final function setBaseAmount(int $baseAmount){
        $this->baseAmount = $baseAmount;
    }

    public final function setRandomAmount(int $randomAmount){
        $this->randomAmount = $randomAmount;
    }

    public function getBaseAmount(): int{
        return $this->baseAmount;
    }

    public function getRandomAmount(): int{
        return $this->randomAmount;
    }
}