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

namespace pocketmine\utils;

/**
 * from Steadfast2
 */

class Cache{
	
	private static $cache = [];
	
	public static function add($key, $value){
		self::$cache[$key] = $value;
	}
	
	public static function remove($key){
		unset(self::$cache[$key]);
	}
	
	public static function get($key){
		return self::$cache[$key] ?? null;
	}
	
	public static function clearAll(){
		self::$cache = [];
	}
}
?>