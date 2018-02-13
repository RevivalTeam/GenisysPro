<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\network\mcpe;

use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\network\Network;
use pocketmine\network\AdvancedSourceInterface;
use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\BatchPacket;
use pocketmine\Player;
use pocketmine\Server;
use raklib\protocol\EncapsulatedPacket;
use raklib\protocol\PacketReliability;
use raklib\RakLib;
use raklib\server\RakLibServer;
use raklib\server\ServerHandler;
use raklib\server\ServerInstance;
use raklib\utils\InternetAddress;

class RakLibInterface implements ServerInstance, AdvancedSourceInterface {

	/** @var Server */
	private $server;

	/** @var Network */
	private $network;

	/** @var RakLibServer */
	private $rakLib;

	/** @var Player[] */
	private $players = [];

	/** @var string[] */
	private $identifiers = [];

    /** @var int[] */
    private $networkLatency = [];

	/** @var int[] */
	private $identifiersACK = [];

	/** @var ServerHandler */
	private $interface;

	/**
	 * RakLibInterface constructor.
	 *
	 * @param Server $server
	 */
	public function __construct(Server $server){
		$this->server = $server;

		$this->rakLib = new RakLibServer(
		    $this->server->getLogger(),
            $this->server->getLoader(),
            new InternetAddress($this->server->getIp() === "" ? "0.0.0.0" : $this->server->getIp(), $this->server->getPort(), 4),
            (int) $this->server->getProperty("network.max-mtu-size", 1492));
		$this->interface = new ServerHandler($this->rakLib, $this);
	}

	/**
	 * @param Network $network
	 */
	public function setNetwork(Network $network){
		$this->network = $network;
	}

	/**
	 * @return bool
	 * @throws \Exception
	 */
	public function process() : bool{
		$work = false;
		if($this->interface->handlePacket()){
			$work = true;
			$lasttime = time();
			while($this->interface->handlePacket()){
				$diff = time() - $lasttime;
				if($diff >= 1) break;
			}
		}

		if(!$this->rakLib->isRunning() and !$this->rakLib->isShutdown()){
			$this->network->unregisterInterface($this);

			throw new \Exception("RakLib Thread crashed");
		}

		return $work;
	}

	/**
	 * @param string $identifier
	 * @param string $reason
	 */
	public function closeSession($identifier, $reason){
		if(isset($this->players[$identifier])){
			$player = $this->players[$identifier];
			unset($this->identifiers[spl_object_hash($player)]);
			unset($this->players[$identifier]);
			unset($this->networkLatency[spl_object_hash($player)]);
			unset($this->identifiersACK[$identifier]);
			$player->close($player->getLeaveMessage(), $reason);
		}
	}

	/**
	 * @param Player $player
	 * @param string $reason
	 */
	public function close(Player $player, string $reason = "unknown reason"){
		if(isset($this->identifiers[$h = spl_object_hash($player)])){
			unset($this->players[$this->identifiers[$h]]);
			unset($this->identifiersACK[$this->identifiers[$h]]);
            $this->interface->closeSession($this->identifiers[$h], $reason);
            unset($this->networkLatency[$h]);
            unset($this->identifiers[$h]);
        }
	}

	public function start(){
	    $this->rakLib->start();
    }

	public function shutdown(){
		$this->interface->shutdown();
	}

	public function emergencyShutdown(){
		$this->interface->emergencyShutdown();
	}

	/**
	 * @param string     $identifier
	 * @param string     $address
	 * @param int        $port
	 * @param int|string $clientID
	 */
	public function openSession($identifier, $address, $port, $clientID){
		$ev = new PlayerCreationEvent($this, Player::class, Player::class, null, $address, $port);
		$this->server->getPluginManager()->callEvent($ev);
		$class = $ev->getPlayerClass();

		$player = new $class($this, $ev->getClientId(), $ev->getAddress(), $ev->getPort());
		$this->players[$identifier] = $player;
		$this->identifiersACK[$identifier] = 0;
		$this->identifiers[spl_object_hash($player)] = $identifier;
		$this->networkLatency[spl_object_hash($player)] = 0;
		$this->server->addPlayer($identifier, $player);
	}

    /**
     * @param string $identifier
     * @param EncapsulatedPacket $packet
     * @param int $flags
     */
	public function handleEncapsulated($identifier, EncapsulatedPacket $packet, $flags){
        if(isset($this->players[$identifier])){
            //get this now for blocking in case the player was closed before the exception was raised
            $address = $this->players[$identifier]->getAddress();
            try{
                if ($packet->buffer !== "") {
                    $pk = $this->getPacket($packet->buffer);
                    $this->players[$identifier]->handleDataPacket($pk);
                }
            }catch (\Throwable $e){
                $logger = $this->server->getLogger();
                $logger->debug("Packet " . (isset($pk) ? get_class($pk) : "unknown") . " 0x" . bin2hex($packet->buffer));
                $logger->logException($e);
                $this->interface->blockAddress($address, 5);
            }
        }
    }

