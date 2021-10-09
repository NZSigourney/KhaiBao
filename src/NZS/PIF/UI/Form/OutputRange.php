<?php


namespace NZS\PIF\UI\Form;

use NZS\PIF\KhaiBao;
use NZS\PIF\UI\UI;
use pocketmine\{Player, Server};
use jojoe7777\FormAPI;

class OutputRange
{
    public function __construct(Player $player)
    {
        $this->outputRange($player);
    }

    public function getPlugin(): ?KhaiBao
    {
        $khaibao = Server::getInstance()->getPluginManager()->getPlugin("KhaiBaoThongTin");
        if($khaibao instanceof KhaiBao){
            return $khaibao;
        }
        return null;
    }

    public function outputRange($player){
        $age = $this->getPlugin()->age->get(strtolower($player->getName()));
        $marry = $this->getPlugin()->marry->get($player->getName());
        $kh = $this->getPlugin()->kh->get($player->getName());
        //$married = $marry;
        if($this->getPlugin()->marry->set($marry) == "No"){
            $married = "Non-Marry";
        }else{
            $married = $kh;
        }
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createCustomForm(Function (Player $player, $d){
        });
        $f->setTitle($this->getPlugin()->kb);
        $f->addLabel("================");
        $f->addLabel("Age: ". $age);
        $f->addLabel("Marry: ". $married);
        $f->sendToPlayer($player);
    }
}