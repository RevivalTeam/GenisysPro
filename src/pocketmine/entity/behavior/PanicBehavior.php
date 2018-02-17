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

namespace pocketmine\entity\behavior;

use pocketmine\entity\Mob;

class PanicBehavior extends StrollBehavior{

    public function __construct(Mob $entity, $speed = 0.25, $speedMultiplier = 0.75){
        parent::__construct($entity, 60, $speed, $speedMultiplier);
    }

    public function shouldStart() : bool{
        return $this->entity->getLastDamageCause() != null;
    }
    
    public function onEnd(){
    	parent::onEnd();
    	$this->entity->resetLastDamageCause();
    }

}