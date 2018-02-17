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
use pocketmine\command\overload\CommandEnum;
use pocketmine\command\overload\CommandParameter;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\Server;


class BanListCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.banlist.description",
			"%pocketmine.command.banlist.usage"
		);
		$this->setPermission("pocketmine.command.ban.list");

        $this->getOverload("default")->setParameter(0, new CommandParameter("list", CommandParameter::TYPE_STRING, false, CommandParameter::FLAG_ENUM, new CommandEnum("from", ["ips", "cids", "players"])));
	}

	public function execute(CommandSender $sender, string $currentAlias, array $args){
		if(!$this->canExecute($sender)){
			return true;
		}

		$args[0] = (isset($args[0]) ? strtolower($args[0]) : "");

		switch($args[0]){
			case "ips":
				$list = $sender->getServer()->getIPBans();
				$title = "commands.banlist.ips";
				break;
			case "players":
				$list = $sender->getServer()->getNameBans();
				$title = "commands.banlist.players";
				break;
			default:
                throw new InvalidCommandSyntaxException();
		}

		$message = "";
		$list = $list->getEntries();
		foreach($list as $entry){
			$message .= $entry->getName() . ", ";
		}

		$sender->sendMessage(Server::getInstance()->getLanguage()->translateString($title, [count($list)]));
		$sender->sendMessage(\substr($message, 0, -2));

		return true;
	}
}