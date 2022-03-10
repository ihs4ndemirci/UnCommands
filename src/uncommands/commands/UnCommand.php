<?php

namespace uncommands\commands;

use uncommands\UnCommands;

use pocketmine\player\Player;
use pocketmine\Server;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\plugin\PluginOwned;

class UnCommand extends Command implements PluginOwned{

  private $plugin;

  public function getOwningPlugin() : UnCommands {
    return $this->plugin;
  }

  public function __construct($name, UnCommands $plugin){
    parent::__construct("uncommand", "UnCommands", "/uncommand <command>");
    $this->plugin = $plugin;
    $this->setPermission("uncommands.command");
  }

  public function execute(CommandSender $sender, string $label, array $args): bool{
    if($sender->hasPermission("uncommands.command")){
      if(!$args){
        $sender->sendMessage("Usage: /uncommand <command>");
      }else{
        $arg = $args[0];
        if($arg != "uncommand"){
          UnCommands::getAPI()->addCommandList($arg);
          UnCommands::getAPI()->unCommand($arg);
          $sender->sendMessage("$arg command disabled.");
        }else{
          $sender->sendMessage("No No No!");
        }
      }
    }else{
      $sender->sendMessage("You can't use this command.");
    }
    return true;
  }
}