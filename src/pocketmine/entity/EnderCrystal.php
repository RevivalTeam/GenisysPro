<?php
namespace pocketmine\entity;

use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\level\Explosion;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class EnderCrystal extends Living implements Explosive{
	const NETWORK_ID = 71;

	public $height = 1;
	public $width = 1;
	public $length = 1;//TODO: Size
	protected $maxHealth = 1;
	
	public function __construct(Level $level, CompoundTag $nbt){
		parent::__construct($level, $nbt);
	}

	public function initEntity(){
		parent::initEntity();
	}

	public function getName(){
		return "Ender Crystal";
	}

	public function kill(){
		if(!$this->isAlive()){
			return;
		}
		$this->explode();
		if(!$this->closed){
			$this->close();
		}
	}

	public function setMotion(Vector3 $motion) {
		return;
	}

	public function explode(){
		$this->server->getPluginManager()->callEvent($ev = new ExplosionPrimeEvent($this, 6));

		if(!$ev->isCancelled()){
			$explosion = new Explosion($this, $ev->getForce(), $this);
			if($ev->isBlockBreaking()){
				$explosion->explodeA();
			}
			$explosion->explodeB();
		}
		$this->close();
	}

	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->type = self::NETWORK_ID;
		$pk->entityRuntimeId = $this->getId();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
}
