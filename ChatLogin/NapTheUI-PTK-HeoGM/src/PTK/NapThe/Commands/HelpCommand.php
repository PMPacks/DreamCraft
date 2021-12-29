<?php
namespace PTK\NapThe\Commands;

use PTK\NapThe\Main;
use pocketmine\command\CommandSender;

class HelpCommand{
    public function execute(Main $plugin, CommandSender $sender, $label, array $args){
        $sender->sendMessage("§l§a----------------§r§l§e Donate Server §l§a----------------");
        $sender->sendMessage("§r§c•§6/donate card §c[mobi, vina, viettel, gate, vtc] §b[seri] [pin]§a để nạp thẻ\n§c•§6/donate myp§a để kiểm tra số point trong tài khoản\n§c•§6/donate muavip §c| 1 | 2 | 3 | 4 | 5 | 6 |§a để mua vip\n§c•§6/donate muaxu §c[số xu]§a để đổi từ point sang xu");
        //napthe
        //kttk
        //rank
        //doi
        return true;
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

