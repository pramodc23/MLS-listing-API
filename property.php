<?php
$con = mysqli_connect("localhost","vmwebhun_firegun","1K[*zTdbqxa0","vmwebhun_firearms");
	// include_once("../olr_code/dbconfig.php");
    //https://stackoverflow.com/questions/17938394/cant-get-results-from-searchquery-in-phrets
    //https://github.com/troydavisson/PHRETS/wiki/GetMetadataResources
	ini_set('memory_limit', '-1');
	$rets_login_url = "http://calrets.mlslistings.com:6103/Login.ashx";
	$rets_username = "brkrkhes";
    $rets_password = "i7m5oc19";
	
	require_once("phrets.php");
	/* Initialize Object */
	$rets = new PHRETS;
	/* Connect */
	$connect = $rets->Connect($rets_login_url, $rets_username, $rets_password);
	$limit = 50;
	/* Query Server */
	if($connect) 
	{
        echo "connected";
        echo "<br>";
        //get all Resources, Classes or Fields
        /*$resources = $rets->GetMetadataResources();
		foreach ($resources as $resource) {
	        echo "+ Resource {$resource['ResourceID']}\n";
	        echo "<br>";
	        if ($resource['ResourceID']=='Property') {
	        	$classes = $rets->GetMetadataClasses($resource['ResourceID']);
		        foreach ($classes as $class) {
		                echo "   + Class {$class['ClassName']} described as " . $class['Description'] . "\n";
		                echo "<br>";
		            if ($class['ClassName']=='Agent') {  
				        $rets_metadata = $rets->GetMetadata($resource['ResourceID'],$class['ClassName']);
				        foreach ($rets_metadata as $field) {
				            echo "    + Field: {$field['SystemName']} ({$field['DataType']})\n";
				             echo "<br>";
				        }
		            }
		        }

	        }		        
		}
		die();
		*/  

        /*$resources = $rets->GetMetadataResources();
		foreach ($resources as $resource) {
		        echo "+ Resource {$resource['ResourceID']} described as " . $resource['Description'] . "<br>";
		}
		die;*/

		// Property & Media
         /*
		$classes = $rets->GetMetadataClasses("Media");
		foreach ($classes as $class) {
		    echo "+ Class {$class['ClassName']} described as " . $class['Description'] . "<br>";
	    }
 	    echo '<pre>';
 	    die;
	   */

		//list of all properties
		$search = $rets->SearchQuery("Property","RES","(OriginalListPrice=1+)",array( "Count" => 1, "Format" => "COMPACT", "Limit" => '100',"Offset" => 1));
		//echo "<pre>";
		$i=1;
		while ($listing = $rets->FetchRow($search)){
			echo '<pre>'; 
		    print_r($listing);
		    $i++;
		}
		die();
		/**/		

		//get details by property id
		/*$search = $rets->SearchQuery("Property","RES","(ListingID=ML80917941)",array( "Count" => 1, "Format" => "COMPACT", "Limit" => '1',"Offset" => 0+1));
		//echo "<pre>";
		$i=1;
		while ($listing = $rets->FetchRow($search)){
			echo '<pre>'; 
			print_r($listing);
			$i++;
		}
		die();
		*/		
    	
// get property list	

	
    //search property useing ListingAgentID   -> (ListingAgentID=1750)
	//$search = $rets->SearchQuery('Property', 'Photo', '00-1669', '*', 1);

	//search using property price        
    //$search = $rets->SearchQuery("Property","RES","(OriginalListPrice=400000+)"); 

    //search property using pagination
	//$search = $rets->SearchQuery("Property","RES","(OriginalListPrice=400000+)",array( "Count" => 1, "Format" => "COMPACT", "Limit" => $limit,"Offset" => $total_data_inserted+1));   


	//cron for insert or update properties into database	
	// function insert_property($number,$con,$rets,$limit) { 		

	// 	$offsetqry = mysqli_query($con,  "SELECT offset FROM property_offset WHERE id='1'");
	// 	$offsetrow = mysqli_fetch_assoc($offsetqry);
	// 	$offset= $offsetrow['offset'];

	// 	$getpropertysql = $rets->SearchQuery("Property","RES","(OriginalListPrice=1+)",array( "Count" => 1, "Format" => "COMPACT", "Limit" => $limit,"Offset" => $offset+1));

	// 	$i=0;
	// 	while ($propertylisting = $rets->FetchRow($getpropertysql)){	
	// 		$listingId=$propertylisting['ListingID'];
	// 		$sellingOfficeBrokerLicenseID=$propertylisting['SellingOfficeBrokerLicenseID'];
	// 		$sellingAgentFirstName=mysqli_real_escape_string($con,$propertylisting['SellingAgentFirstName']);
	// 		$sellingAgentLastName=mysqli_real_escape_string($con,$propertylisting['SellingAgentLastName']);
	// 		$bedrooms=$propertylisting['Bedrooms'];
	// 		$listPrice=$propertylisting['ListPrice'];


	// 		// check property already exist or not
	// 		$checksql = mysqli_query($con,"SELECT count(listingId) as total_listingId FROM property WHERE listingId='$listingId'");
 //    		$row=mysqli_fetch_assoc($checksql);	

	// 		if ($row['total_listingId'] > 0) {
	// 			$updated_on=date('Y-m-d H:i:s');
	// 			$updatesql = "UPDATE property SET listingId='$listingId',sellingAgentFirstName='$sellingAgentFirstName',sellingAgentLastName='$sellingAgentLastName',bedrooms='$bedrooms',listPrice='$listPrice',sellingOfficeBrokerLicenseID='$sellingOfficeBrokerLicenseID',updated_on='$updated_on' WHERE listingId='$listingId'";  
	// 			if (mysqli_query($con, $updatesql)) {
	// 			    echo "Updated for listingID => ".$listingId;
	// 			} else {
	// 			    echo "Error: " . $sql . "<br>" . mysqli_error($con);
	// 			}
	// 		}else{
	// 			$sql = "INSERT INTO property (listingId, sellingAgentFirstName, sellingAgentLastName, bedrooms, listPrice, sellingOfficeBrokerLicenseID)VALUES ('$listingId','$sellingAgentFirstName', '$sellingAgentLastName', '$bedrooms', '$listPrice', '$sellingOfficeBrokerLicenseID')";
	// 			if (mysqli_query($con, $sql)) {
	// 			    echo "New record created successfully ".$listingId;
	// 			} else {
	// 			    echo "Error: " . $sql . "<br>" . mysqli_error($con);
	// 			}	
	// 		}
	// 		echo "<br>";
	// 		$i++;
	// 	}		

	// 	$updatedon=date('Y-m-d H:i:s');
	//     if($i <= $limit){  
	//     	$updated_offset=$offset+$limit;

	//     	echo $updated_offset."<== offset update or limits ==>".$limit."---- product return ==>".$i;
	//     		echo "<br>";
	//     	$updatesql = "UPDATE property_offset SET offset='$updated_offset',updatedon='$updatedon' WHERE id='1'";	
	// 		mysqli_query($con, $updatesql);
	// 		if ($offset > 50000) {
	// 			echo "API have morethan 50000 properties <br>";
	//     	 	return false;
	// 		}	    	     
	//      	$number++;
	//      	insert_property($number,$con,$rets,$limit);    
	//     }  else{
	//     	$updatesql = "UPDATE property_offset SET offset='0',updatedon='$updatedon' WHERE id='1'";	
	// 		mysqli_query($con, $updatesql);
	//     	echo "All property updated <br>";
	//     	return false;
	//     }
	// }    
	    
	// insert_property(1,$con,$rets,20);    



die();



     
	

	 

	}


?>