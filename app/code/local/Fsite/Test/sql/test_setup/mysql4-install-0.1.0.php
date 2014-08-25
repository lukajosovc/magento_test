<?php
 	$installer = $this;
	$installer->startSetup();
	$installer->run("
			
	DROP TABLE IF EXISTS {$this->getTable('test/test')};			
    CREATE TABLE `{$installer->getTable('test/test')}` (
      `id` int(11) unsigned NOT NULL auto_increment,
      `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
      `updated_at` timestamp NULL,
      `birth_date` date NULL,
      `first_name` varchar (64) NULL,
      `last_name` varchar (64) NULL,
	  PRIMARY KEY  (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->endSetup();