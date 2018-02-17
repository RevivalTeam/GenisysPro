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

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\command\overload\CommandParameter;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class PingCommand extends VanillaCommand {

    public function __construct($name){
        parent::__construct(
            $name,
            "%pocketmine.command.ping.description",
            "%pocketmine.command.ping.usage"
        );
        $this->setPermission("pocketmine.command.ping");

        $this->getOverload("default")->setParameter(0, new CommandParameter("player", CommandParameter::TYPE_TARGET, true));
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$this->canExecute($sender)){
            return true;
        }

        $target = null;

        if(count($args) === 1){
            $target = $sender->getServer()->getPlayer($args[0]);
        }

        if($target == null){
            if($sender instanceof Player){
                $target = $sender;
            }else{
                $sender->sendMessage(TextFormat::RED . "Please provide a player!");

                return true;
            }
        }

        $ping = $target->getPing();
        $color = TextFormat::GREEN;

        if($ping >= 150 and $ping <= 250){
            $color = TextFormat::GOLD;
        }elseif($ping > 250){
            $color = TextFormat::RED;
        }

        $sender->sendMessage($target->getName()."'s Ping: ".$color.$ping."ms");
        return true;
    }
}