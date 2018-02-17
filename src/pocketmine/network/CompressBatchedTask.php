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

namespace pocketmine\network;

use pocketmine\network\mcpe\protocol\BatchPacket;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class CompressBatchedTask extends AsyncTask{

    public $level = 7;
    public $data;
    public $targets;

    /**
     * @param BatchPacket $batch
     * @param string[]    $targets
     */
    public function __construct(BatchPacket $batch, array $targets){
        $this->data = $batch->payload;
        $this->targets = serialize($targets);
        $this->level = $batch->getCompressionLevel();
    }

    public function onRun(){
        $batch = new BatchPacket();
        $batch->payload = $this->data;
        $this->data = null;

        $batch->setCompressionLevel($this->level);
        $batch->encode();

        $this->setResult($batch->buffer, false);
    }

    public function onCompletion(Server $server){
        $pk = new BatchPacket($this->getResult());
        $pk->isEncoded = true;
        $server->broadcastPacketsCallback($pk, unserialize($this->targets));
    }
}