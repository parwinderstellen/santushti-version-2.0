<?php
 /*
* @copyright   Copyright ( c ) 2013 www.magebuzz.com
*/
$installer = $this;
$installer->startSetup();
$installer->run("

DROP TABLE IF EXISTS {$this->getTable('bannerpopup')};
CREATE TABLE {$this->getTable('bannerpopup')} (
  `bannerpopup_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `link` text NULL,
  `viewcounts` int(11) NOT NULL default '0',
  `showcounts` int(11) NOT NULL default '0',
  `filename` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`bannerpopup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
$installer->endSetup(); 
