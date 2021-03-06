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

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\sound\ButtonClickSound;
use pocketmine\math\Vector3;
use pocketmine\Player;

class Lever extends Flowable {
	protected $id = self::LEVER;

	public function __construct(int $meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Lever";
	}

	public function getHardness(): float{
        return 0.5;
    }

    public function getVariantBitmask(): int{
        return 0;
    }

    public function onUpdate(int $type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			$faces = [
                0 => Vector3::SIDE_UP,
                1 => Vector3::SIDE_WEST,
                2 => Vector3::SIDE_EAST,
                3 => Vector3::SIDE_NORTH,
                4 => Vector3::SIDE_SOUTH,
                5 => Vector3::SIDE_DOWN,
                6 => Vector3::SIDE_DOWN,
                7 => Vector3::SIDE_UP
			];

            if(!$this->getSide($faces[$this->meta & 0x07])->isSolid()){
                $this->level->useBreakOn($this);

                return $type;
			}
		}
		return false;
	}

	public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
        if(!$blockClicked->isSolid()){
            return false;
        }

        if($face === Vector3::SIDE_DOWN){
            $this->meta = 0;
        }else{
            $this->meta = 6 - $face;
        }

        if($player !== null){
            if(($player->getDirection() & 0x01) === 0){
                if($face === Vector3::SIDE_UP){
                    $this->meta = 6;
                }
            } else {
                if($face === Vector3::SIDE_DOWN){
                    $this->meta = 7;
                }
            }
        }

        return $this->level->setBlock($blockReplace, $this, true, true);
    }
}