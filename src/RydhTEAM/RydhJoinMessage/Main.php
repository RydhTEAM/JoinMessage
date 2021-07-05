<?php

namespace RydhTEAM\RydhJoinMessage;

use pocketmine\{
	Server, Plugin
};

use pocketmine\plugin\{
	PluginBase
};

use pocketmine\event\{
	Listener
};

use pocketmine\event\player\{
	PlayerJoinEvent, PlayerQuitEvent
};

use pocketmine\math\{
	Vector3
};

use pocketmine\utils\{
	Config, TextFormat
};

class Main extends PluginBase implements Listener{

 public function onEnable() : void{
    @mkdir($this->getDataFolder());
    $this->saveDefaultConfig();
    $this->getResource("config.yml");
    $this->config = $this->getConfig()->getAll();
        $this->getServer()->getPluginManager()->registerEvents($this, $this); 
		}
		
	public function onJoin(PlayerJoinEvent $event) {
        $sender = $event->getPlayer();
		$rank = $this->getServer()->getPluginManager()->getPlugin("PurePerms")->getUserDataMgr()->getData($sender)['group'];
		$name = $sender->getDisplayName();
		$event->setJoinMessage(TextFormat::colorize(str_replace(["{rank}", "{name}"], ["$rank", "$name"], strval($this->getConfig()->get("join-message")))));
	    $message = str_replace(["{name}", "{rank}"], [$name, $rank], $this->config["player-message"]);
	    $sender->sendMessage($message);
    }
    
 public function onQuit(PlayerQuitEvent $event) {
 	$sender = $event->getPlayer();
     $rank = $this->getServer()->getPluginManager()->getPlugin("PurePerms")->getUserDataMgr()->getData($sender)['group'];
     $name = $sender->getDisplayName ();
     $event->setQuitMessage(TextFormat::colorize(str_replace(["{rank}", "{name}"], ["$rank", "$name"], strval($this->getConfig()->get("quit-message")))));
    }
}