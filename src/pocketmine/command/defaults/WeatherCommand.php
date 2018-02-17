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

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\event\TranslationContainer;
use pocketmine\level\Level;
use pocketmine\level\weather\Weather;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class WeatherCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.weather.description",
			"%pocketmine.command.weather.usage"
		);
		$this->setPermission("pocketmine.command.weather");
		// TODO : ADD ENUMS
	}

	public function execute(CommandSender $sender, string $currentAlias, array $args){
		if(!$this->canExecute($sender)){
			return true;
		}

		if(count($args) < 1){
            throw new InvalidCommandSyntaxException();
		}

		if($sender instanceof Player){
		    if(is_int($args[0])){
		        $wea = Weather::isWeather($args[0]) ? $args[0] : Weather::SUNNY;
            }else{
                $wea = Weather::getWeatherFromString($args[0]);
            }
			if(Weather::isWeather($wea)){
				$sender->getLevel()->getWeather()->setWeather($wea);
				$sender->sendMessage(new TranslationContainer("pocketmine.command.weather.changed", [$sender->getLevel()->getFolderName()]));
				return true;
			}else{
				$sender->sendMessage(TextFormat::RED . "%pocketmine.command.weather.invalid");
				return false;
			}
		}

		if(count($args) < 2){
            throw new InvalidCommandSyntaxException();
		}

		$level = $sender->getServer()->getLevelByName($args[0]);
		if(!$level instanceof Level){
			$sender->sendMessage(TextFormat::RED . "%pocketmine.command.weather.invalid.level");
			return false;
		}

        if(is_int($args[1])){
            $wea = Weather::isWeather($args[1]) ? $args[1] : Weather::SUNNY;
        }else{
            $wea = Weather::getWeatherFromString($args[1]);
        }
		if(Weather::isWeather($wea)){
			$level->getWeather()->setWeather($wea);
			$sender->sendMessage(new TranslationContainer("pocketmine.command.weather.changed", [$level->getFolderName()]));
			return true;
		}else{
			$sender->sendMessage(TextFormat::RED . "%pocketmine.command.weather.invalid");
			return false;
		}
	}
}
