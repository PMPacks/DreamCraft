<?php
namespace PTK\NapThe\Commands;

use PTK\NapThe\Main;
use PTK\NapThe\API\Vippay_API;
use pocketmine\command\CommandSender;
use PTK\NapThe\NapTheAPI;
use pocketmine\utils\TextFormat as __;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;

class NapTheCommand{
    public function execute(Main $plugin, CommandSender $sender, $label, array $args){
        if (!isset($args[1]) || !isset($args[2]) || !isset($args[3])) 
            return $plugin->registeredCommands['help']->execute($plugin, $sender, $label, $args);
        //Xử lý thẻ nạp
        $suplier = $this->getSuplier($args[1]);
        $series = $args[2];
        $pincode = $args[3];       
        //Gửi dữ liệu lên Vippay
        $vippay_api = new Vippay_API();
        $vippay_api->setMerchantId($plugin->config->get("Vippay.Merchant_id"));
        $vippay_api->setApiUser($plugin->config->get("Vippay.API_USER"));
        $vippay_api->setApiPassword($plugin->config->get("Vippay.API_PASSWORD"));        
        $vippay_api->setPin($pincode);
        $vippay_api->setSeri($series);
        $vippay_api->setCardType(intval($suplier));
        $vippay_api->setNote("Người chơi " . $sender->getName() . " Server PE");
        $vippay_api->cardCharging();
        //Nhận dữ liệu trả về
        $code = intval($vippay_api->getCode());
        $info_card = intval($vippay_api->getInfoCard());
        $error = $vippay_api->getMsg();  
        //Xử lý dữ liệu trả về
        if ($code == 0 && $info_card > 1){
            $plugin->api->give($sender->getName(), $info_card/1000);
            $suplier = substr( $suplier,  1, strlen($suplier)-1);
            $tk1 = $plugin->api->look($sender->getName());
            $tc = Item::get(339,0,1);
            $tc->setCustomName("§r§c✔§d Lịch Sử Nạp Thẻ");
            $tc->setLore(array("§a•§d Số Point hiện tại:§6 ".$tk1."\n§fTrạng thái:§a TC\n§l§cInfo Thẻ Cào\n§a•§d Mạng:§6 ".$suplier."\n§a•§d Seri thẻ:§6 ".$series."\n§a•§d Pin thẻ:§6 ".$pincode." "));
            $sender->getInventory()->addItem($tc);
            $sender->sendMessage($plugin->prefix."§aNạp thẻ thành công, hãy kiểm tra§c tài khoản§a và§c inventory");            
                                        $sender->sendMessage("§c✿§6 ".$sender->getName()."§e đã nạp thành công thẻ có mệnh giá §6".$info_card."VNĐ");  
            return true;
        }
        $sender->sendTitle($plugin->prefix."\nThẻ không tồn tại");
        return false;
    }
    
    private function getSuplier($args){
        $suplier = $args;
        switch (strtolower($suplier)) {
            case "vina":
                $suplier = "3Vinaphone";
            break;
            case "mobi":
                $suplier = "2Mobiphone";
            break;
            case "viettel":
                $suplier = "1Viettel";
            break;
            case "vtc":
                $suplier = "5VTC-Vcoin";
            break;
            case "gate":
                $suplier = "4Gate";
            break;
            default:
                $suplier = "1Viettel";
            break;
        }
        return $suplier;
    }
    
}


