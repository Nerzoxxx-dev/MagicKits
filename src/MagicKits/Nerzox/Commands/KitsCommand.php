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

        if(!args[0]) return $this->kitsUI($p);
    }
    public function kitsUI(Player $p){
        $form = new SimpleForm(function(Player $p, int $data){
            if(is_null($data)) return;

            $arr = [];
            foreach($this->c->getKitsFile()->getAll() as $k){
                $arr[] = $k;
            }
            foreach($arr as $num => $n){
                switch($data){
                    case $num:
                        if(!is_null($thid->c->getKitsFile()->get($n)['permission'])){
                            if(!$p->hasPermission($this->c->getKits()->get($n)['permission']){
                                return $player->sendMessage($this->c->getLang()['NOT_PERMISSION_KIT']);
                            }
                        }
                        
                    break;       
                }
            }
        });
    }
}