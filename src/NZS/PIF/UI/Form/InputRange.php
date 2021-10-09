<?php

namespace NZS\PIF\UI\Form;

use NZS\PIF\KhaiBao;
//use NZS\PIF\Config;
use pocketmine\{Player, Server};
use jojoe7777\FormAPI;

class InputRange
{
    //public Config $config;

    public function __construct(Player $player){
        $this->inputRange($player);
    }

    public function getPlugin(): ?KhaiBao
    {
        $khaibao = Server::getInstance()->getPluginManager()->getPlugin("KhaiBaoThongTin");
        if($khaibao instanceof KhaiBao){
            return $khaibao;
        }
        return null;
    }

    public function inputRange($player)
    {
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createCustomForm(Function (Player $player, $d){
            if(count($d) < 3) {
                $player->sendMessage($this->getPlugin()->kb . "§l§c Điền hết thông tin vào!");
                return false;
            }
            $age = $d[1];
            $marry = $d[2];

            # Marry
            if($this->getPlugin()->marry->exists($player->getName())){
                $this->getPlugin()->marry->remove($player->getName());
            }else{
                if($this->getPlugin()->marry->get($player->getName()) == "No"){
                    $this->getPlugin()->setMarried($player, "Non-Marry");
                    $player->sendMessage($this->getPlugin()->kb . "§l§a Thanks For the anwser!");
                }else{
                    $this->getPlugin()->setMarried($player, $marry);
                }
                return;
            }

            # Age
            if(count($this->getPlugin()->age->get($player->getName())) < 15){
                $player->sendPopup("§l§cYou need be > 15 Old!");
                $this->getPlugin()->setAge($player, "Warning: < 15");
            }elseif(count($this->getPlugin()->age->get($player->getName())) > 15){
                $this->getPlugin()->setAge($player, $age);
                Server::getInstance()->getLogger()->info("§bSaved success Data For Age YAML, Data: ".$player->getName().", Age: ". $age);
                $player->sendMessage("Saved Success!");
            }
        });

        $f->setTitle($this->getPlugin()->kb);
        $f->addLabel("Draw you information!");
        $f->addInput("Age: (Tuổi)");
        //$f->addDropDown("Marry", ["Yes", "No"]);
        $f->addInput("Married:");
        $f->sendToPlayer($player);
    }
}