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

namespace pocketmine\level\generator\normal\populator;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\populator\VariableAmountPopulator;
use pocketmine\utils\Random;
use pocketmine\level\generator\normal\object\Igloo as ObjectIgloo;

class Igloo extends VariableAmountPopulator{

    /** @var  ChunkManager */
    private $level;

    /*
     * Populate the chunk
     * @param $level pocketmine\level\ChunkManager
     * @param $chunkX int
     * @param $chunkZ int
     * @param $random pocketmine\utils\Random
     */
    public function populate(ChunkManager $level, $chunkX, $chunkZ, Random $random){
        $this->level = $level;
        if ($random->nextBoundedInt(100) > 30)
            return;
        $igloo = new ObjectIgloo();
        $x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
        $z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
        $y = $this->getHighestWorkableBlock($x, $z) - 1;
        if ($igloo->canPlaceObject($level, $x, $y, $z, $random))
            $igloo->placeObject($level, $x, $y, $z, $random);
    }

    /*
     * Gets the top block (y) on an x and z axes
     * @param $x int
     * @param $z int
     */
    protected function getHighestWorkableBlock($x, $z){
        for ($y = 127; $y > 0; --$y) {
            $b = $this->level->getBlockIdAt($x, $y, $z);
            if ($b === Block::DIRT or $b === Block::GRASS or $b === Block::PODZOL) {
                break;
            } elseif ($b !== 0 and $b !== Block::SNOW_LAYER) {
                return -1;
            }
        }

        return ++$y;
    }

}