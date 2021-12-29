<?php

namespace PTK\AutoInv\util\config;

use PTK\AutoInv\event\handle\EntityExplosionPickup;
use PTK\AutoInv\event\handle\InventoryFullAlert;
use PTK\AutoInv\event\handle\PlayerDeathPickup;
use PTK\AutoInv\util\ColorUtils;

class EventConfigurationLoader extends ConfigurationLoader {
	public function onLoad(array $data) {
		$manager = $this->getPlugin()->getEventManager();
		$eventData = $data["general"]["events"];
		if(self::getBoolean($eventData["player-death"] ?? false)) {
			$manager->registerHandler(new PlayerDeathPickup($manager));
		}
		if(self::getBoolean($eventData["entity-explosion"] ?? false)) {
			$manager->registerHandler(new EntityExplosionPickup($manager));
		}
		if((($inventoryData = $eventData["inventory-full"]) ?? false) and self::getBoolean($inventoryData["active"])) {
			$manager->registerHandler(new InventoryFullAlert($manager, $inventoryData["interval"], ColorUtils::translateColors($inventoryData["message"]["text"] ?? ""), ColorUtils::translateColors($inventoryData["message"]["secondary-text"] ?? ""),strtolower($inventoryData["message"]["type"] ?? "message"), $inventoryData["sound"] ?? false));
		}
	}
}