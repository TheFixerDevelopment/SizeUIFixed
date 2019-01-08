<?php
namespace SizeUI;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use jojoe77777\FormAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\server\ServerCommandEvent;
class Main extends PluginBase implements Listener{   
    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents(($this), $this);
        $this->getLogger()->info("SizeUI Enabled");
    }
    public function onDisable(): void{
        $this->getServer()->getPluginManager()->registerEvents(($this), $this);
        $this->getLogger()->info("SizeUI Disabled");
    }
    public function checkDepends(): void{
        $this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if(is_null($this->formapi)){
            $this->getLogger()->error("SizeUI Requires FormAPI To Work");
            $this->getPluginLoader()->disablePlugin($this);
        }
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool{
        if($cmd->getName() == "size"){
            if(!($sender instanceof Player)){
                if(!$sender->hasPermission("sizeui.command")){
                $sender->sendMessage("§cYou do not have permission to use this command!");
                return true;
            } else {
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, $data){
                $result = $data;
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
                        $sender->sendMessage("§bSize updated to §3Mini (Scale 1) §bsuccessfully.");
                        $sender->$setScale("1");
                        break;
                    case 1:
                        $sender->sendMessage("§bSize updated to §3Normal (Scale 2) §bsuccessfully!");
                        $sender->$setScale("2");
                        break;
                    case 2:
                        $sender->sendMessage("§bSize updated to §3Big (Scale 3) §bsuccessfully!");
                        $sender->$setScale("3");
                        break;
                    case 3:
                        $sender->sendMessage("§bScale updated to §3VeryBig (Scale 4) §bsuccessfully!");
                        $sender->$setScale("4");
                        break;
                    case 4:
                        $sender->sendMessage("§cYou have exited out of the scale UI successfully!");
                        break;
                }
            });
            $form->setTitle("§lScaleUI Menu");
            $form->setContent("§lchoose your favorite size!");
            $form->addButton("§lMini");
            $form->addButton("§lNormal");
            $form->addButton("§lBig");
            $form->addButton("§lVery Big");
            $form->addButton("§lBack");
            $form->sendToPlayer($sender);
        }
        return true;
    }
}
