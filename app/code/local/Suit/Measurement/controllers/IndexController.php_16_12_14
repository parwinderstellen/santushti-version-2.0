<?php
class Suit_Measurement_IndexController extends Mage_Core_Controller_Front_Action {

        public function indexAction() { 



                if ($this->getRequest()->isPost()){
                        $measure_raw_data = $this->getRequest()->getPost();

                         $size_option=$this->getRequest()->getPost('customsize');

								$mname=$this->getRequest()->getPost('productSku');
								$mname=str_replace("_"," ",$mname);

                        //  if($size_option=="customsize")
							if($_POST['customsize']=="customsize")
								{
										$measure_data=array();
										$update_fields="";
									foreach($measure_raw_data as $measure_raw_data_key=>$measure_raw_data_val){
													 $measure_data[$measure_raw_data_key]=trim($measure_raw_data_val);


													$update_fields.=$measure_raw_data_key." = '".trim($measure_raw_data_val)."' , ";

													$_SESSION['product_sku']['Custom Size'][$mname][$measure_raw_data_key]=trim($measure_raw_data_val);
													$_SESSION['product_sku'][$size_option][$mname]['productSku']=$mname; 
													$_SESSION['product_sku'][$_POST[sizeOption]][$mname]['sizeoption']=$_POST[sizeOption];
									}
									
									 //$return = array('result'=> unserialize($_SESSION['product_sku']));
								}
								else{
									  $_SESSION['product_sku'][$_POST[sizeOption]][$mname]['product_status']=" ";
									  $_SESSION['product_sku'][$_POST[sizeOption]][$mname]['productSku']=$_POST[productSku];
									  $_SESSION['product_sku'][$_POST[sizeOption]][$mname]['sizeoption']=$_POST[sizeOption];
									}
									//echo $_SESSION['product_sku']['Custom Size']; 
									
									
									
	$sleeveLength=$_SESSION['product_sku']['Custom Size'][$_POST[productSku]]['sleeveLength'] ;
        $acrossshoulder=$_SESSION['product_sku']['Custom Size'][$_POST[productSku]]['acrossshoulder'];
        $bust=$_SESSION['product_sku']['Custom Size'][$_POST[productSku]]['bust'];
        $waist=$_SESSION['product_sku']['Custom Size'][$_POST[productSku]]['waist'];
	$hip=$_SESSION['product_sku']['Custom Size'][$_POST[productSku]]['hip'];
        $length=$_SESSION['product_sku']['Custom Size'][$_POST[productSku]]['length'];
        $toFitWaist=$_SESSION['product_sku']['Custom Size'][$_POST[productSku]]['toFitWaist'];
        $toFitHip=$_SESSION['product_sku']['Custom Size'][$_POST[productSku]]['toFitHip'];
        $outSeamLength=$_SESSION['product_sku']['Custom Size'][$_POST[productSku]]['outSeamLength'];
        $inSeamLength=$_SESSION['product_sku']['Custom Size'][$_POST[productSku]]['inSeamLength'];
 					
		$ret .='<table border=0px>
			<tr>
				<th colspan="5" style="text-align:center; background-color:#87C540;"> Your Custom Size </th>
			</tr>
			<tr class="even_1">
				<th >Sleeve Length</th>
				<td class="val_even">'. $sleeveLength .'</td>
				<td></td>
                                <th >Across Shoulder</th>
				<td class="val_even">'. $acrossshoulder .'</td>
				
			</tr>
			<tr class="odd_1">
				<th>Waist</th>
				<td class="val_odd">'. $waist .'</td>
				<td></td>
				<th class="th_heading">Hip</th>
				<td class="val_odd">'. $hip .'</td>
			</tr>
			<tr class="even_1">
				<th>Length</th>
				<td class="val_even">'. $length .'</td>
				<td></td>
				<th class="th_heading">To Fit Waist</th>
				<td class="val_even">'. $toFitWaist .'</td>
			</tr>
			<tr class="odd_1">
				<th>To Fit Hip</th>
				<td class="val_odd">'. $toFitHip .'</td>
				<td></td>
				<th>Outseam Length</th>
				<td class="val_odd">'. $outSeamLength .'</td>
			</tr>
			<tr class="even_1">
				<th class="th_heading">Inseam Length</th>
				<td class="val_even">'. $inSeamLength .'</td>
				<td></td>
                                <th class="th_heading">Bust</th>
				<td class="val_even">'. $bust .'</td>
			</tr>
		</table>';

		//$return = $ret;	
		$return = array('resultg'=> $ret);
					  if(Mage::getSingleton('customer/session')->isLoggedIn()) 
						{
							$productSku= str_replace("_"," ",$_POST[productSku]);
							 $customerData = Mage::getSingleton('customer/session')->getCustomer();
										  $customer_id= $customerData->getId();    
										  $product_id = Mage::getModel("catalog/product")->getIdBySku($productSku);
							
										   $conn = Mage::getSingleton('core/resource')->getConnection('core_read');
									   $sql1        = "select count(*) as cnt from wishlist_custom_size where customer_id=$customer_id and product_id=".$product_id;
										  
									   $dta      = $conn->fetchAll($sql1);
									   
							if($dta[0][cnt]>0){         
									$custom_option=  serialize($_SESSION['product_sku']['Custom Size']);
									$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
									$sql        = "update wishlist_custom_size set custom_option='".$custom_option."' where customer_id=$customer_id and product_id=$product_id";
									
									$rows       = $connection->query($sql);
							}            
						}
	
                        //Mage::getSingleton('core/session')->addSuccess('Your custom measurement saved successfully.');
				} 
	 
		echo json_encode($return);
		
                die;
        }



}