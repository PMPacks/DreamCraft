<?php

namespace PTK\MineLevel;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
use onebone\economyapi\EconomyAPI;
use pocketmine\item\Item;
use pocketmine\event\player\{PlayerInteractEvent, PlayerItemHeldEvent, PlayerJoinEvent, PlayerChatEvent};
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\block\Block;
use pocketmine\utils\Config;
use pocketmine\entity\Effect;
use pocketmine\network\protocol\SetTitlePacket;

class Main extends PluginBase implements Listener{
    
    public $data;
    private $config;
    
    public function onEnable(){
        if(!file_exists($this->getDataFolder() . "data/")){
            @mkdir($this->getDataFolder() . "data/");
        }
        
        $this->data = new Config($this->getDataFolder() . "data/" . "data.yml", Config::YAML);
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();
        $this->config->save();
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->getLogger()->info("ON");
    }
    
    public function onJoin(PlayerJoinEvent $ev){
        $p = $ev->getPlayer()->getName();
        if(!($this->data->exists(strtolower($p)))){
            $this->data->set(strtolower($p), [0,100,1]);
            $this->data->save();
            return true;
        }
    }
    
    public function onBreak(BlockBreakEvent $ev){
        $block = $ev->getBlock();
        $p = $ev->getPlayer();
        if($block->getId() === Block::DIAMOND_BLOCK or $block->getId() === Block::EMERALD_BLOCK or $block->getId() === Block::REDSTONE_BLOCK or $block->getId() === Block::GOLD_BLOCK or $block->getId() === Block::IRON_BLOCK or $block->getId() === Block::LAPIS_BLOCK){
            $n = $this->data->get(strtolower($p->getName()));
            $name = strtolower($p->getName());
            $n[0] = $this->getCurrentExp($p) + 1;
            $this->data->set(strtolower($p->getName()), $n);
            $this->data->save();
            $p->sendPopup("   §b»§a+1 EXP§b«\n". "§b»§eExp: " . $this->data->get($name)[0] . "/" . $this->data->get($name)[1] . "§b«");
            if($this->getCurrentExp($p) >= $this->getLevelUpExp($p)){
                $n[0] = 0;
                $n[1] = $this->getNextLevelUpExp($p);
                $n[2] = $this->getNextLevel($p);
                $n[3] = $this->getNextLevelUpExp($p)-$this->getCurrentExp($p);
                $this->data->set(strtolower($p->getName()), $n);
                $this->data->save();
                $p->sendMessage("§b======§eLEVEL§b======");
                $p->sendMessage("§b==§aBạn Đã Lên Cấp " . $this->getCurrentLevel($p). "§b==");//xin config :v :v
                $p->sendMessage("§b======§eLEVEL§b======");
                $this->getServer()->broadcastMessage("§b[§9LEVEL§b]§2 Người chơi §b" . $name . "§2 Đã Lên Cấp§b ".$this->getCurrentLevel($p));
            }
        }
        
        $p->setDisplayName("§b[§aCấp §e".$this->getCurrentLevel($p)."§b]§f ".$p->getName());
    }
    
    public function onChat(PlayerChatEvent $ev){
        $p = $ev->getPlayer();
        $name = $p->getName();
        $p->setDisplayName("§b[§aCấp §e".$this->getCurrentLevel($p)."§b]§f ".$p->getName());
    }
    
