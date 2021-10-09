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

    public function setAge($player, string $age){
        $this->age->set($player, $age);
        $this->age->save();
    }

    public function setMarried($player, $married){
        $this->marry->set($player, $married);
        $this->marry->save();
    }

    public function checkAge($player)
    {
        if($this->age->exists($player)){
            return true;
        }
        return false;
    }

    public function checkMarried($player)
    {
        if($this->marry->exists($player)){
            return true;
        }
        return false;
    }

    public function seeAge($player){
        if($this->checkAge($player)){
            $age = $this->age->get($player);
            return $age;
        }
        return false;
    }

    public function seeMarried($player)
    {
        if($this->checkMarried($player)){
            $married = $this->marry->get($player);
            return $married;
        }
        return false;
    }
}