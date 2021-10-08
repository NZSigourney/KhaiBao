<?php

namespace NZS\PIF;

use pocketmine\plugin\PluginBase;
//use pocketmine\command\{Command, CommandSender};
use pocketmine\{Server, Player};
// Utils
use pocketmine\utils\Config;
// Plugin
use jojoe7777\FormAPI;
use NZS\PIF\Command\KB;
// Event
use pocketmine\event\Listener;

class KhaiBao extends PluginBase implements Listener{

    public $kb = "§l§a<§e•§a>§c Info§bUI§a <§e•§a>";
    //public $config = [];

    public function onEnable(): void{
        //$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register("khaibao", new KB($this));

        $this->getServer()->getLogger()->info("§l§b Starting Khai Bao Plugin | Version BETA-1");
        @mkdir($this->getDataFolder(), 0744, true);
        $this->age = new Config($this->getDataFolder() . "Age.yml", Config::YAML, []);
        $this->marry = new Config($this->getDataFolder() . "Marry.yml", Config::YAML, []);
        $this->kh = new Config($this->getServer()->getDataPath() . "Plugin_Data/Marry/marrylist.yml", Config::YAML);

        /**$this->saveDefaultConfig();
        $this->getResource("Config.yml");*/

        $this->getServer()->getLogger()->debug("Starting new YAML KhaiBao and Default Config: Config.yml");
    }

    public function onDisable(){
        /**
         * @params Player
         */
        $this->getLogger()->debug("goodLuck!");
    }
}