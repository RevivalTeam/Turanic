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

namespace pocketmine\item\enchantment;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;

/**
 * Manages enchantment type data.
 */
class Enchantment {

	const TYPE_INVALID = -1;

    const PROTECTION = 0;
    const FIRE_PROTECTION = 1;
    const FEATHER_FALLING = 2;
    const BLAST_PROTECTION = 3;
    const PROJECTILE_PROTECTION = 4;
    const THORNS = 5;
    const RESPIRATION = 6;
    const DEPTH_STRIDER = 7;
    const AQUA_AFFINITY = 8;
    const SHARPNESS = 9;
    const SMITE = 10;
    const BANE_OF_ARTHROPODS = 11;
    const KNOCKBACK = 12;
    const FIRE_ASPECT = 13;
    const LOOTING = 14;
    const EFFICIENCY = 15;
    const SILK_TOUCH = 16;
    const UNBREAKING = 17;
    const FORTUNE = 18;
    const POWER = 19;
    const PUNCH = 20;
    const FLAME = 21;
    const INFINITY = 22;
    const LUCK_OF_THE_SEA = 23;
    const LURE = 24;
    const FROST_WALKER = 25;
    const MENDING = 26;

    const RARITY_COMMON = 10;
    const RARITY_UNCOMMON = 5;
    const RARITY_RARE = 2;
    const RARITY_MYTHIC = 1;

    const SLOT_NONE = 0x0;
    const SLOT_ALL = 0x7fff;
    const SLOT_ARMOR = self::SLOT_HEAD | self::SLOT_TORSO | self::SLOT_LEGS | self::SLOT_FEET;
    const SLOT_HEAD = 0x1;
    const SLOT_TORSO = 0x2;
    const SLOT_LEGS = 0x4;
    const SLOT_FEET = 0x8;
    const SLOT_SWORD = 0x10;
    const SLOT_BOW = 0x20;
    const SLOT_TOOL = self::SLOT_HOE | self::SLOT_SHEARS | self::SLOT_FLINT_AND_STEEL;
    const SLOT_HOE = 0x40;
    const SLOT_SHEARS = 0x80;
    const SLOT_FLINT_AND_STEEL = 0x100;
    const SLOT_DIG = self::SLOT_AXE | self::SLOT_PICKAXE | self::SLOT_SHOVEL;
    const SLOT_AXE = 0x200;
    const SLOT_PICKAXE = 0x400;
    const SLOT_SHOVEL = 0x800;
    const SLOT_FISHING_ROD = 0x1000;
    const SLOT_CARROT_STICK = 0x2000;
    const SLOT_ELYTRA = 0x4000;


	/** @var Enchantment[] */
	public static $enchantments;

