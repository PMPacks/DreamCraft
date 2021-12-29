<?php

namespace PTK;

 use pocketmine\plugin\PluginBase;
 use pocketmine\{command\Command, command\CommandSender};
 use pocketmine\item\Item;

class Repair extends PluginBase {

  public function onEnable() {
$this->getLogger()->info("§bĐã Bật");
   }
  public function onDisable() {
   $this->getLogger()->info("§cĐã Tắt");
  }
  public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
switch($cmd->getName()) {

 case "repair":
 case "rp":
 case "fix":
 $inventory = $sender->getInventory();
 $item = $inventory->getItemInHand();
 $item->setDamage(0);
 $inventory->setItemInHand($item);
 $sender->sendMessage("§bBạn đã được sửa đồ trên tay");
  break;
    }
  }
}