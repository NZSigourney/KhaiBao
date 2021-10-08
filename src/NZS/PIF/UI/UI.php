<?php


namespace NZS\PIF\UI;

use NZS\PIF\KhaiBao;
use NZS\PIF\Command\KB;
use pocketmine\Player;
use pocketmine\Server;
use jojoe7777\FormAPI;

class UI
{

    /**
     * UI constructor.
     * @param CommandSender|Player $player
     */

    public function __construct(Player $player)
    {
        $this->openForm($player);
    }

    public function getPlugin(): ?KhaiBao
    {
        $khaibao = Server::getInstance()->getPluginManager()->getPlugin("KhaiBaoThongTin");
        if($khaibao instanceof KhaiBao)
        {
            return $khaibao;
        }
        return null;
    }

    public function openForm($player){
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createSimpleForm(Function (Player $player, $data){
            $r = $data;
            if($r == null){
                return;
            }
            switch($r){
                case 0:
                    $this->inputRange($player);
                    break;
                case 1:
                    $this->outputRange($player);
                    break;
            }
        });

        $f->setTitle($this->getPlugin()->kb);
        $f->setContent("§l§aXem thông tin Bạn ở đây!");
        $f->addButton("Nhập dữ liệu ở đây", 0);
        $f->addButton("Xem dữ liệu đã nhập và kiểm tra", 1);
        $f->sendToPlayer($player);
    }

    public function inputRange($player){
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createCustomForm(Function (Player $player, $d){
            $this->getPlugin()->inf->set($player->getName(), ["Age" => $d[1], "Married" => $d[2]]);
            $this->getPlugin()->inf->save();
            $d[1] = $this->getPlugin()->inf->get($player->getName())["Age"];
            if(is_numeric($d[1])){
                $player->sendMesage("§l§cOnly Number!");
            }else{
                $this->inputRange($player);
                return;
            }
            /**if ($d[2] == "Yes" or "yes") {
                $d = array($this->getPlugin()->kh->get($player->getName()));
                return;
            }elseif($d[2] == "No" or "no"){
                $d = "Non-Marry";
            }else{
                $this->exited($player);
                return;
            }*/
        });

        $f->setTitle($this->getPlugin()->kb);
        $f->addLabel("Draw you information!");
        $f->addInput("Age: (Tuổi)");
        $f->addInput("Marry: (Cưới chưa? (/kethon) | Yes or No Only");
        $f->sendToPlayer($player);
    }

    public function outputRange($player){
        $inf = $this->getPlugin()->inf->get($player->getName());
        $age = $inf["Age"];
        $married = $inf["Marry"];
        if($married == "yes" or "Yes"){
            $output = $this->getPlugin()->kh->get($player->getName());
        }elseif($married == "no" or "No"){
            $output = "Non-Marry";
        }

        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createCustomForm(Function (Player $player, $d){
        });

        $f->setTitle($this->getPlugin()->kb);
        $f->addLabel($this->getPlugin()->getConfig()->get("Word.GUIDE"));
        $f->addLabel("§aAge (Tuổi): ". $age);
        $f->addLabel("§aMarry: ". $output);
        $f->sendToPlayer($player);
    }
}