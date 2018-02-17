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

namespace pocketmine\level;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\math\RayTraceResult;

class MovingObjectPosition{
    const TYPE_BLOCK_COLLISION = 0;
    const TYPE_ENTITY_COLLISION = 1;

    /** @var RayTraceResult */
    public $hitResult;

    /** @var int */
    public $typeOfHit;

    /** @var Entity|null */
    public $entityHit = null;
    /** @var Block|null */
    public $blockHit = null;

    protected function __construct(int $hitType, RayTraceResult $hitResult){
        $this->typeOfHit = $hitType;
        $this->hitResult = $hitResult;
    }

    /**
     * @param Block          $block
     * @param RayTraceResult $result
     *
     * @return MovingObjectPosition
     */
    public static function fromBlock(Block $block, RayTraceResult $result) : MovingObjectPosition{
        $ob = new MovingObjectPosition(self::TYPE_BLOCK_COLLISION, $result);
        $ob->blockHit = $block;
        return $ob;
    }

    /**
     * @param Entity         $entity
     *
     * @param RayTraceResult $result
     *
     * @return MovingObjectPosition
     */
    public static function fromEntity(Entity $entity, RayTraceResult $result) : MovingObjectPosition{
        $ob = new MovingObjectPosition(self::TYPE_ENTITY_COLLISION, $result);
        $ob->entityHit = $entity;

        return $ob;
    }
}