<?php
namespace ultravaults\vault;

use pocketmine\Player;

use pocketmine\block\Block;

use pocketmine\tile\Chest;

use pocketmine\level\Level;

use pocketmine\math\Vector3;

use pocketmine\inventory\ChestInventory;

use ultravaults\Core;

/**
 * Developed by TheAz928 (IOTATeam)
 * This software is under GPL v3 and later
 * Modifications to this software is allowed
 * Under the GPL license
 */

class VaultInventory extends ChestInventory{
	
	/** @var Int */
	private $vaultId = -1;
	
	/** @var string */
	private $owner = "";
	
	/** @var Block[] */
	private $hidden = [];
	
	/**
	 * @param Chest $tile
	 */
	
	public function __construct(Chest $tile, Int $vaultId, string $owner){
			parent::__construct($tile);
			$this->vaultId = $vaultId;
       	$this->owner = $owner;
			foreach($tile->getLevel()->getTiles() as $chest){
				if($chest->distance($tile) <= 15 and $chest instanceof Chest and $chest->getId() !== $tile->getId()){
					$this->hidden[] = $tile->getLevel()->getBlock($chest);
				}
			}
	}
	
	/**
	 * @return Int
	 */
	
	public function getVaultId(): Int{
	    	return $this->vaultId;
	}
	
	/**
	 * @return string
	 */
	
	public function getOwner(): string{
	    	return $this->owner;
	}
	
	/**
	 * @param Player $player
	 */
	
	public function onOpen(Player $player) : void{
			foreach($this->hidden as $block){
				$air = Block::get(Block::AIR);
				$air->position($block);
				$player->getLevel()->sendBlocks([$player], [$air]);
			}
			parent::onOpen($player);
	}
	
	/**
	 * @param Player $player
	 *
	 * Since I'm not implementing MySQL support, no need async task to do this
	 */
	
	public function onClose(Player $player): void{
	    	parent::onClose($player);
	    	Core::saveVault($this->vaultId, $this->owner, $this->getContents());
	    	$this->clearAll();
	    	$block = Block::get(Block::AIR);
	    	$block->position($this->getHolder());
	    	$block->getLevel()->sendBlocks([$player], [$block]);
			$block->getLevel()->sendBlocks([$player], $this->hidden);
	    	$this->getHolder()->close();
	}
	
	/**
	 * This is just for fixing dupes
	 */
	
	public function dropContents(Level $level, Vector3 $pos): void{
	   # Can't drop :D
		# Vaults are seeecret
	}
}