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

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;

class Banner extends Spawnable{

    const TAG_BASE = "Base";
    const TAG_PATTERNS = "Patterns";
    const TAG_PATTERN_COLOR = "Color";
    const TAG_PATTERN_NAME = "Pattern";

    const PATTERN_BOTTOM_STRIPE = "bs";
	const PATTERN_TOP_STRIPE = "ts";
	const PATTERN_LEFT_STRIPE = "ls";
	const PATTERN_RIGHT_STRIPE = "rs";
	const PATTERN_CENTER_STRIPE = "cs";
	const PATTERN_MIDDLE_STRIPE = "ms";
	const PATTERN_DOWN_RIGHT_STRIPE = "drs";
	const PATTERN_DOWN_LEFT_STRIPE = "dls";
	const PATTERN_SMALL_STRIPES = "ss";
	const PATTERN_DIAGONAL_CROSS = "cr";
	const PATTERN_SQUARE_CROSS = "sc";
	const PATTERN_LEFT_OF_DIAGONAL = "ld";
	const PATTERN_RIGHT_OF_UPSIDE_DOWN_DIAGONAL = "rud";
	const PATTERN_LEFT_OF_UPSIDE_DOWN_DIAGONAL = "lud";
	const PATTERN_RIGHT_OF_DIAGONAL = "rd";
	const PATTERN_VERTICAL_HALF_LEFT = "vh";
	const PATTERN_VERTICAL_HALF_RIGHT = "vhr";
	const PATTERN_HORIZONTAL_HALF_TOP = "hh";
	const PATTERN_HORIZONTAL_HALF_BOTTOM = "hhb";
	const PATTERN_BOTTOM_LEFT_CORNER = "bl";
	const PATTERN_BOTTOM_RIGHT_CORNER = "br";
	const PATTERN_TOP_LEFT_CORNER = "tl";
	const PATTERN_TOP_RIGHT_CORNER = "tr";
	const PATTERN_BOTTOM_TRIANGLE = "bt";
	const PATTERN_TOP_TRIANGLE = "tt";
	const PATTERN_BOTTOM_TRIANGLE_SAWTOOTH = "bts";
	const PATTERN_TOP_TRIANGLE_SAWTOOTH = "tts";
	const PATTERN_MIDDLE_CIRCLE = "mc";
	const PATTERN_MIDDLE_RHOMBUS = "mr";
	const PATTERN_BORDER = "bo";
	const PATTERN_CURLY_BORDER = "cbo";
	const PATTERN_BRICK = "bri";
	const PATTERN_GRADIENT = "gra";
	const PATTERN_GRADIENT_UPSIDE_DOWN = "gru";
	const PATTERN_CREEPER = "cre";
	const PATTERN_SKULL = "sku";
	const PATTERN_FLOWER = "flo";
	const PATTERN_MOJANG = "moj";

	const COLOR_BLACK = 0;
	const COLOR_RED = 1;
	const COLOR_GREEN = 2;
	const COLOR_BROWN = 3;
	const COLOR_BLUE = 4;
	const COLOR_PURPLE = 5;
	const COLOR_CYAN = 6;
	const COLOR_LIGHT_GRAY = 7;
	const COLOR_GRAY = 8;
	const COLOR_PINK = 9;
	const COLOR_LIME = 10;
	const COLOR_YELLOW = 11;
	const COLOR_LIGHT_BLUE = 12;
	const COLOR_MAGENTA = 13;
	const COLOR_ORANGE = 14;
	const COLOR_WHITE = 15;

	public function __construct(Level $level, CompoundTag $nbt){
        if(!$nbt->hasTag(self::TAG_BASE, IntTag::class)){
            $nbt->setInt(self::TAG_BASE, 0);
        }
        if(!$nbt->hasTag(self::TAG_PATTERNS, ListTag::class)){
            $nbt->setTag(new ListTag(self::TAG_PATTERNS));
        }
		
		parent::__construct($level, $nbt);
	}
	
	public function addAdditionalSpawnData(CompoundTag $nbt){
        $nbt->setTag($this->namedtag->getTag(self::TAG_PATTERNS));
        $nbt->setTag($this->namedtag->getTag(self::TAG_BASE));
	}

    /**
     * Returns the color of the banner base.
     *
     * @return int
     */
	public function getBaseColor(){
        return $this->namedtag->getInt(self::TAG_BASE, 0);
	}

    /**
     * Sets the color of the banner base.
     *
     * @param int $color
     */
    public function setBaseColor(int $color) {
        $this->namedtag->setInt(self::TAG_BASE, $color & 0x0f);
        $this->onChanged();
    }

