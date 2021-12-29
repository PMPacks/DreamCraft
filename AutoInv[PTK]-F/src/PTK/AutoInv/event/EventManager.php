<?php

namespace PTK\AutoInv\event;

use PTK\AutoInv\AutoInv;
use pocketmine\plugin\MethodEventExecutor;

class EventManager {
	/** @var AutoInv */
	private $plugin;
	/** @var EventHandler[] */
	private $eventHandlers;
	public function __construct(AutoInv $plugin) {
		$this->plugin = $plugin;
	}
	/**
	 * @return AutoInv
	 */
	public function getPlugin() : AutoInv {
		return $this->plugin;
	}
	/**
	 * Register an event handler
	 *
	 * @param EventHandler $handler
	 */
	public function registerHandler(EventHandler $handler) {
		$this->eventHandlers[] = $handler;
		foreach($handler->handles() as $eventClass => $handleFunc) {
			$this->plugin->getLogger()->debug("Registered " . (new \ReflectionClass($eventClass))->getShortName() . " for " . (new \ReflectionObject($handler))->getShortName() . "::" . $handleFunc);
			$this->plugin->getServer()->getPluginManager()->registerEvent($eventClass, $handler, $handler->getEventPriority(), new MethodEventExecutor($handleFunc), $this->plugin, $handler->ignoreCancelled());
		}
	}
}