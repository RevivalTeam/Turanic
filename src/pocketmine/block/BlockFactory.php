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
use pocketmine\level\Position;
use pocketmine\utils\MainLogger;


class BlockFactory extends Block {
    /** @var \SplFixedArray<Block> */
    private static $list = null;
    /** @var \SplFixedArray<Block> */
    private static $fullList = null;

    /** @var \SplFixedArray<bool> */
    public static $solid = null;
    /** @var \SplFixedArray<bool> */
    public static $transparent = null;
    /** @var \SplFixedArray<float> */
    public static $hardness = null;
    /** @var \SplFixedArray<int> */
    public static $light = null;
    /** @var \SplFixedArray<int> */
    public static $lightFilter = null;
    /** @var \SplFixedArray<bool> */
    public static $diffusesSkyLight = null;
    /** @var \SplFixedArray<float> */
    public static $blastResistance = null;
	/** @var int[] */
	public static $staticRuntimeIdMap = [];

	/** @var int[] */
	public static $legacyIdMap = [];

	/** @var int */
	private static $lastRuntimeId = 0;


    /**
     * Initializes the block factory. By default this is called only once on server start, however you may wish to use
     * this if you need to reset the block factory back to its original defaults for whatever reason.
     *
     * @param bool $force
     */
    public static function init(bool $force = false){
        if(self::$list === null){
            self::$list = new \SplFixedArray(256);
            self::$fullList = new \SplFixedArray(4096);

            self::$light = new \SplFixedArray(256);
            self::$lightFilter = new \SplFixedArray(256);
            self::$solid = new \SplFixedArray(256);
            self::$hardness = new \SplFixedArray(256);
            self::$transparent = new \SplFixedArray(256);
            self::$diffusesSkyLight = new \SplFixedArray(256);

            self::registerBlock(new Air());
            self::registerBlock(new Stone());
            self::registerBlock(new Grass());
            self::registerBlock(new Dirt());
            self::registerBlock(new Cobblestone());
            self::registerBlock(new Planks());
            self::registerBlock(new Sapling());
            self::registerBlock(new Bedrock());
            self::registerBlock(new Water());
            self::registerBlock(new StillWater());
            self::registerBlock(new Lava());
            self::registerBlock(new StillLava());
            self::registerBlock(new Sand());
            self::registerBlock(new Gravel());
            self::registerBlock(new GoldOre());
            self::registerBlock(new IronOre());
            self::registerBlock(new CoalOre());
            self::registerBlock(new Wood());
            self::registerBlock(new Leaves());
            self::registerBlock(new Sponge());
            self::registerBlock(new Glass());
            self::registerBlock(new LapisOre());
            self::registerBlock(new Lapis());
            self::registerBlock(new Sandstone());
            self::registerBlock(new Dispenser());
            self::registerBlock(new Noteblock());
            self::registerBlock(new Bed());
            self::registerBlock(new PoweredRail());
            self::registerBlock(new DetectorRail());
            // TODO : Add Sticky Piston
            self::registerBlock(new Cobweb());
            self::registerBlock(new TallGrass());
            self::registerBlock(new DeadBush());
            // TODO : Add Piston
            self::registerBlock(new Wool());
            self::registerBlock(new Dandelion());
            self::registerBlock(new Flower());
            self::registerBlock(new BrownMushroom());
            self::registerBlock(new RedMushroom());
            self::registerBlock(new Gold());
            self::registerBlock(new Iron());
            self::registerBlock(new DoubleSlab());
            self::registerBlock(new Slab());
            self::registerBlock(new Bricks());
            self::registerBlock(new TNT());
            self::registerBlock(new Bookshelf());
            self::registerBlock(new MossyCobblestone());
            self::registerBlock(new Obsidian());
            self::registerBlock(new Torch());
            self::registerBlock(new Fire());
            self::registerBlock(new MonsterSpawner());
            self::registerBlock(new WoodenStairs(Block::OAK_WOOD_STAIRS, 0, "Oak Stairs"));
            self::registerBlock(new Chest());
            self::registerBlock(new RedstoneWire());
            self::registerBlock(new DiamondOre());
            self::registerBlock(new Diamond());
            self::registerBlock(new Workbench());
            self::registerBlock(new Wheat());
            self::registerBlock(new Farmland());
            self::registerBlock(new Furnace());
            self::registerBlock(new BurningFurnace());
            self::registerBlock(new SignPost());
            self::registerBlock(new WoodenDoor(Block::DOOR_BLOCK, 0, "Oak Door Block", Item::OAK_DOOR));
            self::registerBlock(new Ladder());
            self::registerBlock(new Rail());
            self::registerBlock(new CobblestoneStairs());
            self::registerBlock(new WallSign());
            self::registerBlock(new Lever());
            self::registerBlock(new StonePressurePlate());
            self::registerBlock(new IronDoor());
            self::registerBlock(new WoodenPressurePlate());
            self::registerBlock(new RedstoneOre());
            self::registerBlock(new GlowingRedstoneOre());
            // TODO: Add unlit redstone torch
            self::registerBlock(new RedstoneTorch());
            self::registerBlock(new StoneButton());
            self::registerBlock(new SnowLayer());
            self::registerBlock(new Ice());
            self::registerBlock(new Snow());
            self::registerBlock(new Cactus());
            self::registerBlock(new Clay());
            self::registerBlock(new Sugarcane());
            self::registerBlock(new Jukebox());
            self::registerBlock(new Fence());
            self::registerBlock(new Pumpkin());
            self::registerBlock(new Netherrack());
            self::registerBlock(new SoulSand());
            self::registerBlock(new Glowstone());
            self::registerBlock(new Portal());
            self::registerBlock(new LitPumpkin());
            self::registerBlock(new Cake());
            self::registerBlock(new UnpoweredRepeater());
            self::registerBlock(new PoweredRepeater());
            self::registerBlock(new InvisibleBedrock());
            self::registerBlock(new Trapdoor());
            self::registerBlock(new MonsterEggBlock());
            self::registerBlock(new StoneBricks());
            self::registerBlock(new BrownMushroomBlock());
            self::registerBlock(new RedMushroomBlock());
            self::registerBlock(new IronBars());
            self::registerBlock(new GlassPane());
            self::registerBlock(new Melon());
            self::registerBlock(new PumpkinStem());
            self::registerBlock(new MelonStem());
            self::registerBlock(new Vine());
            self::registerBlock(new FenceGate(Block::OAK_FENCE_GATE, 0, "Oak Fence Gate"));
            self::registerBlock(new BrickStairs());
            self::registerBlock(new StoneBrickStairs());
            self::registerBlock(new Mycelium());
            self::registerBlock(new WaterLily());
            self::registerBlock(new NetherBrick());
            self::registerBlock(new NetherBrickFence());
            self::registerBlock(new NetherBrickStairs());
            self::registerBlock(new NetherWartPlant());
            self::registerBlock(new EnchantingTable());
            self::registerBlock(new BrewingStand());
            self::registerBlock(new Cauldron());
            self::registerBlock(new EndPortal());
            self::registerBlock(new EndPortalFrame());
            self::registerBlock(new EndStone());
            self::registerBlock(new DragonEgg());
            self::registerBlock(new RedstoneLamp());
            self::registerBlock(new LitRedstoneLamp());
            self::registerBlock(new Dropper());
            self::registerBlock(new ActivatorRail());
            self::registerBlock(new CocoaBlock());
            self::registerBlock(new SandstoneStairs());
            self::registerBlock(new EmeraldOre());
            self::registerBlock(new EnderChest());
            self::registerBlock(new TripwireHook());
            self::registerBlock(new Tripwire());
            self::registerBlock(new Emerald());
            self::registerBlock(new WoodenStairs(Block::SPRUCE_STAIRS, 0, "Spruce Stairs"));
            self::registerBlock(new WoodenStairs(Block::BIRCH_STAIRS, 0, "Birch Stairs"));
            self::registerBlock(new WoodenStairs(Block::JUNGLE_STAIRS, 0, "Jungle Stairs"));
            self::registerBlock(new CommandBlock());
            self::registerBlock(new Beacon());
            self::registerBlock(new CobblestoneWall());
            self::registerBlock(new FlowerPot());
            self::registerBlock(new Carrot());
            self::registerBlock(new Potato());
            self::registerBlock(new WoodenButton());
            self::registerBlock(new Skull());
            self::registerBlock(new Anvil());
            self::registerBlock(new TrappedChest());
            self::registerBlock(new LightWeightedPressurePlate());
            self::registerBlock(new HeavyWeightedPressurePlate());
            self::registerBlock(new UnpoweredComparator());
            self::registerBlock(new PoweredComparator());
            self::registerBlock(new DaylightDetector());
            self::registerBlock(new Redstone());
            self::registerBlock(new NetherQuartzOre());
            self::registerBlock(new Hopper());
            self::registerBlock(new Quartz());
            self::registerBlock(new QuartzStairs());
            self::registerBlock(new DoubleWoodSlab());
            self::registerBlock(new WoodSlab());
            self::registerBlock(new StainedClay());
            self::registerBlock(new StainedGlassPane());
            self::registerBlock(new Leaves2());
            self::registerBlock(new Wood2());
            self::registerBlock(new WoodenStairs(Block::ACACIA_STAIRS, 0, "Acacia Stairs"));
            self::registerBlock(new WoodenStairs(Block::DARK_OAK_STAIRS, 0, "Dark Oak Stairs"));
            self::registerBlock(new SlimeBlock());
            self::registerBlock(new IronTrapdoor());
            self::registerBlock(new Prismarine());
            self::registerBlock(new SeaLantern());
            self::registerBlock(new HayBale());
            self::registerBlock(new Carpet());
            self::registerBlock(new HardenedClay());
            self::registerBlock(new Coal());
            self::registerBlock(new PackedIce());
            self::registerBlock(new DoublePlant());
            self::registerBlock(new StandingBanner());
            self::registerBlock(new WallBanner());
            self::registerBlock(new DaylightDetectorInverted());
            self::registerBlock(new RedSandstone());
            self::registerBlock(new RedSandstoneStairs());
            self::registerBlock(new DoubleRedSandstoneSlab());
            self::registerBlock(new RedSandstoneSlab());
            self::registerBlock(new FenceGate(Block::SPRUCE_FENCE_GATE, 0, "Spruce Fence Gate"));
            self::registerBlock(new FenceGate(Block::BIRCH_FENCE_GATE, 0, "Birch Fence Gate"));
            self::registerBlock(new FenceGate(Block::JUNGLE_FENCE_GATE, 0, "Jungle Fence Gate"));
            self::registerBlock(new FenceGate(Block::DARK_OAK_FENCE_GATE, 0, "Dark Oak Fence Gate"));
            self::registerBlock(new FenceGate(Block::ACACIA_FENCE_GATE, 0, "Acacia Fence Gate"));
            self::registerBlock(new RepeatingCommandBlock());
            self::registerBlock(new ChainCommandBlock());
            self::registerBlock(new WoodenDoor(Block::SPRUCE_DOOR_BLOCK, 0, "Spruce Door Block", Item::SPRUCE_DOOR));
            self::registerBlock(new WoodenDoor(Block::BIRCH_DOOR_BLOCK, 0, "Birch Door Block", Item::BIRCH_DOOR));
            self::registerBlock(new WoodenDoor(Block::JUNGLE_DOOR_BLOCK, 0, "Jungle Door Block", Item::JUNGLE_DOOR));
            self::registerBlock(new WoodenDoor(Block::ACACIA_DOOR_BLOCK, 0, "Acacia Door Block", Item::ACACIA_DOOR));
            self::registerBlock(new WoodenDoor(Block::DARK_OAK_DOOR_BLOCK, 0, "Dark Oak Door Block", Item::DARK_OAK_DOOR));
            self::registerBlock(new GrassPath());
            self::registerBlock(new ItemFrame());
            self::registerBlock(new ChorusFlower());
            self::registerBlock(new Purpur());
            self::registerBlock(new PurpurStairs());
            self::registerBlock(new UndyedShulkerBox());
            self::registerBlock(new EndStoneBricks());
            self::registerBlock(new FrostedIce());
            self::registerBlock(new EndRod());
            self::registerBlock(new EndGateway());
            self::registerBlock(new Magma());
            self::registerBlock(new NetherWartBlock());
            self::registerBlock(new RedNetherBrick());
            self::registerBlock(new BoneBlock());
            self::registerBlock(new ShulkerBox());
            self::registerBlock(new GlazedTerracotta(Block::PURPLE_GLAZED_TERRACOTTA, 0, "Purple Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::WHITE_GLAZED_TERRACOTTA, 0, "White Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::ORANGE_GLAZED_TERRACOTTA, 0, "Orange Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::MAGENTA_GLAZED_TERRACOTTA, 0, "Magenta Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::LIGHT_BLUE_GLAZED_TERRACOTTA, 0, "Light Blue Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::YELLOW_GLAZED_TERRACOTTA, 0, "Yellow Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::LIME_GLAZED_TERRACOTTA, 0, "Lime Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::PINK_GLAZED_TERRACOTTA, 0, "Pink Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::GRAY_GLAZED_TERRACOTTA, 0, "Grey Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::SILVER_GLAZED_TERRACOTTA, 0, "Light Grey Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::CYAN_GLAZED_TERRACOTTA, 0, "Cyan Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::BLUE_GLAZED_TERRACOTTA, 0, "Blue Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::BROWN_GLAZED_TERRACOTTA, 0, "Brown Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::GREEN_GLAZED_TERRACOTTA, 0, "Green Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::RED_GLAZED_TERRACOTTA, 0, "Red Glazed Terracotta"));
            self::registerBlock(new GlazedTerracotta(Block::BLACK_GLAZED_TERRACOTTA, 0, "Black Glazed Terracotta"));
            self::registerBlock(new Concrete());
            self::registerBlock(new ConcretePowder());
            self::registerBlock(new ChorusPlant());
            self::registerBlock(new StainedGlass());
            self::registerBlock(new Podzol());
            self::registerBlock(new Beetroot());
            self::registerBlock(new Stonecutter());
            self::registerBlock(new GlowingObsidian());
            self::registerBlock(new NetherReactor());
            /* TODO : ADD
            UPDATE_BLOCK
            ATEUPD_BLOCK
            BLOCK_MOVED_BY_PISTON
            OBSERVER
            STRUCTURE_BLOCK
            RESERVED6 */
            foreach(self::$list as $id => $block){
                if($block === null){
                    self::registerBlock(new UnknownBlock($id));
                }
            }
        }
    }