    /**
     * Returns an array containing all pattern IDs
     *
     * @return array
     */
    public function getPatternIds() : array{
        $keys = array_keys((array) $this->namedtag->getTag(self::TAG_PATTERNS));
        return array_filter($keys, function(string $key){
            return is_numeric($key);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Applies a new pattern on the banner with the given color.
     *
     * @param string $pattern
     * @param int    $color
     *
     * @return int ID of pattern.
     */
    public function addPattern(string $pattern, int $color) : int{
        $patternId = 0;
        if($this->getPatternCount() !== 0){
            $patternId = max($this->getPatternIds()) + 1;
        }

        $list = $this->namedtag->getListTag(self::TAG_PATTERNS);
        assert($list !== null);
        $list[$patternId] = new CompoundTag("", [
            new IntTag(self::TAG_PATTERN_COLOR, $color & 0x0f),
            new StringTag(self::TAG_PATTERN_NAME, $pattern)
        ]);

        $this->onChanged();
        return $patternId;
    }

    /**
     * Returns whether a pattern with the given ID exists on the banner or not.
     *
     * @param int $patternId
     *
     * @return bool
     */
    public function patternExists(int $patternId) : bool{
        return isset($this->namedtag->getListTag(self::TAG_PATTERNS)[$patternId]);
    }

    /**
     * Returns the data of a pattern with the given ID.
     *
     * @param int $patternId
     *
     * @return array
     */
    public function getPatternData(int $patternId) : array{
        if(!$this->patternExists($patternId)){
            return [];
        }

        $list = $this->namedtag->getListTag(self::TAG_PATTERNS);
        assert($list instanceof ListTag);
        $patternTag = $list[$patternId];
        assert($patternTag instanceof CompoundTag);

        return [
            self::TAG_PATTERN_COLOR => $patternTag->getInt(self::TAG_PATTERN_COLOR),
            self::TAG_PATTERN_NAME => $patternTag->getString(self::TAG_PATTERN_NAME)
        ];
    }

    /**
     * Changes the pattern of a previously existing pattern.
     *
     * @param int    $patternId
     * @param string $pattern
     * @param int    $color
     *
     * @return bool indicating success.
     */
    public function changePattern(int $patternId, string $pattern, int $color) : bool{
        if(!$this->patternExists($patternId)){
            return false;
        }

        $list = $this->namedtag->getListTag(self::TAG_PATTERNS);
        assert($list instanceof ListTag);

        $list[$patternId] = new CompoundTag("", [
            new IntTag(self::TAG_PATTERN_COLOR, $color & 0x0f),
            new StringTag(self::TAG_PATTERN_NAME, $pattern)
        ]);

        $this->onChanged();
        return true;
    }

    /**
     * Deletes a pattern from the banner with the given ID.
     *
     * @param int $patternId
     *
     * @return bool indicating whether the pattern existed or not.
     */
    public function deletePattern(int $patternId) : bool{
        if(!$this->patternExists($patternId)){
            return false;
        }

        $list = $this->namedtag->getListTag(self::TAG_PATTERNS);
        if($list !== null){
            unset($list[$patternId]);
        }

        $this->onChanged();
        return true;
    }

    /**
     * Deletes the top most pattern of the banner.
     *
     * @return bool indicating whether the banner was empty or not.
     */
    public function deleteTopPattern() : bool{
        $keys = $this->getPatternIds();
        if(empty($keys)){
            return false;
        }

        return $this->deletePattern(max($keys));
    }

    /**
     * Deletes the bottom pattern of the banner.
     *
     * @return bool indicating whether the banner was empty or not.
     */
    public function deleteBottomPattern() : bool{
        $keys = $this->getPatternIds();
        if(empty($keys)){
            return false;
        }

        return $this->deletePattern(min($keys));
    }
	
	public function getPatternCount(){
		return count($this->getPatternIds());
	}

    /**
     * @param CompoundTag $nbt
     * @param Vector3 $pos
     * @param null $face
     * @param Item|null $item
     * @param null $player
     */
    protected static function createAdditionalNBT(CompoundTag $nbt, Vector3 $pos, $face = null, $item = null, $player = null){
        $nbt->setInt(self::TAG_BASE, $item !== null ? $item->getDamage() & 0x0f : 0);

        if($item !== null){
            if($item->getNamedTag()->hasTag(self::TAG_PATTERNS, ListTag::class)){
                $nbt->setTag($item->getNamedTag()->getListTag(self::TAG_PATTERNS));
            }
            if($item->hasCustomName()){
                $nbt->setString("CustomName", $item->getCustomName());
            }
        }
    }
}
