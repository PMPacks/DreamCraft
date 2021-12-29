<?php

namespace PTK\CustomEnchants\Tasks;


use PTK\CustomEnchants\CustomEnchants\CustomEnchants;
use PTK\CustomEnchants\Main;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;

/**
 * Class MeditationTask
 * @package PTK\CustomEnchants\Tasks
 */
class MeditationTask extends PluginTask
{
    private $plugin;

    /**
     * MeditationTask constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }

    /**
     * @param int $currentTick
     */
    public function onRun( $currentTick)
    {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            $enchantment = $this->plugin->getEnchantment($player->getInventory()->getHelmet(), CustomEnchants::MEDITATION);
            if ($enchantment !== null) {
                if (!isset($this->plugin->meditationTick[strtolower($player->getName())])) {
                    $this->plugin->meditationTick[strtolower($player->getName())] = 0;
                }
                $this->plugin->meditationTick[strtolower($player->getName())]++;
                $time = $this->plugin->meditationTick[strtolower($player->getName())] / 40;
                $player->sendTip(TextFormat::DARK_GREEN . "Meditating...\n " . TextFormat::GREEN . str_repeat("▌", $time));
                if ($this->plugin->meditationTick[strtolower($player->getName())] >= 20 * 20) {
                    $this->plugin->meditationTick[strtolower($player->getName())] = 0;
                    $event = new EntityRegainHealthEvent($player, $enchantment->getLevel(), EntityRegainHealthEvent::CAUSE_MAGIC);
                    if (!$event->isCancelled()) {
                        $player->heal($event);
                    }
                    $player->setFood($player->getFood() + $enchantment->getLevel() > 20 ? 20 : $player->getFood() + $enchantment->getLevel());
                }
            }
        }
    }
}