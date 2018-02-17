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

use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;

class FireworkUtils{

    /**
     * @param int $flight
     * @param CompoundTag[] $explosionTags
     * @return CompoundTag
     */
    public static function createNBT($flight = 1, array $explosionTags = []): CompoundTag{
        $tag = new CompoundTag();

        $explosions = new ListTag("Explosions", $explosionTags, NBT::TAG_Compound);

        $fireworkTag = new CompoundTag("Fireworks");
        $fireworkTag->setTag($explosions);
        $fireworkTag->setByte("Flight", 1);
        $tag->setTag($fireworkTag);

        return $tag;
    }

    public static function createExplosion(int $fireworkColor = 0, int $fireworkFade = 0, bool $fireworkFlicker = false, bool $fireworkTrait = false, int $fireworkType = -1){
        $expTag = new CompoundTag();
        $expTag->setByteArray("FireworkColor", strval($fireworkColor));
        $expTag->setByteArray("FireworkFade", strval($fireworkFade));
        $expTag->setByte("FireworkFlicker", $fireworkFlicker ? 1 : 0);
        $expTag->setByte("FireworkTrait", $fireworkTrait ? 1 : 0);
        $expTag->setByte("FireworkType", $fireworkType);
        return $expTag;
    }

}