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
use pocketmine\command\overload\CommandParameter;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\event\TranslationContainer;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class ClearInventoryCommand extends VanillaCommand{

    public function __construct($name){
        parent::__construct(
            $name,
            "%pocketmine.command.clearinv.description",
            "%pocketmine.command.clearinv.usage"
        );
        $this->setPermission("pocketmine.command.clearinv");

        $this->getOverload("default")->setParameter(0, new CommandParameter("player", CommandParameter::TYPE_TARGET, true));
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$this->canExecute($sender)){
            return true;
        }

        if(count($args) == 0){
            if(!($sender instanceof Player)){
                throw new InvalidCommandSyntaxException();
            }else{
                $sender->getInventory()->clearAll();
                $sender->sendMessage(new TranslationContainer(TextFormat::GREEN . "%pocketmine.command.clearinv.success"));
                return true;
            }
        }else{
            $player = implode(" ", $args);
            $player = $sender->getServer()->getPlayer($player);
            if($player != null){
                $player->getInventory()->clearAll();
                $player->sendMessage(new TranslationContainer(TextFormat::RED . "%pocketmine.command.clearinv.success"));
                $sender->sendMessage(new TranslationContainer(TextFormat::GREEN . "%pocketmine.command.clearinv.cleared", [$player->getName()]));
            }else{
                $sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));
                return true;
            }
        }

        return true;
    }
}