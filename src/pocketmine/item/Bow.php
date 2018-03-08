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

namespace pocketmine\item;

use pocketmine\entity\Entity;
use pocketmine\entity\projectile\Projectile;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

class Bow extends Tool {

	public function __construct(int $meta = 0){
		parent::__construct(self::BOW, $meta, "Bow");
	}

    public function onReleaseUsing(Player $player) : bool{
        if($player->isSurvival() and !$player->getInventory()->contains(Item::get(Item::ARROW, -1))){
            $player->getInventory()->sendContents($player);
            return false;
        }

        $arrow = null;
        $index = $player->getInventory()->first(Item::get(Item::ARROW, -1));
        if($index !== -1){
            $arrow = $player->getInventory()->getItem($index);
            $arrow->setCount(1);
        }elseif($player->isCreative()){
            $arrow = Item::get(Item::ARROW, 0, 1);
        }else{
            $player->getInventory()->sendContents($player);
            return false;
        }

        $nbt = Entity::createBaseNBT($player->add(0, $player->getEyeHeight(), 0), $player->getDirectionVector(), ($player->yaw > 180 ? 360 : 0) - $player->yaw, -$player->pitch);
        $nbt->setShort("Fire", $player->isOnFire() ? 45 * 60 : 0);
        $nbt->setShort("Potion", $arrow->getDamage());

        $diff = $player->getItemUseDuration();
        $p = $diff / 20;
        $force = min((($p ** 2) + $p * 2) / 3, 1) * 2;


        $entity = Entity::createEntity("Arrow", $player->getLevel(), $nbt, $player, $force == 2);
        if($entity instanceof Projectile){
            $ev = new EntityShootBowEvent($player, $this, $entity, $force);

            if($force < 0.1 or $diff < 5){
                $ev->setCancelled();
            }

            $player->getServer()->getPluginManager()->callEvent($ev);

            $entity = $ev->getProjectile(); //This might have been changed by plugins

            if($ev->isCancelled()){
                $entity->flagForDespawn();
                $player->getInventory()->sendContents($player);
            }else{
                $entity->setMotion($entity->getMotion()->multiply($ev->getForce()));
                if($player->isSurvival()){
                    $player->getInventory()->removeItem(Item::get(Item::ARROW, 0, 1));
                    $this->applyDamage(1);
                }

                if($entity instanceof Projectile){
                    $player->getServer()->getPluginManager()->callEvent($projectileEv = new ProjectileLaunchEvent($entity));
                    if($projectileEv->isCancelled()){
                        $ev->getProjectile()->flagForDespawn();
                    }else{
                        $ev->getProjectile()->spawnToAll();					$player->getLevel()->broadcastLevelSoundEvent($player, LevelSoundEventPacket::SOUND_BOW);
			}

                }else{
                    $entity->spawnToAll();
                }
            }
        }else{
            $entity->spawnToAll();
        }
        return true;
    }

    public function getFuelTime(): int{
        return 200;
    }

    public function getMaxDurability() : int{
        return 385;
    }
}
