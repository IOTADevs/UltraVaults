<?php
namespace ultravaults;

use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\tile\Tile;
use pocketmine\tile\Chest;

use pocketmine\block\Block;

use pocketmine\event\Listener;

use pocketmine\level\Position;

use ultravaults\vault\VaultInventory;
use ultravaults\command\UltraVaultsCommand;

/**
 * Developed by TheAz928 (IOTATeam)
 * This software is under GPL v3 and later
 * Modifications to this software is allowed
 * Under the GPL license
 */

class Core extends PluginBase implements Listener{
	
	/** @var string */
	private static $vaultPath = '';
	
	/** @var Core */
	private static $instance;
	
	public function onLoad(){
       self::$instance = $this;
		 $this->saveDefaultConfig();
		 if(is_dir($this->getDataFolder()."vaults/") == false){
			@mkdir($this->getDataFolder()."vaults/");
		 }
		 self::$vaultPath = $this->getDataFolder()."vaults/";
	}
	
	public function onEnable(){
	    $this->getServer()->getCommandMap()->register("UltraVaults", new UltraVaultsCommand());
	}
	
	/**
	 * @return string
	 */
	
	public static function getPrefix(): string{
	    return str_replace("&", "§", self::get("prefix", "")."&r ");
	}
	
	/**
	 * @param mixed $str
	 * @param mixed $default
	 * @return mixed
	 */
	
	public static function get($str, $default = null){
	    $file = self::$instance->getConfig();
	    $file->reload();
	return $file->get($str, $default);
	}
	
	/**
	 * @param Int $vaultId
	 * @param string $owner
	 * @param array $contents
	 */
	
	public static function saveVault(Int $vaultId, string $owner, array $contents): void{
	    $owner = strtolower($owner);
		 if(is_dir(self::$vaultPath.$owner) == false){
			@mkdir(self::$vaultPath.$owner);
		 }
		 if(file_exists(self::$vaultPath.$owner."/vault.".$vaultId.".dat")){
			unlink(self::$vaultPath.$owner."/vault.".$vaultId.".dat");
		 }
		 $compressed = gzcompress(serialize($contents));
		 file_put_contents(self::$vaultPath.$owner."/vault.".$vaultId.".dat", $compressed);
	}
	
	/**
	 * @param Int $vaultId
	 * @param string $owner
	 * @return array
	 */
	
	public static function getVaultContents(Int $vaultId, string $owner): array{
	    $owner = strtolower($owner);
	    if(is_dir(self::$vaultPath.$owner) == false or file_exists(self::$vaultPath.$owner."/vault.".$vaultId.".dat") == false){
	      return [];
	    }
	    $contents = unserialize(gzuncompress(file_get_contents(self::$vaultPath.$owner."/vault.".$vaultId.".dat")));
	return $contents ?? [];
	}
	
	/**
	 * @param Int $vaultId
	 * @param string $owner
	 * @param Player $pos
	 * @return VaultInventory|null
	 */
	
	public static function initVault(Int $vaultId, string $owner, Player $player): ?VaultInventory{
		 $pos = new Position($player->x, $player->y + 1, $player->z, $player->level);
	    $nbt = Chest::createNBT($pos);
	    $nbt->setString("CustomName", "[".$owner."] VaultID: ".$vaultId);
	    $tile = Tile::createTile("Chest", $pos->level, $nbt);
	    $block = Block::get(Block::CHEST);
	    $block->x = $tile->x;
	    $block->y = $tile->y;
	    $block->z = $tile->z;
	    $block->level = $tile->level;
	    $tile->getLevel()->sendBlocks([$player], [$block]);
	    $inv = new VaultInventory($tile, $vaultId, $owner);
	    $items = self::getVaultContents($vaultId, $owner);
	    $inv->setContents($items);
	return $inv;
	}
}
