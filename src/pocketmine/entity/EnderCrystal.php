<?php

namespace pocketmine\entity;

use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\level\Explosion;

class EnderCrystal extends Living implements Explosive{
	const NETWORK_ID = 71;

	public $height = 0.98;
	public $width = 0.98;
	public $length = 0.98;

	public function initEntity(){
		$this->setMaxHealth(1);
		parent::initEntity();
	}

	public function getName(): string{
		return "Ender Crystal";
	}

	public function kill(){
		if (!$this->isAlive()){
			return;
		}
		$this->explode();
		if (!$this->closed){
			$this->close();
		}
	}

	protected function applyGravity(){ }

	public function explode(){
		$this->server->getPluginManager()->callEvent($ev = new ExplosionPrimeEvent($this, 6));

		if (!$ev->isCancelled()){
			$pos = $this->asPosition();
			$explosion = new Explosion($pos, $ev->getForce(), $this);
			$this->close();
			if ($ev->isBlockBreaking()){
				$explosion->explodeA();
			}
			$explosion->explodeB();
		}
	}
}
