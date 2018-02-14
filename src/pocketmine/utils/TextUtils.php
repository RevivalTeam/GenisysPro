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

namespace pocketmine\utils;

class TextUtils{

    public static function center(string $input){
        $clear = TextFormat::clean($input);
        $lines = explode("\n", $clear);
        $max = max(array_map("strlen", $lines));
        $lines = explode("\n", $input);
        foreach($lines as $key => $line){
            $lines[$key] = str_pad($line, $max + self::renkSayisi($line), " ", STR_PAD_BOTH);
        }
        return implode("\n", $lines);
    }

    public static function renkSayisi(string $yazi){
        $renkler = "abcdef0123456789lo";
        $sayi = 0;
        for($i=0; $i<strlen($renkler); $i++){
            $sayi += substr_count($yazi, "§".$renkler{$i});
        }
        return $sayi;
    }
}
