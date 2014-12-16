<?php
/***************************************************************************
	@extension	: Bestseller Product.
	@copyright	: Copyright (c) 2014 Capacity Web Solutions.
	( http://www.capacitywebsolutions.com )
	@author		: Capacity Web Solutions Pvt. Ltd.
	@support	: magento@capacitywebsolutions.com	
***************************************************************************/
?>
<?php

class CapacityWebSolutions_Bestseller_Block_Bestseller extends Mage_Catalog_Block_Product_Abstract // Mage_Core_Block_Template
{
 public function __construct()
  {
  		$this->setHeader(Mage::getStoreConfig("bestseller/general/heading"));
		$this->setLimit((int)Mage::getStoreConfig("bestseller/general/number_of_items"));
		$this->setItemsPerRow((int)Mage::getStoreConfig("bestseller/general/number_of_items_per_row"));
		$this->setStoreId(Mage::app()->getStore()->getId());
		$this->setImageHeight((int)Mage::getStoreConfig("bestseller/general/thumbnail_height"));
		$this->setImageWidth((int)Mage::getStoreConfig("bestseller/general/thumbnail_width"));
		$this->setTimePeriod((int)Mage::getStoreConfig("bestseller/general/time_period"));
		$this->setAddToCart((bool)Mage::getStoreConfig('bestseller/general/add_to_cart'));
		$this->setActive((bool)Mage::getStoreConfigFlag("bestseller/general/active"));
		$this->setAddToCompare((bool)Mage::getStoreConfig("bestseller/general/add_to_compare"));
  }
  function getBestsellerProduct()
  { 
     	 $timePeriod = ($this->getTimePeriod()) ? $this->getTimePeriod() : 60;
		 $date = date('Y-m-d H:i:s');
		 $newdate = strtotime ( '-'.$timePeriod.' day' , strtotime ( $date ) ) ;
		 $newdate = date ( 'Y-m-j' , $newdate ); 
         $write = Mage::getSingleton('core/resource')->getConnection('core_write');
		 $read = Mage::getSingleton('core/resource')->getConnection('core_read');
		 $table_prefixx = Mage::getConfig()->getTablePrefix(); 
	   	 $res = $write->query("select max(qo) as des_qty,`product_id`,`parent_item_id`,`order_id` FROM (select sum(p.qty_ordered) AS qo,p.product_id,p.created_at,p.store_id,p.parent_item_id, s.status, p.order_id  from sales_flat_order as s, sales_flat_order_item as p where s.entity_id = p.order_id AND s.status = 'complete'  AND p.store_id = ".$this->getStoreId()." Group By p.product_id) AS t1 where store_id = ".$this->getStoreId()." AND parent_item_id is null  AND created_at between'".$newdate."' AND '".$date."' Group By `product_id` order By des_qty desc");
        
		
		 while ($row = $res->fetch()) 
    	  { 
			$maxQty[]=$row['product_id'];
			
	   	  }
		
		 return $maxQty;
  }
}
?>