<?php

namespace uncommands;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

class UnCommands extends PluginBase{

    private static $main;

    private $cmds = 0;

	protected function onLoad() :void{
		self::$main = $this;
	}

    public static function getAPI():UnCommands{
        return self::$main;
    }
    
    protected function onEnable() :void {
		@mkdir($this->getDataFolder());
        if(!file_exists($this->getDataFolder() . "commands.txt")){
            $config = new Config($this->getDataFolder().'commands.txt', Config::ENUM);
        }

        $this->unCommands();
    }

    private function getDataBase(){
        return $config = new Config($this->getDataFolder().'commands.txt', Config::ENUM);
    }

    private function unCommands(){
        $cmds = 0;
        $commands = $this->getDataBase()->getAll();
        foreach(array_keys($commands) as $command){
            $cmds++;
            $this->unCommand($command);
        }
        $this->getLogger()->info($cmds . " commands disabled.");
    }

    private function unCommand($command){
        $commandMap = $this->getServer()->getCommandMap();
	$cmd = $commandMap->getCommand($command);
        if($cmd != null){
            $commandMap->unregister($cmd);
        }
    }
}
