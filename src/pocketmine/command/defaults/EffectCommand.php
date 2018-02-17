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
use pocketmine\entity\Effect;
use pocketmine\event\TranslationContainer;
use pocketmine\utils\TextFormat;

class EffectCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.effect.description",
			"%command.effect.usage"
		);
		$this->setPermission("pocketmine.command.effect;pocketmine.command.effect.other");

		// TODO : OPTIMIZE ENUMS AND ADD OTHER ARGS
        $this->getOverload("default")->setParameter(0, new CommandParameter("player", CommandParameter::TYPE_TARGET, false));
        $this->getOverload("default")->setParameter(1, new CommandParameter("effect", CommandParameter::TYPE_MIXED, false, CommandParameter::FLAG_ENUM, new CommandEnum("effect", ["speed", "slowness", "haste", "fatigue", "strenght", "healing", "harming", "jump", "nausea", "regeneration", "damage_resistance", "fire_resistance", "water_breathing", "invisibility", "blindness", "night_vision", "hunger", "weakness", "poison", "wither", "health_boost", "absobtion", "saturation", "levitation", "clear"])));
	}

	public function execute(CommandSender $sender, string $currentAlias, array $args){
		if(!$this->canExecute($sender)){
			return true;
		}

		if(count($args) < 2){
            throw new InvalidCommandSyntaxException();
		}

		$player = $sender->getServer()->getPlayer($args[0]);

		if($player === null){
			$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));
			return true;
		}

		if($player->getName() != $sender->getName() && !$sender->hasPermission("pocketmine.command.effect.other")){
			$sender->sendMessage("You don't have permission to give effect to other player.");
			return true;
		}

		if(strtolower($args[1]) === "clear"){
			foreach($player->getEffects() as $effect){
				$player->removeEffect($effect->getId());
			}

			$sender->sendMessage(new TranslationContainer("commands.effect.success.removed.all", [$player->getDisplayName()]));
			return true;
		}

		$effect = Effect::getEffectByName($args[1]);

		if($effect === null){
			$effect = Effect::getEffect((int) $args[1]);
		}

		if($effect === null){
			$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.effect.notFound", [(string) $args[1]]));
			return true;
		}

		$amplification = 0;

        if(count($args) >= 3){
            $duration = ((int) $args[2]) * 20; //ticks
        }else{
            $duration = $effect->getDefaultDuration();
        }

		if(count($args) >= 4){
            $amplification = (int) $args[3];
            if($amplification > 255){
                $sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.num.tooBig", [(string) $args[3], "255"]));
                return true;
            }elseif($amplification < 0){
                $sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.num.tooSmall", [(string) $args[3], "0"]));
                return true;
            }
		}

		if(count($args) >= 5){
			$v = strtolower($args[4]);
			if($v === "on" or $v === "true" or $v === "t" or $v === "1"){
				$effect->setVisible(false);
			}
		}

		if($duration === 0){
			if(!$player->hasEffect($effect->getId())){
				if(count($player->getEffects()) === 0){
					$sender->sendMessage(new TranslationContainer("commands.effect.failure.notActive.all", [$player->getDisplayName()]));
				}else{
					$sender->sendMessage(new TranslationContainer("commands.effect.failure.notActive", [$effect->getName(), $player->getDisplayName()]));
				}
				return true;
			}

            $player->removeEffect($effect->getId());
            $sender->sendMessage(new TranslationContainer("commands.effect.success.removed", [$effect->getName(), $player->getDisplayName()]));
		}else{
			$effect->setDuration($duration)->setAmplifier($amplification);

			$player->addEffect($effect);
            self::broadcastCommandMessage($sender, new TranslationContainer("%commands.effect.success", [$effect->getName(), $effect->getId(), $effect->getAmplifier(), $player->getDisplayName(), $effect->getDuration() / 20]));
		}


		return true;
	}
}
