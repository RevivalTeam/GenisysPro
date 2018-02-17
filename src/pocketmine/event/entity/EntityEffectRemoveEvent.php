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

namespace pocketmine\event\entity;

use pocketmine\entity\Effect;
use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;

class EntityEffectRemoveEvent extends EntityEvent implements Cancellable {

	public static $handlerList = null;

	/** @var Effect */
	protected $effect;

    /**
     * EntityEffectRemoveEvent constructor.
     *
     * @param Entity $entity
     * @param Effect $effect
     */
	public function __construct(Entity $entity, Effect $effect){
		$this->entity = $entity;
		$this->effect = $effect;
	}

	/**
	 * @return Effect
	 */
	public function getEffect(){
		return $this->effect;
	}

	public function setCancelled($value = true){
        if($this->getEffect()->getDuration() <= 0){
            throw new \InvalidStateException("Removal of expired effects cannot be cancelled");
 		}
        parent::setCancelled($value);
    }
}
