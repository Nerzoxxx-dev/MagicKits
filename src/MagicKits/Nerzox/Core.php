<?php

namespace MagicKits\Nerzox;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use MagicKits\Nerzox\{
    lang\Language,
    Commands\KitsCommand,
    API
};

class Core extends PluginBase {

    public static $i;

    public $kitsfile;
    public $configfile;
    public $cooldownfile;
    public $langarray;
    public $lang;
    protected $bdd;

    public function onEnable() :void {
        $this->initConfig();

        self::$i = $this;

        $this->getServer()->getCommandMap()->registerAll('KitsCommand',
            [new KitsCommand($this)]);

        @mkdir($this->getDataFolder() . 'Database/');
        $this->bdd = new \SQLite3($this->getDataFolder() . 'Database/time.db');
        API::init();

        $this->getLogger()->info($this->getLang()['PLUGIN_ENABLED']);
    }

    public function onDisable() :void{
        $this->getLogger()->info($this->getLang()['PLUGIN_DISABLED']);
    }

    public function initConfig() :void{
        $DATAFOLDER = $this->getDataFolder();
        @mkdir($DATAFOLDER);
        $this->saveResource('kits.yml');
        $this->saveResource('config.yml');
        $this->kitsfile = new Config($this->getDataFolder() . "kits.yml", Config::YAML);
        $this->configfile = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }


    public static function getInstance() :self {
        return self::$i;
    }


    public function getKitsFile() :Config {
        return $this->kitsfile = new Config($this->getDataFolder() . "kits.yml", Config::YAML);
    }


    public function getConfigFile() :Config {
        return $this->configfile = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function getLang(){
        $this->lang = strtoupper($this->getConfigFile()->get('lang'));
        if($this->lang === 'EN'){
            return Language::EN;
        }elseif($this->lang === 'FR'){
            return Language::FR;
        }
        return Language::EN;
    }
}