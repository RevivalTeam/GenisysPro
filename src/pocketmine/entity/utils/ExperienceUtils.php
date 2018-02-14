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

namespace pocketmine\entity\utils;

use pocketmine\math\Math;

abstract class ExperienceUtils{

    /**
     * Calculates and returns the amount of XP needed to get from level 0 to level $level
     *
     * @param int $level
     * @return int
     */
    public static function getXpToReachLevel(int $level) : int{
        if($level <= 16){
            return $level ** 2 + $level * 6;
        }elseif($level <= 31){
            return (int) ($level ** 2 * 2.5 - 40.5 * $level + 360);
        }

        return (int) ($level ** 2 * 4.5 - 162.5 * $level + 2220);
    }

    /**
     * Returns the amount of XP needed to reach $level + 1.
     *
     * @param int $level
     *
     * @return int
     */
    public static function getXpToCompleteLevel(int $level) : int{
        if($level <= 15){
            return 2 * $level + 7;
        }elseif($level <= 30){
            return 5 * $level - 38;
        }else{
            return 9 * $level - 158;
        }
    }

    /**
     * Calculates and returns the number of XP levels the specified amount of XP points are worth.
     * This returns a floating-point number, the decimal part being the progress through the resulting level.
     *
     * @param int $xp
     *
     * @return float
     */
    public static function getLevelFromXp(int $xp) : float{
        if($xp <= self::getXpToReachLevel(16)){
            $a = 1;
            $b = 6;
            $c = 0;
        }elseif($xp <= self::getXpToReachLevel(31)){
            $a = 2.5;
            $b = -40.5;
            $c = 360;
        }else{
            $a = 4.5;
            $b = -162.5;
            $c = 2220;
        }

        $x = Math::solveQuadratic($a, $b, $c - $xp);

        return (float) max($x); //we're only interested in the positive solution
    }
}