	/**
	 * @param string $address
	 * @param int    $timeout
	 */
	public function blockAddress(string $address, int $timeout = 300){
		$this->interface->blockAddress($address, $timeout);
	}

	/**
	 * @param $address
	 */
	public function unblockAddress(string $address){
		$this->interface->unblockAddress($address);
	}

	/**
	 * @param string $address
	 * @param int    $port
	 * @param string $payload
	 */
	public function handleRaw($address, $port, $payload){
		$this->server->handlePacket($address, $port, $payload);
	}

	/**
	 * @param string $address
	 * @param int    $port
	 * @param string $payload
	 */
	public function sendRawPacket(string $address, int $port, string $payload){
		$this->interface->sendRaw($address, $port, $payload);
	}

	/**
	 * @param string $identifier
	 * @param int    $identifierACK
	 */
	public function notifyACK($identifier, $identifierACK){

	}

    public function setName(string $name){

        if($this->server->isDServerEnabled()){
            if($this->server->dserverConfig["motdMaxPlayers"] > 0) $pc = $this->server->dserverConfig["motdMaxPlayers"];
            elseif($this->server->dserverConfig["motdAllPlayers"]) $pc = $this->server->getDServerMaxPlayers();
            else $pc = $this->server->getMaxPlayers();
            if($this->server->dserverConfig["motdPlayers"]) $poc = $this->server->getDServerOnlinePlayers();
            else $poc = count($this->server->getOnlinePlayers());
        }else{
            $info = $this->server->getQueryInformation();
            $pc = $info->getMaxPlayerCount();
            $poc = $info->getPlayerCount();
        }

        $this->interface->sendOption("name", implode(";",
                [
                    "MCPE",
                    rtrim(addcslashes($name, ";"), '\\'),
                    ProtocolInfo::CURRENT_PROTOCOL,
                    ProtocolInfo::MINECRAFT_VERSION_NETWORK,
                    $poc,
                    $pc,
                    $this->rakLib->getServerId(),
                    $this->server->getName(),
                    Server::getGamemodeString($this->server->getGamemode())
                ]) . ";"
        );
    }

	/**
	 * @param $name
	 */
	public function setPortCheck($name){
		$this->interface->sendOption("portChecking", (bool) $name);
	}

	/**
	 * @param string $name
	 * @param string $value
	 */
	public function handleOption($name, $value){
		if($name === "bandwidth"){
			$v = unserialize($value);
			$this->network->addStatistics($v["up"], $v["down"]);
		}
	}

	/**
	 * @param Player     $player
	 * @param DataPacket $packet
	 * @param bool       $needACK
	 * @param bool       $immediate
	 *
	 * @return int|null
	 */
	public function putPacket(Player $player, DataPacket $packet, bool $needACK = false, bool $immediate = true){
		if(isset($this->identifiers[$h = spl_object_hash($player)])){
			$identifier = $this->identifiers[$h];
			
			if(!$packet->isEncoded){
			    $packet->encode();
			}

			if($packet instanceof BatchPacket){
				if($needACK){
					$pk = new EncapsulatedPacket();
                    $pk->identifierACK = $this->identifiersACK[$identifier]++;
					$pk->buffer = $packet->buffer;
					$pk->reliability = PacketReliability::RELIABLE_ORDERED;
					$pk->orderChannel = 0;
				}else{
					if(!isset($packet->__encapsulatedPacket)){
						$packet->__encapsulatedPacket = new CachedEncapsulatedPacket;
						$packet->__encapsulatedPacket->identifierACK = null;
						$packet->__encapsulatedPacket->buffer = $packet->buffer; // #blameshoghi
						$packet->__encapsulatedPacket->reliability = PacketReliability::RELIABLE_ORDERED;
						$packet->__encapsulatedPacket->orderChannel = 0;
					}
					$pk = $packet->__encapsulatedPacket;
				}

				$this->interface->sendEncapsulated($identifier, $pk, ($needACK === true ? RakLib::FLAG_NEED_ACK : 0) | ($immediate === true ? RakLib::PRIORITY_IMMEDIATE : RakLib::PRIORITY_NORMAL));
				return $pk->identifierACK;
			}else{
				$this->server->batchPackets([$player], [$packet], true, $immediate);
				return null;
			}
		}

		return null;
	}

    /**
     * @param string $identifier
     * @param int $pingMS
     */
    public function updatePing(string $identifier, int $pingMS){
        if(isset($this->players[$identifier])){
            $this->players[$identifier]->updatePing($pingMS);
        }
    }

	/**
	 * @param $buffer
	 *
	 * @return null|DataPacket
	 */
	private function getPacket($buffer){
		return $this->network::getPacket($buffer, 1);
	}
}