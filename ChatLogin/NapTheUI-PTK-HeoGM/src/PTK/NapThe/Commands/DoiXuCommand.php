<?php
namespace PTK\NapThe\Commands;
use PTK\NapThe\Main;
use PTK\NapThe\NapTheAPI;
use PTK\NapThe\API\Vippay_API;
use pocketmine\utils\TextFormat as __;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\command\CommandSender;
use onebone\economyapi\EconomyAPI;

class DoiXuCommand{
    public function execute(Main $plugin, CommandSender $sender, $label, array $args){
        if (!isset($args[1])) return $plugin->registeredCommands['help']->execute($plugin, $sender, $label, $args);
        if ($plugin->api->take($sender->getName(), abs(intval($args[1])))){
            $plugin->eco->addMoney($sender->getName(), abs(intval($args[1]))*200);
            $tk = $plugin->api->look($sender->getName());
            $sender->sendMessage($plugin->prefix."§cBạn đã đổi thành công xu, hãy kiểm tra §atài khoản§c và§a inventory");
            $lsdx = Item::get(339,0,1);
            $lsdx->setCustomName("§r§a✦§e Lịch Sử Đổi §aXu§a ✦");
            $lsdx->setLore(array("§r§a-----------------------------------\n§c•§e Số Point Quy Đổi:§a ".abs(intval($args[1]))."§d Points\n§c•§e Số Tiền Nhận Được:§a ".abs(intval($args[1]*200))." §dXu\n§r§a-----------------------------------"));
            $sender->getInventory()->addItem($lsdx);
            return true;
        } else {
                        $tk3 = $plugin->api->look($sender->getName());
            $sender->sendMessage($plugin->prefix."§aSố §dPoints§e bạn hiện có:§c ".$tk3." ");
            return false;
        }
        return false;
    }
}