	/**
	 * @internal
	 *
	 * @param int $id
	 * @param int $meta
	 *
	 * @return int
	 */
	public static function toStaticRuntimeId(int $id, int $meta = 0) : int{
		if($id === Block::AIR){
			//TODO: HACK! (weird air blocks with non-zero damage values shouldn't turn into update! blocks)
			$meta = 0;
		}

		$index = ($id << 4) | $meta;
		if(!isset(self::$staticRuntimeIdMap[$index])){
			self::registerMapping($rtId = ++self::$lastRuntimeId, $id, $meta);
			MainLogger::getLogger()->error("ID $id meta $meta does not have a corresponding block static runtime ID, added a new unknown runtime ID ($rtId)");
			return $rtId;
		}


		/** @var mixed[] $runtimeIdMap */
		$runtimeIdMap = json_decode(file_get_contents(\pocketmine\RESOURCE_PATH . "runtimeid_table.json"), true);
		foreach($runtimeIdMap as $obj){
			self::registerMapping($obj["runtimeID"], $obj["id"], $obj["data"]);
		}

		return self::$staticRuntimeIdMap[$index];
	}

	/**
	 * @internal
	 *
	 * @param int $runtimeId
	 *
	 * @return int[] [id, meta]
	 */
	public static function fromStaticRuntimeId(int $runtimeId) : array{
		$v = self::$legacyIdMap[$runtimeId];
		return [$v >> 4, $v & 0xf];
	}

