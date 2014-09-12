<?php
$installer = $this;
$installer->startSetup();

$installer->addAttribute("order_item", "custom_special_price", array("type"=>"varchar"));
$installer->addAttribute("order_item", "custom_original_price", array("type"=>"varchar"));
$installer->addAttribute("order_item", "custom_price", array("type"=>"varchar"));
$installer->endSetup();
	 