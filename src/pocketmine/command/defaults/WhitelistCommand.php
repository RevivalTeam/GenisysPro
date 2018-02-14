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
use pocketmine\command\overload\CommandEnum;
use pocketmine\command\overload\CommandParameter;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\event\TranslationContainer;
use pocketmine\utils\TextFormat;

class WhitelistCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.whitelist.description",
			"%pocketmine.command.whitelist.usage",
			["wl"]
		);
		$this->setPermission("pocketmine.command.whitelist.reload;pocketmine.command.whitelist.enable;pocketmine.command.whitelist.disable;pocketmine.command.whitelist.list;pocketmine.command.whitelist.add;pocketmine.command.whitelist.remove");

		$this->getOverload("default")->setParameter(0, new CommandParameter("option", CommandParameter::TYPE_STRING, false, CommandParameter::FLAG_ENUM, new CommandEnum("option", ["reload", "add", "remove", "off", "on", "list"])));
		$this->getOverload("default")->setParameter(1, new CommandParameter("player", CommandParameter::TYPE_TARGET, true));
	}

	public function execute(CommandSender $sender, string $currentAlias, array $args){
		if(!$this->canExecute($sender)){
			return true;
		}

		if(count($args) === 0 or count($args) > 2){
            throw new InvalidCommandSyntaxException();
		}

		if(count($args) === 1){
			if($this->badPerm($sender, strtolower($args[0]))){
				return false;
			}
			switch(strtolower($args[0])){
				case "reload":
					$sender->getServer()->reloadWhitelist();
					Command::broadcastCommandMessage($sender, new TranslationContainer("commands.whitelist.reloaded"));

					return true;
				case "on":
					$sender->getServer()->setConfigBool("white-list", true);
					Command::broadcastCommandMessage($sender, new TranslationContainer("commands.whitelist.enabled"));

					return true;
				case "off":
					$sender->getServer()->setConfigBool("white-list", false);
					Command::broadcastCommandMessage($sender, new TranslationContainer("commands.whitelist.disabled"));

					return true;
				case "list":
					$result = "";
					$count = 0;
					foreach($sender->getServer()->getWhitelisted()->getAll(true) as $player){
						$result .= $player . ", ";
						++$count;
					}
					$sender->sendMessage(new TranslationContainer("commands.whitelist.list", [$count, $count]));
					$sender->sendMessage(substr($result, 0, -2));

					return true;

				case "add":
                    $sender->sendMessage($sender->getServer()->getLanguage()->translateString("commands.generic.usage", ["%commands.whitelist.add.usage"]));
					return true;

				case "remove":
                    $sender->sendMessage($sender->getServer()->getLanguage()->translateString("commands.generic.usage", ["%commands.whitelist.remove.usage"]));
					return true;
			}
		}elseif(count($args) === 2){
			if($this->badPerm($sender, strtolower($args[0]))){
				return false;
			}
			switch(strtolower($args[0])){
				case "add":
					$sender->getServer()->getOfflinePlayer($args[1])->setWhitelisted(true);
					Command::broadcastCommandMessage($sender, new TranslationContainer("commands.whitelist.add.success", [$args[1]]));

					return true;
				case "remove":
					$sender->getServer()->getOfflinePlayer($args[1])->setWhitelisted(false);
					Command::broadcastCommandMessage($sender, new TranslationContainer("commands.whitelist.remove.success", [$args[1]]));

					return true;
			}
		}

		return true;
	}

	/**
	 * @param CommandSender $sender
	 * @param               $perm
	 *
	 * @return bool
	 */
	private function badPerm(CommandSender $sender, $perm){
		if(!$sender->hasPermission("pocketmine.command.whitelist.$perm")){
			$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.permission"));

			return true;
		}

		return false;
	}
}
