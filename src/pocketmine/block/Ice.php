<?php

/*
 *
 *    _______                    _
 *   |__   __|                  (_)
 *      | |_   _ _ __ __ _ _ __  _  ___
 *      | | | | | '__/ _` | '_ \| |/ __|
 *      | | |_| | | | (_| | | | | | (__
 *      |_|\__,_|_|  \__,_|_| |_|_|\___|
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author TuranicTeam
 * @link https://github.com/TuranicTeam/Turanic
 *
 */

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;

class Ice extends Transparent{

	protected $id = self::ICE;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Ice";
	}

	public function getHardness() : float{
		return 0.5;
	}

    public function getLightFilter() : int{
        return 2;
    }

    public function getFrictionFactor() : float{
        return 0.98;
    }

	public function getToolType() : int{
		return BlockToolType::TYPE_PICKAXE;
	}

	public function onBreak(Item $item, Player $player = null) : bool{
		if(!$item->hasEnchantment(Enchantment::SILK_TOUCH)){
			$this->getLevel()->setBlock($this, BlockFactory::get(Block::WATER), true);
		}
		return parent::onBreak($item, $player);
	}

    public function ticksRandomly() : bool{
        return true;
    }

    public function onUpdate(int $type){
        if($type === Level::BLOCK_UPDATE_RANDOM){
            if($this->level->getHighestAdjacentBlockLight($this->x, $this->y, $this->z) >= 12){
                $this->level->useBreakOn($this);

                return $type;
            }
        }
        return false;
    }

	public function getDropsForCompatibleTool(Item $item) : array{
		return [];
	}
}
