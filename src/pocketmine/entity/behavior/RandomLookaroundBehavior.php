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

class RandomLookaroundBehavior extends Behavior{

    public $entity;
    public $duration = 0;
    public $rotation = 0;

    public function getName() : string{
        return "RandomLookaround";
    }

    public function shouldStart() : bool{
        $shouldStart = rand(0,50) == 0;
        if(!$shouldStart) return false;

        $this->duration = 20 + rand(0,20);
        $this->rotation = rand(-180,180);

        return true;
    }

    public function canContinue() : bool{
        return $this->duration-- > 0 and abs($this->rotation) > 0;
    }

    public function onTick(){
        $this->entity->yaw += $this->signRot($this->rotation) * 10;
        $this->rotation -= 10;
    }

    public function signRot(int $val){
        if($val > 0) return 1;

        if($val < 0) return -1;

        return 0;
    }

    public function onEnd(){
    }
}