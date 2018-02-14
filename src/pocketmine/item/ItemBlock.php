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

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;

/**
 * Class used for Items that can be Blocks
 */
class ItemBlock extends Item {

    /**
     * @param int      $blockId
     * @param int      $meta usually 0-15 (placed blocks may only have meta values 0-15)
     * @param int|null $itemId
     */
    public function __construct(int $blockId, int $meta = 0, int $itemId = null){
        $this->block = BlockFactory::get($blockId, $meta & 0xf);
        parent::__construct($itemId ?? $this->block->getId(), $meta, $this->block->getName());
    }

    public function setDamage(int $meta) : Item{
        $this->block->setDamage($meta !== -1 ? $meta & 0xf : 0);
        return parent::setDamage($meta);
    }

    public function getBlock() : Block{
        return clone $this->block;
    }

	public function getFuelTime(): int{
        return $this->block->getFuelTime();
    }

    public function getMaxStackSize(): int{
        return $this->block->getMaxStackSize();
    }

}