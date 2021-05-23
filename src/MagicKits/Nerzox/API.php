<?php

namespace MagicKits\Nerzox;

use MagicKits\Nerzox\Core;
use pocketmine\Player;

class API{


    /**
     * @var $bdd
     */
    protected static $bdd;

    public static function getDatabase() :\SQLite3 {
        return self::$bdd = new \SQLite3(Core::getInstance()->getDataFolder() .'Database/time.db');
    }

    public static function init() :void{
        $db = self::getDatabase();
        
        $db->query('CREATE TABLE IF NOT EXISTS timekit(playername VARCHAR(255), playertime TIMESTAMP, kitname VARCHAR(255))');
        $db->close();
    }

    public static function isRegisted(Player $player, string $kitname) :bool {
        $db = self::getDatabase();

        $name = strtolower($player->getName());
        $req = $db->query("SELECT * FROM timekit WHERE playername = '$name' AND kitname = '$kitname'");
        $arr = $req->fetchArray();
        $db->close();

        var_dump($arr);
        if(empty($arr)){
            return false;
        }else{
            return true;
        }
        return false;
    }

    public static function register(Player $player, int $time, string $kitname) :void{
        $db = self::getDatabase();
        
        $name = strtolower($player->getName());
        $db->query("INSERT INTO timekit(playername, playertime, kitname) VALUES ('$name', '$time', '$kitname')");
        $db->close();
    }

    public static function setTime(Player $player, int $time, string $kitname) :void {
        $db = self::getDatabase();

        $name = strtolower($player->getName());
        if(self::isRegisted($player, $kitname)){
            $db->query("UPDATE timekit SET playertime = '$time' WHERE playername = '$name' AND kitname = '$kitname'");
        }else{
            self::register($player, $time, $kitname);
        }
        $db->close();
    }
    
    public static function getTime(Player $player, int $time, string $kitname, int $cooldown){
        $db = self::getDatabase();

        $name = strtolower($player->getName());
        $req = $db->query("SELECT * FROM timekit WHERE playername='$name' AND kitname = '$kitname'");
        $arr = $req->fetchArray();
        $db->close();

        return $arr['playertime'] + $cooldown;
    }

    public static function hasTime(Player $player, string $kitname) :bool{
        if(self::isRegisted($player, $kitname)){
            return true;
        }else{
            return false;
        }
        return false;
    }
}