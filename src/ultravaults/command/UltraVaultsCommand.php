<?php
namespace ultravaults\command;

use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use ultravaults\Core;

/**
 * Developed by TheAz928 (IOTATeam)
 * This software is under GPL v3 and later
 * Modifications to this software is allowed
 * Under the GPL license
 */

class UltraVaultsCommand extends Command{
	
	/** @var array */
	private $op_cmds = [
	  "seevault",
	  "delvault"
	];
	
	/**
	 * IDK ;)
	 */
	
	public function __construct(){
	    parent::__construct("ultravaults", "Open your vaults!", null, ["v", "pv", "uv", "vault"]);
	}
	
	/**
	 * @param CommandSender $player
	 * @param string $label
	 * @param array $args
	 */
	
	public function execute(CommandSender $player, string $label, array $args){
	    if($player instanceof Player == false){
	       $player->sendMessage(Core::getPrefix()."You cannot use that here!");
	    return false;
	    }
	    if(isset($args[0])){
	      if(is_numeric($args[0])){
		     if(((Int) $args[0] <= Core::get("max.vault") or $player->hasPermission(Core::get("perm")["open.perm"].$args[0])) and (Int) $args[0] > 0){
			    $inv = Core::initVault($args[0], $player->getName(), $player);
			    $player->addWindow($inv);
			  }else{
			    $player->sendMessage(Core::getPrefix()."§7You don't have permission to open that vault!");
			  }
		   return true;
		   }
		 }else{
			$player->sendMessage(Core::getPrefix()."§7Kindly provide a vault number! /vault [1, 2, 3....]");
       return false;
		 }
	    if($player->hasPermission(Core::get("perm")["vault.access.other"])){
		   if(in_array($args[0], $this->op_cmds)){
			  switch($args[0]){
			     case "seevault":
			        if(isset($args[1]) == false or isset($args[2]) == false){
				       $player->sendMessage(Core::getPrefix()."§7/ultravaults seevault {player name} {vault id}");
				     return false;
				     }
				     $check = Core::getVaultContents((Int) $args[2], $args[1]);
				     if($check === []){
					    $player->sendMessage(Core::getPrefix()."§7Vault doesn't exists or empty!");
					  return false;
					  }
					  $inv = Core::initVault((Int) $args[2], $args[1], $player);
					  $player->addWindow($inv);
			     break;
			     case "delvault":
			       if(isset($args[1]) == false or isset($args[2]) == false){
				       $player->sendMessage(Core::getPrefix()."/ultravaults delvault {player name} {vault id}");
				     return false;
				     }
				     $check = Core::getVaultContents((Int) $args[2], $args[1]);
				     if($check === []){
					    $player->sendMessage(Core::getPrefix()."§7Vault doesn't exists or empty!");
					  return false;
					  }
					  Core::saveVault((Int) $args[2], $args[1], []);
					  $player->sendMessage(Core::getPrefix()."§7Deleted the vault!");
			     break;
			  }
			}else{
			  $player->sendMessage(Core::getPrefix()."§7Unknown subcommand! Try, ");
			  $player->sendMessage("§l§8»§r§7 seevault [player] [vault id] - See [player]'s vault");
			  $player->sendMessage("§l§8»§r§7 delvault [player] [vault id] - Delete [player]'s vault");
			}
		}else{
			$player->sendMessage(Core::getPrefix()."§7Kindly provide a vault number! /vault [1, 2, 3....]");
     return false;
		}
	return true;
	}
}