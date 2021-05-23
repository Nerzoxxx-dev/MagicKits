<?php

namespace MagicKits\Nerzox;

use MagicKits\Nerzox\Core;
use pocketmine\Player;

class API{

    /**
     * @var $datafolder
     */
    private $datafolder;

    /**
     * @var $bdd
     */
    protected static $bdd;

    public function __construct(){
        $this->datafolder = Core::getInstance()->getDataFolder();
    }

    public static function getDatabase() :\SQLite3 {
        return self::$bdd = new \SQLite3($this->datafolder .'Database/time.db');
    }

    public static function init() :void{
        $db = self::getDatabase();
        
        $db->query('CREATE TABLE IF NOT EXISTS timekit(playername VARCHAR(255), playertime TIMESTAMP)');
        $db->close();
    }

    public static function isRegisted(Player $player) :bool {
        $db = self::getDatabase();

        $name = strtolower($player->getName());
        $req = $db->query("SELECT * where playername = '$name'")
        $arr = $req->fetchArray();
        $db->close();

        if(empty($arr)){
            return true;
        }else{
            return false;
        }
        return false;
    }

    public static function register(Player $player, int $time) :void{
        $db = self::getDatabase();
        
        $name = strtolower($player->getName());
        $db->query("INSERT INTO timekit(playername, playertime) VALUES ('$name', '$time')");
        $db->close();
    }

    public static function setTime(Player $player, int $time) :void {
        $db = self::getDatabase();

        $name = strtolower($player->getName());
        if(self::isRegisted($player)){
            $db->query("UPDATE timekit SET playertime = '$time' WHERE playername = '$name'");
        }else{
            self::register($player, $time);
        }
        $db->close();
    }
    
    public static function getTime(Player $player) :int{
        $db = self::getDatabase();

        $name = strtolower($player->getName());
        $req = $db->query("SELECT * WHERE playername='$name'");
        $arr = $req->fetchArray();

        return time() - $arr['playertime'];
    }
}