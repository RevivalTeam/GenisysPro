<?php

/*
 *
 *    _______                    _
 *   |__   __|                  (_)
 *      | |_   _ _ __ __ _ _ __  _  ___
 *      | | | | | '__/ _` | '_ \| |/ __|
 *      | | |_| | | | (_| | | | | | (__
 *      |_|\__,_|_|  \__,_|_| |_|_|\___|
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author TuranicTeam
 * @link https://github.com/TuranicTeam/Turanic
 *
 */

namespace pocketmine\level;

use pocketmine\Player;
use pocketmine\entity\Entity;
use pocketmine\entity\Mob;

/**
 * Based on MiNET
 */

class EntityManager{
	
	public $level;
	
	public function __construct(Level $level){
		$this->level = $level;
	}
	
	public function despawnMobs(int $tick){
		if($tick % 400 == 0) {
            $targetEntities = array_filter($this->level->getEntities(),
            function(Entity $e){
            	return $e instanceof Mob and count($e->getViewers()) === 0 and $e->isBehaviorsEnabled();
            }); // scan wandering mobs
            
            foreach($targetEntities as $target){
            	$target->close();
            }
        }
	}
	
	public function attemptMobs(int $tick){
		// TODO
	}
}