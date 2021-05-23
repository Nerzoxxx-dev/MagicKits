<?php

namespace MagicKits\Nerzox\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use jojoe77777\FormAPI\SimpleForm;

use MagicKits\Nerzox\Core;

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
                        $itemsarray = $n['items'];
                        $allitemarray = [];
                        $bool = false;
                        foreach($itemsarray as $iteminfo){
                            $allitemarray[] = explode(':', $iteminfo);
                            if(!$p->getInventory()->canAddItem(explode(':', $iteminfo))) {
                                $bool = true;
                            }
                        }
                        if(!$bool){
                            foreach($allitemarray as $k => $info){
                                $p->getInventory()->addItem($info[0], $info[1], $info[2]);
                            }
                            $p->sendMessage('§2' . $this->c->getLang()['KIT_GIVED']);
                        }else{
                            return $p->sendMessage('§c' . $this->c->getLang()['CANT_GIVE_KIT']);
                        }

                    break;       
                }
            }
        });

        $form->setTitle($this->c->getConfigFile()->get('ui_title'));
        foreach($this->c->getKitsFile()->getAll() as $kits => $infoarray){
            $form->addButton($infoarray['name']);
        }
        $form->sendToPlayer($p);
    }
}