	public static function init(){
		self::$enchantments = new \SplFixedArray(256);

        self::registerEnchantment(new ProtectionEnchantment(self::PROTECTION, "%enchant.protect.all", self::RARITY_COMMON, self::SLOT_ARMOR, 4, 0.75, null));
        self::registerEnchantment(new ProtectionEnchantment(self::FIRE_PROTECTION, "%enchantment.protect.fire", self::RARITY_UNCOMMON, self::SLOT_ARMOR, 4, 1.25, [
            EntityDamageEvent::CAUSE_FIRE,
            EntityDamageEvent::CAUSE_FIRE_TICK,
            EntityDamageEvent::CAUSE_LAVA
            //TODO: check fireballs
        ]));
        self::registerEnchantment(new ProtectionEnchantment(self::FEATHER_FALLING, "%enchantment.protect.fall", self::RARITY_UNCOMMON, self::SLOT_FEET, 4, 2.5, [
            EntityDamageEvent::CAUSE_FALL
        ]));
        self::registerEnchantment(new ProtectionEnchantment(self::BLAST_PROTECTION, "%enchantment.protect.explosion", self::RARITY_RARE, self::SLOT_ARMOR, 4, 1.5, [
            EntityDamageEvent::CAUSE_BLOCK_EXPLOSION,
            EntityDamageEvent::CAUSE_ENTITY_EXPLOSION
        ]));
        self::registerEnchantment(new ProtectionEnchantment(self::PROJECTILE_PROTECTION, "%enchantment.protect.projectile", self::RARITY_UNCOMMON, self::SLOT_ARMOR, 4, 1.5, [
            EntityDamageEvent::CAUSE_PROJECTILE
        ]));

		self::registerEnchantment(new Enchantment(self::THORNS, "%enchantment.protect.thorns", self::RARITY_UNCOMMON, self::SLOT_SWORD, 3, 8));
		self::registerEnchantment(new Enchantment(self::DEPTH_STRIDER, "%enchantment.waterspeed", self::RARITY_UNCOMMON, self::SLOT_FEET, 3, 4));
		self::registerEnchantment(new Enchantment(self::AQUA_AFFINITY, "%enchantment.protect.wateraffinity", self::RARITY_UNCOMMON,  self::SLOT_FEET, 1, 4));
		self::registerEnchantment(new Enchantment(self::SHARPNESS, "%enchantment.weapon.sharpness", self::RARITY_UNCOMMON,  self::SLOT_SWORD, 5, 1));
		self::registerEnchantment(new Enchantment(self::SMITE, "%enchantment.weapon.smite", self::RARITY_UNCOMMON,  self::SLOT_SWORD, 5, 2));
		self::registerEnchantment(new Enchantment(self::BANE_OF_ARTHROPODS, "%enchantment.weapon.arthropods", self::RARITY_UNCOMMON,  self::SLOT_SWORD, 5, 2));
		self::registerEnchantment(new Enchantment(self::KNOCKBACK, "%enchantment.weapon.knockback", self::RARITY_UNCOMMON,  self::SLOT_SWORD, 2, 2));
		self::registerEnchantment(new Enchantment(self::FIRE_ASPECT, "%enchantment.weapon.fireaspect", self::RARITY_UNCOMMON,  self::SLOT_SWORD, 2, 4));
		self::registerEnchantment(new Enchantment(self::LOOTING, "%enchantment.weapon.looting", self::RARITY_UNCOMMON,  self::SLOT_SWORD, 3, 4));
        self::registerEnchantment(new Enchantment(self::FORTUNE, "%enchantment.mining.fortune", self::RARITY_UNCOMMON,  self::SLOT_TOOL, 3, 4));
        self::registerEnchantment(new Enchantment(self::POWER, "%enchantment.bow.power", self::RARITY_UNCOMMON,  self::SLOT_BOW, 5, 1));
        self::registerEnchantment(new Enchantment(self::PUNCH, "%enchantment.bow.knockback", self::RARITY_UNCOMMON,  self::SLOT_BOW, 2, 4));
        self::registerEnchantment(new Enchantment(self::FLAME, "%enchantment.bow.flame", self::RARITY_UNCOMMON,  self::SLOT_BOW, 1, 4));
        self::registerEnchantment(new Enchantment(self::INFINITY, "%enchantment.bow.infinity", self::RARITY_UNCOMMON, self::SLOT_BOW, 1, 8));
        self::registerEnchantment(new Enchantment(self::LUCK_OF_THE_SEA, "%enchantment.fishing.fortune", self::RARITY_UNCOMMON, self::SLOT_FISHING_ROD, 3, 4));
        self::registerEnchantment(new Enchantment(self::LURE, "%enchantment.fishing.lure", self::RARITY_UNCOMMON, self::SLOT_FISHING_ROD, 3, 4));

        self::registerEnchantment(new Enchantment(self::RESPIRATION, "%enchantment.oxygen", self::RARITY_RARE, self::SLOT_HEAD, 3, 4));

        self::registerEnchantment(new Enchantment(self::EFFICIENCY, "%enchantment.digging", self::RARITY_COMMON, self::SLOT_DIG | self::SLOT_SHEARS, 5, 1));

        self::registerEnchantment(new Enchantment(self::SILK_TOUCH, "%enchantment.untouching", self::RARITY_MYTHIC, self::SLOT_DIG | self::SLOT_SHEARS, 1, 8));
        self::registerEnchantment(new Enchantment(self::UNBREAKING, "%enchantment.durability", self::RARITY_UNCOMMON, self::SLOT_ALL, 3, 2));
    }

    /**
     * Registers an enchantment type.
     *
     * @param Enchantment $enchantment
     */
    public static function registerEnchantment(Enchantment $enchantment){
        self::$enchantments[$enchantment->getId()] = clone $enchantment;
    }

	/**
	 * @param int $id
	 *
	 * @return Enchantment
	 */
	public static function getEnchantment(int $id){
        return self::$enchantments[$id] ?? null;
	}

	/**
	 * @param $name
	 *
	 * @return Enchantment|null
	 */
	public static function getEnchantmentByName(string $name){
        $const = Enchantment::class . "::" . strtoupper($name);
        if(defined($const)) {
            return self::getEnchantment(constant($const));
        }
        return null;
	}

