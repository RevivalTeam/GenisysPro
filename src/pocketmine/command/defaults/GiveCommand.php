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
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\event\TranslationContainer;
use pocketmine\item\Item;
use pocketmine\nbt\JsonNBTParser;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\command\overload\CommandParameter;

class GiveCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.give.description",
			"%pocketmine.command.give.usage"
		);
		$this->setPermission("pocketmine.command.give");
		
		$this->getOverload("default")->setParameter(0, new CommandParameter("player", CommandParameter::TYPE_TARGET, false));
		$this->getOverload("default")->setParameter(1, new CommandParameter("item", CommandParameter::TYPE_STRING, false));
		$this->getOverload("default")->setParameter(2, new CommandParameter("amount", CommandParameter::TYPE_INT, true));
		$this->getOverload("default")->setParameter(3, new CommandParameter("tags", CommandParameter::TYPE_STRING, true));
	}

	public function execute(CommandSender $sender, string $currentAlias, array $args){
		if(!$this->canExecute($sender)){
			return true;
		}

		if(count($args) < 2){
            throw new InvalidCommandSyntaxException();
		}

		$player = $sender->getServer()->getPlayer($args[0]);
		$item = Item::fromString($args[1]);

		if(!isset($args[2])){
			$item->setCount($item->getMaxStackSize());
		}else{
			$item->setCount((int) $args[2]);
		}

		if(isset($args[3])){
			$tags = $exception = null;
			$data = implode(" ", array_slice($args, 3));
			try{
				$tags = JsonNBTParser::parseJSON($data);
			}catch(\Throwable $ex){
				$exception = $ex;
			}

			if(!($tags instanceof CompoundTag) or $exception !== null){
				$sender->sendMessage(new TranslationContainer("commands.give.tagError", [$exception !== null ? $exception->getMessage() : "Invalid tag conversion"]));
				return true;
			}

			$item->setNamedTag($tags);
		}

		if($player instanceof Player){
			if($item->getId() === 0){
				$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.give.item.notFound", [$args[1]]));

				return true;
			}

			//TODO: overflow
			$player->getInventory()->addItem(clone $item);
		}else{
			$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));

			return true;
		}

		Command::broadcastCommandMessage($sender, new TranslationContainer("%commands.give.success", [
			$item->getName() . " (" . $item->getId() . ":" . $item->getDamage() . ")",
			(string) $item->getCount(),
			$player->getName()
		]));
		return true;
	}
}