<?php

/**
 * BlockBreakPickup.php – AutoInv
 *
 * Copyright (C) 2015-2017 Jack Noordhuis
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Jack Noordhuis
 *
 */

namespace PTK\AutoInv\event\handle;

use PTK\AutoInv\event\EventHandler;
use PTK\AutoInv\event\EventManager;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\EventPriority;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\Player;

class InventoryFullAlert extends EventHandler {

	/** @var int */
	private $alertInterval;

	/** @var string */
	private $text;

	/** @var string */
	private $secondaryText;

	/** @var string */
	private $messageType;

	/** @var bool */
	private $playSound;

	/** @var array */
	private $recentAlerts = [];

	public function __construct(EventManager $manager, $alertInterval = 4, $text = "", $secondaryText = "", $messageType = "popup", bool $playSound = Bật) {
		$this->alertInterval = $alertInterval;
		$this->text = $text;
		$this->secondaryText = $secondaryText;
		$this->messageType = $messageType;
		$this->playSound = $playSound;
		parent::__construct($manager);
	}

	public function handles() : array {
		return [
			BlockBreakEvent::class => "handleBlockBreak",
			PlayerQuitEvent::class => "handlePlayerQuit",
		];
	}

	/**
	 * Handle automatic block pickup on break
	 *
	 * @param BlockBreakEvent $event
	 */
	public function handleBlockBreak(BlockBreakEvent $event) {
		foreach($event->getDrops() as $drop) {
			if(!$event->getPlayer()->getInventory()->canAddItem($drop)) {
				$this->alert($event->getPlayer());
			}else{
			$event->getPlayer()->getInventory()->addItem($drop);
		$event->setDrops([]);
		}
	}
	}
	public function handlePlayerQuit(PlayerQuitEvent $event) {
		if(isset($this->recentAlerts[$hash = spl_object_hash($event->getPlayer())])) {
			unset($this->recentAlerts[$hash]);
		}
	}

	/**
	 * Send inventory full alert to a player
	 *
	 * @param Player $player
	 */
	protected function alert(Player $player) {
		if(!isset($this->recentAlerts[$hash = spl_object_hash($player)]) or (isset($this->recentAlerts[$hash]) and ($time = microtime(true)) - $this->recentAlerts[$hash] >= $this->alertInterval)) {
			$this->recentAlerts[$hash] = $time ?? microtime(true);

			switch($this->messageType) {
				case "":
					break; // allow blank to disable message alert
				case "message":
					$player->sendMessage($this->text);
					$player->sendMessage($this->secondaryText);
					break;
				case "popup":
					$player->sendPopup($this->text);
					$player->sendMessage($this->text);
					$player->sendMessage($this->secondaryText);
					break;
				case "tip":
					$player->sendTip($this->text);
					$player->sendMessage($this->text);
					$player->sendMessage($this->secondaryText);
					break;
				default:
					$player->addTitle($this->text, $this->secondaryText);
					$player->sendMessage($this->text);
					break;
			}

			if($this->playSound) {
				$pk = new LevelEventPacket();
				$pk->position = $player->asVector3();
				$pk->evid = LevelEventPacket::EVENT_SOUND_ENDERMAN_TELEPORT;
				$pk->data = 0;
				$player->dataPacket($pk);
			}
		}
	}

	public function getEventPriority() : int {
		return EventPriority::HIGHEST;
	}

}