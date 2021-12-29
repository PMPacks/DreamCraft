<?php

namespace PTK\Trade;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\nbt\NBT;
use pocketmine\utils\TextFormat as TF;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener{
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info(TF::BLUE . "Trade Đã Hoạt Động!");
	}
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
		if ($cmd->getName() == "trade"){
			$sender->sendMessage(TF::BLUE . "/trade list để xem danh sách gói vật phẩm, sử dụng /trade doi (tên vật phẩm) để đổi vật phẩm");
			if(isset($args[0])){
				switch(strtolower($args[0])){
				case "list":
				$sender->sendMessage(TF::BLUE . "Danh sách các gói vật phẩm đặc biệt (/trade doi (cú pháp) để để đổi)");
				$sender->sendMessage(TF::GREEN . "1.Cúp Sắt Cường Hóa - 3 Kim Ngọc (cú pháp: cup1)");
				$sender->sendMessage(TF::GREEN . "2.Cúp Kim Cương Cường Hóa - 3 Mộc Ngọc (cú pháp: cup2");
				$sender->sendMessage(TF::GREEN . "3.Cúp Hắc Diện Thạch - 3 Thủy Ngọc (cú pháp: cup3)");
				$sender->sendMessage(TF::GREEN . "4.Cúp Ánh Sáng - 3 Hỏa Ngọc (cú pháp: cup4)");
				$sender->sendMessage(TF::GREEN . "5.Cúp Bóng Tối - 3 Thổ Ngọc (cú pháp: cup5)");
				$sender->sendMessage(TF::BLUE . "Ghi /trade list 2 để xem trang tiếp theo ---->");
				   if(isset($args[1])){
					   switch (strtolower($args[1])){
						   case "2":
				           $sender->sendMessage(TF::BLUE . "Danh sách các gói vật phẩm đặc biệt (/trade doi (cú pháp) để để đổi)");
                           $sender->sendMessage(TF::GREEN . "6.Kim Ngọc - 32 Khối Than (cú pháp: kimngoc)");
						   $sender->sendMessage(TF::GREEN . "7.Mộc Ngọc - 32 Khối Vàng (cú pháp: kimngoc)");						   
						   $sender->sendMessage(TF::GREEN . "8.Thủy Ngọc - 32 Khối Sắt (cú pháp: thuyngoc)");
						   $sender->sendMessage(TF::GREEN . "9.Hỏa Ngọc - 32 Khối Kim Cương (cú pháp: thongoc)");
						   $sender->sendMessage(TF::GREEN . "10.Thổ Ngọc - 32 Khối Lục Bảo (cú pháp: hoangoc");
						   return true;
						   break;
					   }
				   }
				return true;
				case "doi": //Co the edit them neu muon!
				   if(isset($args[1])){ //Trong khi edit cam xoa dong nay!!!!
					   switch (strtolower($args[1])){
						   //Iron Enchant Pickaxe
						  case "cup1":
						  $p = $this->getServer()->getPlayer($sender->getName());
						  $item = Item::get(257, 0, 1);
						  $name = $item->setCustomName("§r§bCúp Sắt Phù Phép");
						  $item->setLore(array("§e§l▀▀▀▀▀§6▀▀▀[§9 Thông Tin§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n§dCúp Được Tinh Luyện Từ Loại Sắt Quý Hiếm \n§e§l▀▀▀▀▀§6▀▀▀[§9 Thuộc Tính§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n §b§l➞§Đào Nhanh§f: §e 5 \n §§b§l➞§Chậm Hỏng§f: §e 10 \n§e§l▀▀▀▀▀§6▀▀▀[§9 Lưu Ý§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n §c§l*Tránh làm mất mọi trường hợp! \n §c§l*Nếu làm mất admin sẽ không chịu trách nhiệm§f"));
						  if($sender->getInventory()->contains(Item::get(344,0,3))){
							  $item->addEnchantment(Enchantment::getEnchantment(15)->setLevel(5));
							  $item->addEnchantment(Enchantment::getEnchantment(17)->setLevel(10));
							  $sender->getInventory()->addItem($item);
                              $item->setCustomName($name);
							  $sender->getInventory()->removeItem(Item::get(344,0,3));
							  $sender->sendMessage(TF::YELLOW . "Bạn đã đổi cúp sắt phù phép với 3 Kim Ngọc");
						  }
						  else{
							  $sender->sendMessage(TF::RED . "Bạn không có vật phẩm để đổi");
						  }
				          return true;
						  break;
						  //Diamond Enchant Pickaxe
						  case "cup2":
						  $p = $this->getServer()->getPlayer($sender->getName());
						  $item = Item::get(278, 0, 1);
						  $name = $item->setCustomName("§r§bCúp Kim Cương Phù Phép");
						  $item->setLore(array("§e§l▀▀▀▀▀§6▀▀▀[§9 Thông Tin§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n§dCúp Được Tinh Luyện Từ Loại Kim Cương Quý Hiếm \n§e§l▀▀▀▀▀§6▀▀▀[§9 Thuộc Tính§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n §b§l➞§Đào Nhanh§f: §e 15 \n §§b§l➞§Chậm Hỏng§f: §e 15 \n§e§l▀▀▀▀▀§6▀▀▀[§9 Lưu Ý§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n §c§l*Tránh làm mất mọi trường hợp! \n §c§l*Nếu làm mất admin sẽ không chịu trách nhiệm§f"));						  
						  if($sender->getInventory()->contains(Item::get(341,0,3))){
							  $item->addEnchantment(Enchantment::getEnchantment(15)->setLevel(15));
							  $item->addEnchantment(Enchantment::getEnchantment(17)->setLevel(15));
							  $sender->getInventory()->addItem($item);
							  $sender->getInventory()->removeItem(Item::get(341,0,3));
							  $sender->sendMessage(TF::YELLOW . "Bạn đã đổi cúp kim cương phù phép với 3 Mộc Ngọc");
						  }
						  else{
							  $sender->sendMessage(TF::RED . "Bạn không có vật phẩm để đổi");
						  }
						  return true;
						  break;
						  //Obisidian Enchant Pickaxe
						  case "cup3":
						  $p = $this->getServer()->getPlayer($sender->getName());
						  $item = Item::get(278, 0, 1);
						  $name = $item->setCustomName("§r§bCúp Hặc Diện Thạch");
						  $item->setLore(array("§e§l▀▀▀▀▀§6▀▀▀[§9 Thông Tin§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n§dCúp Được Tinh Luyện Từ Loại Hắc Diện Thạch Đen Như Dái Chó \n§e§l▀▀▀▀▀§6▀▀▀[§9 Thuộc Tính§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n §b§l➞§Đào Nhanh§f: §e 30 \n §§b§l➞§Chậm Hỏng§f: §e 20 \n§e§l▀▀▀▀▀§6▀▀▀[§9 Lưu Ý§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n §c§l*Tránh làm mất mọi trường hợp! \n §c§l*Nếu làm mất admin sẽ không chịu trách nhiệm§f"));						  
						  if($sender->getInventory()->contains(Item::get(351,12,3))){
							  $item->addEnchantment(Enchantment::getEnchantment(15)->setLevel(30));
							  $item->addEnchantment(Enchantment::getEnchantment(17)->setLevel(20));
							  $sender->getInventory()->addItem($item);
							  $sender->getInventory()->removeItem(Item::get(351,12,3));
							  $sender->sendMessage(TF::YELLOW . "Bạn đã đổi cúp hắc diện thạch với 3 Thủy Ngọc");
						  }
						  else{
							  $sender->sendMessage(TF::RED . "Bạn không có vật phẩm để đổi");
						  }
						  return true;
						  break;
						  //Blaze Enchant Pickaxe
						  case "cup4":
						  $p = $this->getServer()->getPlayer($sender->getName());
						  $item = Item::get(278, 0, 1);
						  $name = $item->setCustomName("§r§bCúp Ánh Sáng");
						  $item->setLore(array("§e§l▀▀▀▀▀§6▀▀▀[§9 Thông Tin§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n§dCúp Được Thần Apollo Tinh Luyện \n§e§l▀▀▀▀▀§6▀▀▀[§9 Thuộc Tính§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n §b§l➞§Đào Nhanh§f: §e 60 \n §§b§l➞§Chậm Hỏng§f: §e 25 \n§e§l▀▀▀▀▀§6▀▀▀[§9 Lưu Ý§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n §c§l*Tránh làm mất mọi trường hợp! \n §c§l*Nếu làm mất admin sẽ không chịu trách nhiệm§f"));						  
						  if($sender->getInventory()->contains(Item::get(378,0,3))){
							  $item->addEnchantment(Enchantment::getEnchantment(15)->setLevel(60));
							  $item->addEnchantment(Enchantment::getEnchantment(17)->setLevel(25));
							  $sender->getInventory()->addItem($item);
							  $sender->getInventory()->removeItem(Item::get(378,0,3));
							  $sender->sendMessage(TF::YELLOW . "Bạn đã đổi cúp ánh sáng với 3 Hỏa Ngọc");
						  }
						  else{
							  $sender->sendMessage(TF::RED . "Bạn không có vật phẩm để đổi");
						  }
						  return true;
						  break;
						  case "cup5":
						  $p = $this->getServer()->getPlayer($sender->getName());
						  $item = Item::get(278, 0, 1);
						  $name = $item->setCustomName("§r§bCúp Bóng Tối");
						  $item->setLore(array("§e§l▀▀▀▀▀§6▀▀▀[§9 Thông Tin§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n§dCúp Được Thần Hades Tinh Luyện \n§e§l▀▀▀▀▀§6▀▀▀[§9 Thuộc Tính§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n §b§l➞§Đào Nhanh§f: §e 90 \n §§b§l➞§Chậm Hỏng§f: §e 30 \n§e§l▀▀▀▀▀§6▀▀▀[§9 Lưu Ý§9 ]§6▀▀▀§e§l▀▀▀▀▀§f \n §c§l*Tránh làm mất mọi trường hợp! \n §c§l*Nếu làm mất admin sẽ không chịu trách nhiệm§f"));						  
						  if($sender->getInventory()->contains(Item::get(351,3,3))){
							  $item->addEnchantment(Enchantment::getEnchantment(15)->setLevel(90));
							  $item->addEnchantment(Enchantment::getEnchantment(17)->setLevel(30));
							  $sender->getInventory()->addItem($item);
							  $sender->getInventory()->removeItem(Item::get(351,3,3));
							  $sender->sendMessage(TF::YELLOW . "Bạn đã đổi cúp bóng tối với 3 Thổ Ngọc");
						  }
						  else{
							  $sender->sendMessage(TF::RED . "Bạn không có vật phẩm để đổi");
						  }
						  return true;
						  break;						  
						//Gian hàng ngày Tết (chỉ mở bán nhân Tết!)
						  case "kimngoc":
						  $p = $this->getServer()->getPlayer($sender->getName());
						  $item = Item::get(344, 0, 1);
						  $name = $item->setCustomName("§r§eKim Ngọc");
						  if($sender->getInventory()->contains(Item::get(173,0,32))){
							  $item->addEnchantment(Enchantment::getEnchantment(17)->setLevel(696969));
							  $sender->getInventory()->addItem($item);
							  $sender->getInventory()->removeItem(Item::get(173,0,32));
							  $sender->sendMessage(TF::YELLOW . "Bạn đã đổi thành công 1 Kim Ngọc");
						  }
						  else{
							  $sender->sendMessage(TF::RED . "Bạn không có vật phẩm để đổi");
						  }
						  return true;
						  break;
						  case "mocngoc":
						  $p = $this->getServer()->getPlayer($sender->getName());
						  $item = Item::get(341, 0, 1);
						  $name = $item->setCustomName("§r§aMộc Ngọc");
						  if($sender->getInventory()->contains(Item::get(41,0,32))){
							  $item->addEnchantment(Enchantment::getEnchantment(17)->setLevel(696969));
							  $sender->getInventory()->addItem($item);
							  $sender->getInventory()->removeItem(Item::get(41,0,32));
							  $sender->sendMessage(TF::YELLOW . "Bạn đã đổi thành công 1 Mộc Ngọc");
						  }
						  else{
							  $sender->sendMessage(TF::RED . "Bạn không có vật phẩm để đổi");
						  }
						  return true;
						  break;
						  case "thuyngoc":
						  $p = $this->getServer()->getPlayer($sender->getName());
						  $item = Item::get(351, 12, 1);
						  $name = $item->setCustomName("§r§bThủy Ngọc");
						  if($sender->getInventory()->contains(Item::get(42,0,32))){
							  $item->addEnchantment(Enchantment::getEnchantment(17)->setLevel(696969));
							  $sender->getInventory()->addItem($item);
							  $sender->getInventory()->removeItem(Item::get(42,0,32));
							  $sender->sendMessage(TF::YELLOW . "Bạn đã đổi thành công 1 Thủy Ngọc");
						  }
						  else{
							  $sender->sendMessage(TF::RED . "Bạn không có vật phẩm để đổi");
						  }
						  return true;
						  break;
						  case "hoangoc":
						  $p = $this->getServer()->getPlayer($sender->getName());
						  $item = Item::get(378, 0, 1);
						  $name = $item->setCustomName("§r§cHỏa Ngọc");
						  if($sender->getInventory()->contains(Item::get(57,0,32))){
							  $item->addEnchantment(Enchantment::getEnchantment(17)->setLevel(696969));
							  $sender->getInventory()->addItem($item);
							  $sender->getInventory()->removeItem(Item::get(57,0,32));
							  $sender->sendMessage(TF::YELLOW . "Bạn đã đổi thành công 1 Hỏa Ngọc");
						  }
						  else{
							  $sender->sendMessage(TF::RED . "Bạn không có vật phẩm để đổi");
						  }
						  return true;
						  break;
						  case "thongoc":
						  $p = $this->getServer()->getPlayer($sender->getName());
						  $item = Item::get(351, 3, 1);
						  $name = $item->setCustomName("§r§6Thổ Ngọc");
						  if($sender->getInventory()->contains(Item::get(133,0,32))){
							  $item->addEnchantment(Enchantment::getEnchantment(17)->setLevel(696969));
							  $sender->getInventory()->addItem($item);
							  $sender->getInventory()->removeItem(Item::get(133,0,32));
							  $sender->sendMessage(TF::YELLOW . "Bạn đã đổi thành công 1 Thổ Ngọc");
						  }
						  else{
							  $sender->sendMessage(TF::RED . "Bạn không có vật phẩm để đổi");
						  }
						  return true;
						  break;
					   }
				return true;
				   }
				}
			}
		}
	}
}