<?php


namespace NZS\PIF\Command;

use NZS\PIF\KhaiBao;
use NZS\PIF\UI\UI;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
//use pocketmine\plugin\PluginOwned;

class KB extends Command
{
    public KhaiBao $khaibao;

    public function __construct(KhaiBao $plugin){
        $this->khaibao = $plugin;
        parent::__Construct("khaibao");
        $this->setDescription("Khai Báo Y Tế Đi thằng lợn!");
    }

    public function getPlugin(): KhaiBao
    {
        return $this->khaibao;
    }

    public function execute(CommandSender $player, string $commandLabel, array $args): void
    {
        /**if(!($player instanceof ConsoleCommandSender)){
            $this->getPlugin()->getServer()->getLogger()->warning($this->getPlugin()->kb . "USE IN-GAME!");
            return;
        }*/
        new UI($player);
        return;
    }

    public function getOwningPlugin(): Plugin
    {
        return $this->getPlugin();
    }
}