	/**
	 * @param Item $item
	 *
	 * @return int
	 */
	public static function getEnchantAbility(Item $item) : int{
		switch($item->getId()){
			case Item::BOOK:
			case Item::BOW:
			case Item::FISHING_ROD:
				return 4;
			// armors
            case Item::CHAIN_HELMET:
            case Item::CHAIN_CHESTPLATE:
            case Item::CHAIN_LEGGINGS:
            case Item::CHAIN_BOOTS:
                return 12;
            case Item::IRON_HELMET:
            case Item::IRON_CHESTPLATE:
            case Item::IRON_LEGGINGS:
            case Item::IRON_BOOTS:
                return 9;
            case Item::DIAMOND_HELMET:
            case Item::DIAMOND_CHESTPLATE:
            case Item::DIAMOND_LEGGINGS:
            case Item::DIAMOND_BOOTS:
                return 10;
            case Item::LEATHER_CAP:
            case Item::LEATHER_TUNIC:
            case Item::LEATHER_PANTS:
            case Item::LEATHER_BOOTS:
                return 15;
            case Item::GOLD_HELMET:
            case Item::GOLD_CHESTPLATE:
            case Item::GOLD_LEGGINGS:
            case Item::GOLD_BOOTS:
                return 25;

            case Item::WOODEN_HOE:
            case Item::WOODEN_AXE:
            case Item::WOODEN_PICKAXE:
            case Item::WOODEN_SWORD:
            case Item::WOODEN_SHOVEL:
                return 15;
            case Item::STONE_HOE:
            case Item::STONE_AXE:
            case Item::STONE_PICKAXE:
            case Item::STONE_SWORD:
            case Item::STONE_SHOVEL:
                return 5;
            case Item::DIAMOND_HOE:
            case Item::DIAMOND_AXE:
            case Item::DIAMOND_PICKAXE:
            case Item::DIAMOND_SWORD:
            case Item::DIAMOND_SHOVEL:
                return 10;
            case Item::IRON_HOE:
            case Item::IRON_AXE:
            case Item::IRON_PICKAXE:
            case Item::IRON_SWORD:
            case Item::IRON_SHOVEL:
                return 14;
            case Item::GOLD_HOE:
            case Item::GOLD_AXE:
            case Item::GOLD_PICKAXE:
            case Item::GOLD_SWORD:
            case Item::GOLD_SHOVEL:
                return 22;
            default:
                return 0;
		}
	}

	/**
	 * @param int $enchantmentId
	 *
	 * @return int
	 */
	public static function getEnchantWeight(int $enchantmentId){
	    $ench = Enchantment::getEnchantment($enchantmentId);
		return $ench != null ? $ench->getRarity() : 0;
	}

	/**
	 * @param int $enchantmentId
	 *
	 * @return int
	 */
	public static function getEnchantMaxLevel(int $enchantmentId) : int{
        $ench = Enchantment::getEnchantment($enchantmentId);
        return $ench != null ? $ench->getMaxLevel() : 999;
	}

	/** @var int */
	private $id;
	/** @var string */
	private $name;
	/** @var int */
	private $rarity;
	/** @var int */
	private $slot;
	/** @var int */
	private $maxLevel;
	/** @var int */
	private $repairCost;

    /**
     * Enchantment constructor.
     *
     * @param int $id
     * @param string $name
     * @param int $rarity
     * @param int $slot
     * @param int $maxLevel
     * @param int $repairCost
     */
	public function __construct(int $id, string $name, int $rarity, int $slot, int $maxLevel, int $repairCost = 1){
		$this->id = $id;
		$this->name = $name;
		$this->rarity = $rarity;
		$this->slot = $slot;
		$this->maxLevel = $maxLevel;
		$this->repairCost = $repairCost;
	}

	/**
     * Returns the ID of this enchantment as per Minecraft BE
	 * @return int
	 */
	public function getId() : int{
		return $this->id;
	}

	/**
     * Returns a translation key for this enchantment's name.
	 * @return string
	 */
	public function getName() : string{
		return $this->name;
	}

	/**
     * Returns an int constant indicating how rare this enchantment type is.
	 * @return int
	 */
	public function getRarity() : int{
		return $this->rarity;
	}

	/**
     * Returns an int with bitflags set to indicate what item types this enchantment can apply to.
	 * @return int
	 */
	public function getSlot() : int{
		return $this->slot;
	}

	/**
     * Returns whether this enchantment can apply to the specified item type.
	 * @param $slot
	 *
	 * @return bool
	 */
	public function hasSlot($slot) : bool{
		return ($this->slot & $slot) > 0;
	}

    /**
     * Returns the maximum level of this enchantment that can be found on an enchantment table.
     * @return int
     */
    public function getMaxLevel(): int{
        return $this->maxLevel;
    }
	public function getMinEnchantability(int $enchLevel){
		return 1 + $enchLevel * 10;
	}

	public function getMaxEnchantability(int $enchLevel){
		return $this->getMinEnchantability($enchLevel) + 5;
	}


	/**
	 * @param Enchantment $ent
	 *
	 * @return bool
	 */
	public function equals(Enchantment $ent) : bool{
		return $ent === $this;
	}

	public function getRepairCost(bool $isBook = false) : int{
	    return $this->repairCost === 1 ? $this->repairCost : $this->repairCost / 2;
    }

    //TODO: methods for min/max XP cost bounds based on enchantment level (not needed yet - enchanting is client-side)
}
