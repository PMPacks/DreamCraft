<?php
namespace MyPlot\subcommand;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\item\Item;
use pocketmine\nbt\NBT;
use pocketmine\tile\Tile;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\IntTag;

class ClaimSubCommand extends SubCommand
{
    public function canUse(CommandSender $sender) {
        return ($sender instanceof Player) and $sender->hasPermission("myplot.command.claim");
    }

    public function execute(CommandSender $sender, array $args) {
        if (count($args) > 1) {
            return false;
        }
        $name = "";
        if (isset($args[0])) {
            $name = $args[0];
        }
        $player = $sender->getServer()->getPlayer($sender->getName());
        $plot = $this->getPlugin()->getPlotByPosition($player->getPosition());
        if ($plot === null) {
            $sender->sendMessage(TextFormat::RED . $this->translateString("notinplot"));
            return true;
        }
        if ($plot->owner != "") {
            if ($plot->owner === $sender->getName()) {
                $sender->sendMessage(TextFormat::RED . $this->translateString("claim.yourplot"));
            } else {
                $sender->sendMessage(TextFormat::RED . $this->translateString("claim.alreadyclaimed", [$plot->owner]));
            }
            return true;
        }

        $maxPlots = $this->getPlugin()->getMaxPlotsOfPlayer($player);
        $plotsOfPlayer = count($this->getPlugin()->getProvider()->getPlotsByOwner($player->getName()));
        if ($plotsOfPlayer >= $maxPlots) {
            $sender->sendMessage(TextFormat::RED . $this->translateString("claim.maxplots", [$maxPlots]));
            return true;
        }

        $plotLevel = $this->getPlugin()->getLevelSettings($plot->levelName);
        $economy = $this->getPlugin()->getEconomyProvider();
        if ($economy !== null and !$economy->reduceMoney($player, $plotLevel->claimPrice)) {
            $sender->sendMessage(TextFormat::RED . $this->translateString("claim.nomoney"));
            return true;
        }

        $plot->owner = $sender->getName();
        $plot->name = $name;
        if ($this->getPlugin()->getProvider()->savePlot($plot)) {
            $sender->sendMessage($this->translateString("claim.success"));
			
			$f = $this->getPlugin()->getPlotPosition($plot);
			$plotSize = $this->getPlugin()->getLevelSettings($plot->levelName)->plotSize;
			$f->x += floor($plotSize / 2) - 3;
			$f->z -= -89;
			$f->y += 0;
			
			$sender->getLevel()->setBlock(new \pocketmine\math\Vector3($f->x, $f->y, $f->z), \pocketmine\block\Block::get(\pocketmine\block\Block::CHEST), true, true);
			
			$nbt = new CompoundTag("", [
			new ListTag("Items", []),
			new StringTag("id", Tile::CHEST),
			new IntTag("x", $f->x),
			new IntTag("y", $f->y),
			new IntTag("z", $f->z)
		]);
		$nbt->Items->setTagType(NBT::TAG_Compound);
		
		//$sender->getLevel()->getChunk($sender->getX() >> 4, $sender->getZ() >> 4) <- nếu chuyển qua genisys thì sửa cái này vào $sender->getLevel()
		$tile = Tile::createTile("Chest",$sender->getLevel(), $nbt);
			//Tạo Chest
			$ie1 = Item::get(278, 0, 1);
			$ie1->setCustomName("§r§eCúp SkyBlock");
			$ie1->setLore(array("§d§lVật Phẩm Cho Người Khởi đầu"));
			$ie1->addEnchantment(Enchantment::getEnchantment(17)->setLevel(5));
			$ie1->addEnchantment(Enchantment::getEnchantment(15)->setLevel(2));
			$i = $tile->getInventory();
			$ip = $player->getInventory();
			$i->addItem(Item::get(2, 0, 16));
			$i->addItem(Item::get(8, 0, 2));
			$i->addItem(Item::get(Item::FENCE, 0, 2));
			$ip->addItem(Item::get(276, 0, 1));
			$ip->addItem($ie1);
			$i->addItem(Item::get(6, 0, 2));
			$i->addItem(Item::get(81, 0, 3));
			$i->addItem(Item::get(295, 0, 5));
			$i->addItem(Item::get(338, 0, 3));
			$i->addItem(Item::get(352, 0, 10));
			$i->addItem(Item::get(361, 0, 3));
			$i->addItem(Item::get(362, 0, 3));
			$i->addItem(Item::get(391, 0, 3));
			$i->addItem(Item::get(392, 0, 3));
			$i->addItem(Item::get(54, 0, 1));
			$i->addItem(Item::get(364, 0, 5));
            $sender->sendMessage("§9[§9SkyBlock§9] §aMua Đảo Thành Công !!!");
            $sender->sendMessage("§9[§9SkyBlock§9] §bFENCE + WATER = BLOCK!");
			$sender->sendMessage("§9[§9SkyBlock§9] §cHãy Cẩn Thận, Nước Là A-Xít!");
			} else {
            $sender->sendMessage(TextFormat::RED . $this->translateString("error"));
        }
        return true;
    }
}