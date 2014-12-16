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

class CapacityWebSolutions_Bestseller_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
     $this->loadLayout(array('default'));
     $this->renderLayout();
    }
}


?>