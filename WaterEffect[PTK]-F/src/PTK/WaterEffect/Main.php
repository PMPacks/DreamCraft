<?php

namespace PTK\WaterEffect;

use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {
	
	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
	}
	
	public function onMove(PlayerMoveEvent $event) {
		$player = $event->getPlayer();
		$x = $player->getX();
		$y = $player->getY();
		$z = $player->getZ();
		$level = $player->getLevel();
		$pos = new Position($x, $y + 1 , $z, $level);
		$blocks = array(8, 9);
		$effects = $this->getConfig()->get("Effects");
		if(in_array($player->getLevel()->getBlock($pos)->getId(), $blocks)) {
			foreach($effects as $effectid) {
				$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect " . $player->getName() . " " . $effectid . " 20 5 true");
				$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "sendpopup " . $player->getName() . " Bạn đang bị dính acid!");
			}
		} else {
		}
	}
}