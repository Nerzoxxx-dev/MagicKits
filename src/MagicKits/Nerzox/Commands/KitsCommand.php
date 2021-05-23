<?php

namespace MagicKits\Nerzox\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\item\Item;

use jojoe77777\FormAPI\SimpleForm;

use MagicKits\Nerzox\{
    Core,
    API   
};

class KitsCommand extends Command{

    public $c;

    public function __construct(Core $c){
        $this->c = $c;
        parent::__construct('kit', $this->c->getLang()['DESCRIPTION_COMMAND'], $this->c->getLang()['USAGE_COMMAND'], ['kits']);
    }

    public function execute(CommandSender $p, string $commandLabel, array $args){
        if(!$p instanceof Player){
            return $p->sendMessage('§c' . $this->c->getLang()['NOT_A_PLAYER']);
        }

        if(!isset($args[0])) return $this->kitsUI($p);
        $bool = false;
        $arr = [];
        if(isset($args[0])) {
            foreach($this->c->getKitsFile() as $k){
                if($args[0] == $k['name']){
                    $bool = true;
                    $arr = $k;
                }
            }
            if($bool){
                if($p->hasPermission($arr['permission'])){

                }
            }
        }
    }
    public function kitsUI(Player $p){
        $form = new SimpleForm(function(Player $p, int $data = null){

            $arr = [];
            foreach($this->c->getKitsFile()->getAll() as $k){
                $arr[] = $k;
            }

            if($data === null) return;
            foreach($arr as $num => $n){
                switch($data){
                    case $num:
                        if(isset($n['permission'])){
                            if(!$p->hasPermission($n['permission'])){
                                return $p->sendMessage($this->c->getLang()['NOT_PERMISSION_KIT']);
                            }
                        }
                        if(API::hasTime($p, $n['name'])){
                            if(API::getTime($p, time(), $n['name'], $n['cooldown']) <= time()){
                                $itemsarray = $n['items'];
                                $allitemarray = [];
                                foreach($itemsarray as $itemname => $iteminfo){
                                    $itemarray = explode(':', $iteminfo);
                                    $allitemarray[] = $itemarray;
                                }
                                if($this->hasSlotsFree($p, count($allitemarray))){
                                    foreach($allitemarray as $k => $info){
                                        $p->getInventory()->addItem(Item::get($info[0], $info[1], $info[2]));
                                    }
                                    API::setTime($p, time(), $n['name']);
                                    $p->sendMessage('§2' . $this->c->getLang()['KIT_GIVED']);
                                }else{
                                    return $p->sendMessage('§c' . $this->c->getLang()['CANT_GIVE_KIT']);
                                }
                        }else{
                            $itemsarray = $n['items'];
                            $allitemarray = [];
                            foreach($itemsarray as $itemname => $iteminfo){
                                $itemarray = explode(':', $iteminfo);
                                $allitemarray[] = $itemarray;
                            }
                            if($this->hasSlotsFree($p, count($allitemarray))){
                                foreach($allitemarray as $k => $info){
                                    $p->getInventory()->addItem(Item::get($info[0], $info[1], $info[2]));
                                }
                                API::setTime($p, time(), $n['name']);
                                $p->sendMessage('§2' . $this->c->getLang()['KIT_GIVED']);
                            }else{
                                return $p->sendMessage('§c' . $this->c->getLang()['CANT_GIVE_KIT']);
                            }
                        }
                        break;       
                    }
                }
            }
        });

        $form->setTitle($this->c->getConfigFile()->get('ui_title'));
        foreach($this->c->getKitsFile()->getAll() as $kits => $infoarray){
            if(isset($infoarray['permission'])){
                if($p->hasPermission($infoarray['permission'])){
                    $form->addButton($infoarray['name']);
                }
            }else{
                $form->addButton($infoarray['name']);
            }
        }
        $form->sendToPlayer($p);
    }

    public function calculTime(int $time)
    {
        $diff = abs($time- time());
        $retour = array();

        $tmp = $diff;
        $retour['s'] = $tmp % 60;

        $tmp = floor( ($tmp - $retour['s']) /60 );
        $retour['m'] = $tmp % 60;

        $tmp = floor( ($tmp - $retour['m'])/60 );
        $retour['h'] = $tmp % 24;

        $tmp = floor( ($tmp - $retour['h'])  /24 );
        $retour['d'] = $tmp;

        return $retour;
    }

    public function hasSlotsFree(Player $p, int $requireslots) :bool{
        $count = 0;
        foreach($p->getInventory()->getContents(true) as $i){
            if($i->getId() == 0){
                $count++;
            }
        }
        if($count >= $requireslots) {
            return true;
        }else{
            return false;
        }
        return true;
    }
}