	private static function registerMapping(int $staticRuntimeId, int $legacyId, int $legacyMeta) : void{
		self::$staticRuntimeIdMap[($legacyId << 4) | $legacyMeta] = $staticRuntimeId;
		self::$legacyIdMap[$staticRuntimeId] = ($legacyId << 4) | $legacyMeta;
		self::$lastRuntimeId = max(self::$lastRuntimeId, $staticRuntimeId);
	}

    /**
     * Registers a block type into the index. Plugins may use this method to register new block types or override
     * existing ones.
     *
     * NOTE: If you are registering a new block type, you will need to add it to the creative inventory yourself - it
     * will not automatically appear there.
     *
     * @param Block $block
     * @param bool  $override Whether to override existing registrations
     *
     * @throws \RuntimeException if something attempted to override an already-registered block without specifying the
     * $override parameter.
     */
    public static function registerBlock(Block $block, bool $override = false){
        $id = $block->getId();

        if(!$override and self::isRegistered($id)){
            throw new \RuntimeException("Trying to overwrite an already registered block");
        }

        self::$list[$id] = clone $block;

        for($meta = 0; $meta < 16; ++$meta){
            $variant = clone $block;
            $variant->setDamage($meta);
            self::$fullList[($id << 4) | $meta] = $variant;
        }

        self::$solid[$id] = $block->isSolid();
        self::$transparent[$id] = $block->isTransparent();
        self::$hardness[$id] = $block->getHardness();
        self::$light[$id] = $block->getLightLevel();
        self::$lightFilter[$id] = $block->getLightFilter() + 1; //opacity plus 1 standard light filter
        self::$diffusesSkyLight[$id] = $block->diffusesSkyLight();
        self::$blastResistance[$id] = $block->getBlastResistance();
    }

