<?php

namespace NZS\PIF\UI\Form;

use NZS\PIF\KhaiBao;
use NZS\PIF\UI\UI;
use pocketmine\{Player, Server};
use jojoe7777\FormAPI;

class InputRange
{
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
            $married = $this->getPlugin()->kh->get($player->getName());
            switch($marry){
                case "Yes":
                    $this->getPlugin()->marry->set($player->getName(), ["Married" => $married]);
                    $this->getPlugin()->marry->save();
                    break;
                case "No":
                    $this->getPlugin()->marry->set($player->getName(), ["Married" => False]);
                    $this->getPlugin()->marry->save();
                    break;
            }
            $this->getPlugin()->age->set($player->getName(), ["Age" => $age]);
            $this->getPlugin()->age->save();
        });

        $f->setTitle($this->getPlugin()->kb);
        $f->addLabel("Draw you information!");
        $f->addInput("Age: (Tuổi)");
        $f->addDropDown("Marry", ["Yes", "No"]);
        $f->sendToPlayer($player);
    }
}