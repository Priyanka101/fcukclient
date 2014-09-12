<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table shiptrack(s_id int not null auto_increment, awbnumber varchar(100), 
carrier varchar(100), 
status varchar(100), 
cod int(11),
ncod int(11),
primary key(s_id));

insert into shiptrack values(1,1234567890,'bluedart',0,0,1);
insert into shiptrack values(2,1575268444,'aramex',1,1,0);
		
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 