    /**
     * Returns a new Block instance with the specified ID, meta and position.
     *
     * @param int      $id
     * @param int      $meta
     * @param Position $pos
     *
     * @return Block
     */
    public static function get(int $id, int $meta = 0, Position $pos = null) : Block{
        if($meta < 0 or $meta > 0xf){
            throw new \InvalidArgumentException("Block meta value $meta is out of bounds");
        }

        try{
            if(self::$fullList !== null){
                $block = clone self::$fullList[($id << 4) | $meta];
            }else{
                $block = new UnknownBlock($id, $meta);
            }
        }catch(\RuntimeException $e){
            throw new \InvalidArgumentException("Block ID $id is out of bounds");
        }

        if($pos !== null){
            $block->x = $pos->x;
            $block->y = $pos->y;
            $block->z = $pos->z;
            $block->level = $pos->level;
        }

        return $block;
    }

    /**
     * @internal
     * @return \SplFixedArray
     */
    public static function getBlockStatesArray() : \SplFixedArray{
        return self::$fullList;
    }

    /**
     * Returns whether a specified block ID is already registered in the block factory.
     *
     * @param int $id
     * @return bool
     */
    public static function isRegistered(int $id) : bool{
        $b = self::$list[$id];
        return $b !== null and !($b instanceof UnknownBlock);
    }
}
