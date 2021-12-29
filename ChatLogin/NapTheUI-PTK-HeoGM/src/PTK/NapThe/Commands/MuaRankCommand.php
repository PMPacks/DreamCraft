<?php
namespace PTK\NapThe\Commands;
use PTK\NapThe\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecuter;
use pocketmine\command\ConsoleCommandSender;
use _64FF00\PurePerms\PurePerms;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat as __;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;

class MuaRankCommand{
    public function execute(Main $plugin, CommandSender $sender, $label, array $args){
        if (!isset($args[1])) return $plugin->registeredCommands['help']->execute($plugin, $sender, $label, $args);
        switch ($args[1]){
            case 1:
                if ($plugin->api->take($sender->getName(), $plugin->config->get("Rank.1"))){
                    $plugin->getServer()->dispatchCommand(new ConsoleCommandSender(),'setvip 1 '.strtolower($sender->getName()).' 8');
                    $plugin->purePerms->setGroup($sender, $plugin->purePerms->getGroup("1"));
                    $sp = $plugin->api->look($sender->getName());
                    $rank1 = Item::get(339,0,1);
                    $rank1->setCustomName("§r§a❤§c Lịch Sử Mua Rank §a❤");
                    $rank1->setLore(array("§r§l§eMón Hàng:\n§r§c•§a Vip".$args[1].":\n§d♦§b Số ngày: §a8\n§d♦§b Số §dPoint§b để mua: §620§d Point\n§r§l§eInfo\n§r§a|§e ".$sender->getName()."§a |"));
                    $sender->getInventory()->addItem($rank1);
                    $sender->sendMessage("§c✿§6 ".$sender->getName()."§e đã mua thành công gói§a Vip ".$args[1]." ");  
                    
                } else {
                                            $sp = $plugin->api->look($sender->getName());
                    $sender->sendMessage($plugin->prefix."§cSố §dPoint§a hiện tại của bạn:§6 ".$sp." ");
                }
                break;
            case 2:
                if ($plugin->api->take($sender->getName(), $plugin->config->get("Rank.2"))){
                    $plugin->getServer()->dispatchCommand(new ConsoleCommandSender(),'setvip 2 '.strtolower($sender->getName()).' 20');
                    $plugin->purePerms->setGroup($sender, $plugin->purePerms->getGroup("2"));                    
                    $rank2 = Item::get(339,0,1);
                    $sp1 = $plugin->api->look($sender->getName());
                    $rank2->setCustomName("§r§a❤§c Lịch Sử Mua Rank §a❤");
                    $rank2->setLore(array("§r§l§eMón Hàng:\n§r§c•§a Vip".$args[1].":\n§d♦§b Số ngày: §a20\n§d♦§b Số §dPoint§b để mua: §650§d Point\n§r§l§eInfo\n§r§a|§e ".$sender->getName()."§a |"));
                    $sender->getInventory()->addItem($rank2);
                                        $sender->sendMessage("§c✿§6 ".$sender->getName()."§e đã mua thành công gói§a Vip ".$args[1]." ");  
                }else {
                                            $sp1 = $plugin->api->look($sender->getName());
                    $sender->sendMessage($plugin->prefix."§cSố §dPoint§a hiện tại của bạn:§6 ".$sp1." ");
                }
                break;
            case 3:
                if ($plugin->api->take($sender->getName(), $plugin->config->get("Rank.3"))){
                    $plugin->getServer()->dispatchCommand(new ConsoleCommandSender(),'setvip 3 '.strtolower($sender->getName()).' 50');
                    $plugin->purePerms->setGroup($sender, $plugin->purePerms->getGroup("3"));
        $sp2 = $plugin->api->look($sender->getName());
                    $rank3 = Item::get(339,0,1);
                    $rank3->setCustomName("§r§a❤§c Lịch Sử Mua Rank §a❤");
                    $rank3->setLore(array("§r§l§eMón Hàng:\n§r§c•§a Vip".$args[1].":\n§d♦§b Số ngày: §a50\n§d♦§b Số §dPoint§b để mua: §6100§d Point\n§r§l§eInfo\n§r§a|§e ".$sender->getName()."§a |"));
                    $sender->getInventory()->addItem($rank3);
                                    $sender->sendMessage("§c✿§6 ".$sender->getName()."§e đã mua thành công gói§a Vip ".$args[1]." ");  
                }else {
                                         $sp2 = $plugin->api->look($sender->getName());
                    $sender->sendMessage($plugin->prefix."§cSố §dPoint§a hiện tại của bạn:§6 ".$sp2." ");
                }
                break;
            case 4:
                if ($plugin->api->take($sender->getName(), $plugin->config->get("Rank.4"))){
                    $plugin->getServer()->dispatchCommand(new ConsoleCommandSender(),'setvip 4 '.strtolower($sender->getName()).' 100');
                    $plugin->purePerms->setGroup($sender, $plugin->purePerms->getGroup("4"));
                    $sp3 = $plugin->api->look($sender->getName());
                    $rank4 = Item::get(339,0,1);
                    $rank4->setCustomName("§r§a❤§c Lịch Sử Mua Rank §a❤");
                    $rank4->setLore(array("§r§l§eMón Hàng:\n§r§c•§a Vip".$args[1].":\n§d♦§b Số ngày: §a100\n§d♦§b Số §dPoint§b để mua: §6300§d Point\n§r§l§eInfo\n§r§a|§e ".$sender->getName()."§a |"));
                    $sender->getInventory()->addItem($rank4);
					                    $sender->sendMessage("§c✿§6 ".$sender->getName()."§e đã mua thành công gói§a Vip ".$args[1]." ");  
                }else {
					                            $sp3 = $plugin->api->look($sender->getName());
                    $sender->sendMessage($plugin->prefix."§cSố §dPoint§a hiện tại của bạn:§6 ".$sp3." ");
                }
                break;
            case 5:
                if ($plugin->api->take($sender->getName(), $plugin->config->get("Rank.5"))){
					$plugin->getServer()->dispatchCommand(new ConsoleCommandSender(),'setvip 5 '.strtolower($sender->getName()).' 400');
                    $plugin->purePerms->setGroup($sender, $plugin->purePerms->getGroup("5"));
                    $sp4 = $plugin->api->look($sender->getName());
                    $rank5 = Item::get(339,0,1);
                    $rank5->setCustomName("§r§a❤§c Lịch Sử Mua Rank §a❤");
                    $rank5->setLore(array("§r§l§eMón Hàng:\n§r§c•§a Vip".$args[1].":\n§d♦§b Số ngày: §a400\n§d♦§b Số §dPoint§b để mua: §6600§d Point\n§r§l§eInfo\n§r§a|§e ".$sender->getName()."§a |"));
                    $sender->getInventory()->addItem($rank5);
                                        $sender->sendMessage("§c✿§6 ".$sender->getName()."§e đã mua thành công gói§a Vip ".$args[1]." ");  
                }else {
					                            $sp4 = $plugin->api->look($sender->getName());
                    $sender->sendMessage($plugin->prefix."§cSố §dPoint§a hiện tại của bạn:§6 ".$sp4." ");
                }
                break;
			case 6:
                if ($plugin->api->take($sender->getName(), $plugin->config->get("Rank.6"))){
					$plugin->getServer()->dispatchCommand(new ConsoleCommandSender(),'setvip 6 '.strtolower($sender->getName()).' 2000');
                    $plugin->purePerms->setGroup($sender, $plugin->purePerms->getGroup("6"));
                    $sp5 = $plugin->api->look($sender->getName());
                    $rank6 = Item::get(339,0,1);
                    $rank6->setCustomName("§r§a❤§c Lịch Sử Mua Rank §a❤");
                    $rank6->setLore(array("§r§l§eMón Hàng:\n§r§c•§a Vip".$args[1].":\n§d♦§b Số ngày: §a2000\n§d♦§b Số §dPoint§b để mua: §61200§d Point\n§r§l§eInfo\n§r§a|§e ".$sender->getName()."§a |"));
                    $sender->getInventory()->addItem($rank6);
                    $sender->sendMessage("§c✿§6 ".$sender->getName()."§e đã mua thành công gói§a Vip ".$args[1]." ");  
                }else {
                            $sp5 = $plugin->api->look($sender->getName());
                    $sender->sendMessage($plugin->prefix."§cSố §dPoint§a hiện tại của bạn:§6 ".$sp5." ");
                }
                break;
        }
        return true;
    }
}