    public function onCommand(CommandSender $s, Command $command, $label, array $args){
        switch($command->getName()){
            case "ilevel":
                if (count($args) < 0) {
                $n = $s;
                $s->sendMessage("§r§a-=§e|§c♦§e| §aCấp Độ Của Đảo SkyBlock§e |§c♦§e|§a=-");
                $s->sendMessage("§c❤§aKinh Nghiệm Và Cấp Độ Đảo Của Người Chơi:§d ".$n->getName()."§c❤");
                $s->sendMessage("§r§b•»§eSố Kinh Nghiệm Của Bạn: §d".$this->getCurrentExp($n)."/".$this->getNextLevelUpExp($n));
                $s->sendMessage("§r§b•»§eSố Cấp Độ Của Bạn: §d".$this->getCurrentLevel($n));
                $s->sendMessage("§r§b•»§eSố Kinh Nghiệm Để Lên Cấp Tiếp Theo: §d".($this->getNextLevelUpExp($n)-$this->getCurrentExp($n)));
                $s->sendMessage("§r§a-=§e|§c♦§e| §aCấp Độ Của Đảo SkyBlock§e |§c♦§e|§a=-");
                }
                if (isset($args[0])){
                    $n = $args[0];
                    $lol = $this->data->get(strtolower($n));
                    if (isset($lol)){
                    $s->sendMessage("§r§a-=§e|§c♦§e| §aCấp Độ Của Đảo SkyBlock§e |§c♦§e|§a=-");
                    $s->sendMessage("§c❤§aKinh Nghiệm Và Cấp Độ Đảo Của Người Chơi:§d ".$n."§c❤");
                    $s->sendMessage("§r§b•»§eSố Kinh Nghiệm Của Bạn: §d".$this->getCurrentExp($n)."/".$this->getNextLevelUpExp($n));
                    $s->sendMessage("§r§b•»§eSố Cấp Độ Của Bạn: §d".$this->getCurrentLevel($n));
                    $s->sendMessage("§r§b•»§eSố Kinh Nghiệm Để Lên Cấp Tiếp Theo: §d".($this->getNextLevelUpExp($n)-$this->getCurrentExp($n)));
                    $s->sendMessage("§r§a-=§e|§c♦§e| §aCấp Độ Của Đảo SkyBlock§e |§c♦§e|§a=-");
                    }else{
                    $s->sendMessage("§b[§9LEVEL§b]§e•»§c Người Chơi Không Tồn Tại!");
                }}
                return true;
            case "setilevel":
                if (count($args) < 0) {
                    $s->sendMessage("§b[§9LEVEL§b]§e•»§6 Xin Hãy Sử Dụng Lệnh: /setilevel (Tên Người Chơi) [Số Cấp Độ]");
                    
                }
                if (!is_numeric($args[0])) {
                    $s->sendMessage("§b[§9LEVEL§b]§e•»§6 Số Cấp Độ Phải Là Số!");
                }
                if (isset($args[1])) {
                    $target = $this->getServer()->getPlayer($args[1]);
                }
                if (!$target instanceof Player) {
                    $s->sendMessage("§b[§9LEVEL§b]§e•»§c Người Chơi Không Tồn Tại!");
                    return false;
                    $n = $this->data->get(strtolower($target->getName()));
                    $name = strtolower($target->getName());
                    $n[1] = $this->getNextLevelUpExp($n) + (10 * $arg[0]);
                    $n[2] = $arg[0];
                    $this->data->set(strtolower($target->getName()), $n);
                    $this->data->save();
                }
                return true;
            default:
                return false;
        }
    }
    
    
    
    
    /*    public function onHeld(PlayerItemHeldEvent $ev){
    
    }
    
    public function onTouch(PlayerInteractEvent $ev){
    
    }
    */
    public function getNextLevel($player){
        if($player instanceof Player){
            $player = $player->getName();
        }
        
        $player = strtolower($player);
        $lv = $this->data->get($player)[2] + 1;
        return $lv;
    }
    
    public function getLevelUpExp($player){
        if($player instanceof Player){
            $player = $player->getName();
        }
        
        $player = strtolower($player);
        $e = $this->data->get($player)[1];
        return $e;
    }
    
    public function getCurrentLevel($player){
        if($player instanceof Player){
            $player = $player->getName();
        }
        
        $player = strtolower($player);
        $lv = $this->data->get($player)[2];
        return $lv;
    }
    
    public function getCurrentExp($player){
        if($player instanceof Player){
            $player = $player->getName();
        }
        
        $player = strtolower($player);
        $e = $this->data->get($player)[0];
        return $e;
    }
    
    public function getNextLevelUpExp($player){
        if($player instanceof Player){
            $player = $player->getName();
        }
        
        $player = strtolower($player);
        $e = $this->data->get($player)[1];
        return $e + 10;
    }
    
    
}

?>