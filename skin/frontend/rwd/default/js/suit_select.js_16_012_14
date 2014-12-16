jQuery(document).ready(function(){
$path=jQuery("#path").val();
//alert($path);
 jQuery('#save_data').click(function(){
       
                var sleeveLength =jQuery('#sleeveLength').val();
                var acrossshoulder =jQuery('#acrossshoulder').val();
				var bust = jQuery('#bust').val();
				var waist = jQuery('#waist').val();
				var hip = jQuery('#hip').val();
				var length = jQuery('#length').val();
				var toFitWaist = jQuery('#toFitWaist').val()
				var toFitHip = jQuery('#toFitHip').val(); 
				var outSeamLength = jQuery('#outSeamLength').val();
				var inSeamLength = jQuery('#inSeamLength').val();
                var productSku = jQuery('#productsku').val();
                var customsize=jQuery('#customsize').val();
            
    
   if(jQuery("#measurementForm").valid())
   {
                 
			jQuery.post($path+'measurement',{
		
					sleeveLength:sleeveLength,
					acrossshoulder:acrossshoulder,
					bust: bust,
					waist: waist,
					hip: hip,
					length: length,
					toFitWaist: toFitWaist,
					toFitHip: toFitHip,
					outSeamLength: outSeamLength,
					inSeamLength: inSeamLength,
					productSku: productSku,
					customsize:customsize
            },
			  
				function(data){
				
						jQuery("#custom_size_modal").hide();	
						jQuery("#msg").html("Custom size added successfully");
						jQuery("#customSizeSts").val("1");
						
						
						eval("returne="+data);
						jQuery("#cust_size").show();  		
						jQuery("#cust_size").html(returne.resultg);
				
				});
				
				
   }



	});
        
        
        //save data from the cart
        
         jQuery('.save_data').click(function(){
             $sku_id=jQuery(this).attr("id");
             
       
                var sleeveLength =jQuery('#'+$sku_id+'_sleeveLength').val();
                var acrossshoulder =jQuery('#'+$sku_id+'_acrossshoulder').val();
				var bust = jQuery('#'+$sku_id+'_bust').val();
				var waist = jQuery('#'+$sku_id+'_waist').val();
				var hip = jQuery('#'+$sku_id+'_hip').val();
				var length = jQuery('#'+$sku_id+'_length').val();
				var toFitWaist = jQuery('#'+$sku_id+'_toFitWaist').val()
				var toFitHip = jQuery('#'+$sku_id+'_toFitHip').val(); 
				var outSeamLength = jQuery('#'+$sku_id+'_outSeamLength').val();
				var inSeamLength = jQuery('#'+$sku_id+'_inSeamLength').val();
                var productSku = jQuery('#'+$sku_id+'_productsku').val();
                var customsize=jQuery('#'+$sku_id+'_customsize').val();
          // alert(sleeveLength);
    
   if(jQuery("#measurementForm_"+$sku_id).valid())
   {
                 
         jQuery.post($path+'measurement',{
		
				sleeveLength:sleeveLength,
				acrossshoulder:acrossshoulder,
                bust: bust,
                waist: waist,
				hip: hip,
				length: length,
				toFitWaist: toFitWaist,
				toFitHip: toFitHip,
				outSeamLength: outSeamLength,
				inSeamLength: inSeamLength,
                productSku: productSku,
                customsize:customsize
              },function(data){
			
		jQuery(".custom_size_modal_"+$sku_id).hide();	
                  
                        
              var tool_html="<a class='tooltip_cart'  title='<div id=drees_measures><h2>Dress Measures</h2> <ul><li><span>Sleeve Length - "+sleeveLength+" cm</span><span>Across Shoulder - "+acrossshoulder+" cm</span></li><li><span>Waist - "+waist+"  cm</span><span>Hip - "+hip+" cm</span></li><li><span>Length - "+length+" cm</span><span>To Fit Waist - "+toFitWaist+" cm</span></li><li><span>To Fit Hip - "+toFitHip+" cm</span><span>Out Seam Length -  "+outSeamLength+" cm</span></li><li><span>In Seam Length - "+inSeamLength+"cm</span><span>Bust - "+bust+" cm</span></li></ul>' href='#'>View Meaurement</a></div>";        
            
			jQuery("#"+$sku_id).html(tool_html);
			jQuery('.tooltip_cart').poshytip();	
		
		});
   }



	});
	
	jQuery('.pop_btn').click(function() {
        $sku_id=jQuery(this).attr("id");
        //alert($sku_id);
              
              jQuery(".custom_size_modal_"+$sku_id).show();  
    })
    
	jQuery(".cls").click(function(){
       
           jQuery(".custom_size_modal_"+$sku_id).hide();
    })	
	
});