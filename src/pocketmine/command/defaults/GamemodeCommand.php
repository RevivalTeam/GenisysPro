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

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\overload\CommandParameter;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\event\TranslationContainer;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class GamemodeCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.gamemode.description",
			"%pocketmine.command.gamemode.usage",
			["gm"]
		);
		$this->setPermission("pocketmine.command.gamemode");

		$this->getOverload("default")->setParameter(0, new CommandParameter("gamemode", CommandParameter::TYPE_STRING, false));
		$this->getOverload("default")->setParameter(1, new CommandParameter("player", CommandParameter::TYPE_TARGET, true));
	}

	public function execute(CommandSender $sender, string $currentAlias, array $args){
		if(!$this->canExecute($sender)){
			return true;
		}

		if(count($args) === 0){
            throw new InvalidCommandSyntaxException();
		}

		$gameMode = (int) Server::getGamemodeFromString($args[0]);

		if($gameMode === -1){
			$sender->sendMessage("Unknown game mode");

			return true;
		}

		$target = $sender;
		if(isset($args[1])){
			$target = $sender->getServer()->getPlayer($args[1]);
			if($target === null){
				$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));
				return true;
			}
		}elseif(!($sender instanceof Player)){
            throw new InvalidCommandSyntaxException();
		}

		if($target->setGamemode($gameMode) == false){
			$sender->sendMessage(TextFormat::RED . "Game mode change for " . $target->getName() . " failed!");
		}else{
			if($target === $sender){
				Command::broadcastCommandMessage($sender, new TranslationContainer("commands.gamemode.success.self", [Server::getGamemodeString($gameMode)]));
			}else{
				$target->sendMessage(new TranslationContainer("gameMode.changed"));
				Command::broadcastCommandMessage($sender, new TranslationContainer("commands.gamemode.success.other", [$target->getName(), Server::getGamemodeString($gameMode)]));
			}
		}
		return true;
	}
}