<?php

namespace PTK\CustomEnchants\Tasks;

use PTK\CustomEnchants\CustomEnchants\CustomEnchants;
use PTK\CustomEnchants\Main;
use pocketmine\level\particle\FlameParticle;
use pocketmine\Player;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;

/**
 * Class JetpackTask
 * @package PTK\CustomEnchants\Tasks
 */
class JetpackTask extends PluginTask
{
    private $plugin;

    /**
     * JetpackTask constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }

    /**
     * @param $currentTick
     */
    public function onRun( $currentTick)
    {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $enchantment = $this->plugin->getEnchantment($player->getInventory()->getBoots(), CustomEnchants::JETPACK);
            if ($enchantment !== null) {
                if (isset($this->plugin->flying[strtolower($player->getName())]) && $this->plugin->flying[strtolower($player->getName())] > time()) {
                    if ($this->plugin->flying[strtolower($player->getName())] - 30 <= time()) {
						$t = str_repeat(" ", 85);
                        $player->sendPopup($t.TextFormat::RED . "Năng Lượng Ở Mức Thấp. " . floor($this->plugin->flying[strtolower($player->getName())] - time()) . " seconds of power remaining.");
                    } else {
                        $time = ($this->plugin->flying[strtolower($player->getName())] - time());
                        $time = is_float($time / 15) ? floor($time / 15) + 1 : $time / 15;
                        $color = $time > 10 ? TextFormat::GREEN : $time > 5 ? TextFormat::YELLOW : TextFormat::RED;
						$t = str_repeat(" ", 85);
                        $player->sendPopup($t."§a  JetPack Đang Hoạt Động\n".$t.$color . "Năng Lượng: " . str_repeat("▌", $time));
                    }
                    $this->fly($player, $enchantment->getLevel());
                    continue;
                }
            }
            if (isset($this->plugin->flying[strtolower($player->getName())])) {
                if ($this->plugin->flying[strtolower($player->getName())] > time()) {
                    $this->plugin->flyremaining[strtolower($player->getName())] = $this->plugin->flying[strtolower($player->getName())] - time();
                    unset($this->plugin->jetpackcd[strtolower($player->getName())]);
                }
                unset($this->plugin->flying[strtolower($player->getName())]);
                $player->sendPopup($t.TextFormat::RED . "JetPack Đã Tắt.");
            }
            if (isset($this->plugin->flyremaining[strtolower($player->getName())])) {
                if ($this->plugin->flyremaining[strtolower($player->getName())] < 300) {
                    if (!isset($this->plugin->jetpackChargeTick[strtolower($player->getName())])) {
                        $this->plugin->jetpackChargeTick[strtolower($player->getName())] = 0;
                    }
                    $this->plugin->jetpackChargeTick[strtolower($player->getName())]++;
                    if ($this->plugin->jetpackChargeTick[strtolower($player->getName())] >= 30) {
                        $this->plugin->flyremaining[strtolower($player->getName())]++;
                    }
                }
            }
        }
    }

    /**
     * @param Player $player
     * @param $level
     */
    public function fly(Player $player, $level)
    {
        $player->setMotion($player->getDirectionVector()->multiply($level));
        $player->getLevel()->addParticle(new FlameParticle($player));
    }
}