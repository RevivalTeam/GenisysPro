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
use pocketmine\level\Level;

class DifficultyCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.difficulty.description",
			"%commands.difficulty.usage"
		);
		$this->setPermission("pocketmine.command.difficulty");

        $this->getOverload("default")->setParameter(0, new CommandParameter("1|2|3", CommandParameter::TYPE_INT, false));
	}

	public function execute(CommandSender $sender, string $currentAlias, array $args){
		if(!$this->canExecute($sender)){
			return true;
		}

		if(count($args) !== 1){
            throw new InvalidCommandSyntaxException();
		}

		$difficulty = Level::getDifficultyFromString($args[0]);

		if($sender->getServer()->isHardcore()){
			$difficulty = Level::DIFFICULTY_HARD;
		}

		if($difficulty !== -1){
			$sender->getServer()->setConfigInt("difficulty", $difficulty);

            //TODO: add per-world support
            foreach($sender->getServer()->getLevels() as $level){
                $level->setDifficulty($difficulty);
            }

			Command::broadcastCommandMessage($sender, new TranslationContainer("commands.difficulty.success", [$difficulty]));
		}else{
            throw new InvalidCommandSyntaxException();
		}

		return true;
	}
}
