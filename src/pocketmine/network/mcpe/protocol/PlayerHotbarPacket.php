<?php

/*
 *               _ _
 *         /\   | | |
 *        /  \  | | |_ __ _ _   _
 *       / /\ \ | | __/ _` | | | |
 *      / ____ \| | || (_| | |_| |
 *     /_/    \_|_|\__\__,_|\__, |
 *                           __/ |
 *                          |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author TuranicTeam
 * @link https://github.com/TuranicTeam/Altay
 *
 */

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\types\ContainerIds;

#ifndef COMPILE
#endif

class PlayerHotbarPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::PLAYER_HOTBAR_PACKET;

	/** @var int */
	public $selectedHotbarSlot;
	/** @var int */
	public $windowId = ContainerIds::INVENTORY;
	/** @var bool */
	public $selectHotbarSlot = true;

	protected function decodePayload(){
		$this->selectedHotbarSlot = $this->getUnsignedVarInt();
		$this->windowId = $this->getByte();
		$this->selectHotbarSlot = $this->getBool();
	}

	protected function encodePayload(){
		$this->putUnsignedVarInt($this->selectedHotbarSlot);
		$this->putByte($this->windowId);
		$this->putBool($this->selectHotbarSlot);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handlePlayerHotbar($this);
	}
}
