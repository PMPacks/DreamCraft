<?php
namespace PTK\NapThe\Commands;
use PTK\NapThe\Main;
use PTK\NapThe\NapTheAPI;
use PTK\NapThe\API\Vippay_API;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerJoinEvent;
class KttkCommand{
    public function execute(Main $plugin, CommandSender $sender, $label, array $args){
        $amount = $plugin->api->look($sender->getName());
        $sender->sendMessage($plugin->prefix."§aTài khoản §ccủa bạn hiện có:§6 ".$amount." §dPoints.");
        return true;
    }
	
}


