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

namespace pocketmine\event\block;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

class BlockBreakEvent extends BlockEvent implements Cancellable {
    public static $handlerList = null;

    /** @var Player */
    protected $player;

    /** @var Item */
    protected $item;

    /** @var bool */
    protected $instaBreak = false;
    /** @var Item[] */
    protected $blockDrops = [];

    /**
     * @param Player $player
     * @param Block  $block
     * @param Item   $item
     * @param bool   $instaBreak
     * @param Item[] $drops
     */
    public function __construct(Player $player, Block $block, Item $item, bool $instaBreak = false, array $drops){
        parent::__construct($block);
        $this->item = $item;
        $this->player = $player;

        $this->instaBreak = $instaBreak;
        $this->setDrops($drops);
    }

    /**
     * Returns the player who is destroying the block.
     * @return Player
     */
    public function getPlayer() : Player{
        return $this->player;
    }

    /**
     * Returns the item used to destroy the block.
     * @return Item
     */
    public function getItem() : Item{
        return $this->item;
    }

    /**
     * Returns whether the block may be broken in less than the amount of time calculated. This is usually true for
     * creative players.
     *
     * @return bool
     */
    public function getInstaBreak() : bool{
        return $this->instaBreak;
    }

    /**
     * @param bool $instaBreak
     */
    public function setInstaBreak(bool $instaBreak){
        $this->instaBreak = $instaBreak;
    }


    /**
     * @return Item[]
     */
    public function getDrops() : array{
        return $this->blockDrops;
    }

    /**
     * @param Item[] $drops
     */
    public function setDrops(array $drops){
        $this->setDropsVariadic(...$drops);
    }

    /**
     * Variadic hack for easy array member type enforcement.
     *
     * @param Item[] ...$drops
     */
    public function setDropsVariadic(Item ...$drops){
        $this->blockDrops = $drops;
    }
}
