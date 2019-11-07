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

        /*
        //For get all resources, classes and fields
        $resources = $rets->GetMetadataResources();
		foreach ($resources as $resource) {
	        echo "+ Resource {$resource['ResourceID']}\n";
	        echo "<br>";
	        if ($resource['ResourceID']=='Agent') {
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


		// get Agent list	
	 	$agesearch = $rets->SearchQuery("Agent","Agent","(BirthDate=1975-01-01+)",array( "Count" => 1, "Format" => "COMPACT", "Limit" => $limit,"Offset" => $total_data_inserted+1));   
		//echo "<pre>";
		$i=1;
		while ($agelisting = $rets->FetchRow($agesearch)){
			echo '<pre>'; 
		    print_r($agelisting);
		    $i++;
		}
		die();





    // search agent using agent id    
    //$agesearch = $rets->SearchQuery("Agent","Agent","(AgentID=1750)"); 
    //search agent using pagination
    //$agesearch = $rets->SearchQuery("Agent","Agent","(BirthDate=1975-01-01+)",array( "Count" => 1, "Format" => "COMPACT", "Limit" => $limit,"Offset" => $total_data_inserted+1));   


	// cron for insert or update agent details	
	$agesearch = $rets->SearchQuery("Agent","Agent","(BirthDate=1920-01-01+)",array());
	echo "<pre>";
	$i=1;
	while ($agelisting = $rets->FetchRow($agesearch)){
		//echo $i;

		$agentid=mysqli_real_escape_string($con,$agelisting['AgentID']);

		// check agent already exist or not
		$checksql = mysqli_query($con,"SELECT count(agentid) as total_agentid FROM agent WHERE agentid='$agentid'");
    	$row=mysqli_fetch_assoc($checksql);	

		$firstname=mysqli_real_escape_string($con,$agelisting['FirstName']);
		$middlename=mysqli_real_escape_string($con,$agelisting['MiddleName']);
		$lastname=mysqli_real_escape_string($con,$agelisting['LastName']);
		$fullname=mysqli_real_escape_string($con,$agelisting['FullName']);
		$emailaddress=mysqli_real_escape_string($con,$agelisting['EmailAddress']);
		$status=mysqli_real_escape_string($con,$agelisting['Status']);
		$homephone=mysqli_real_escape_string($con,$agelisting['HomePhone']);
		$addresspostalcode=mysqli_real_escape_string($con,$agelisting['AddressPostalCode']);
		$agentrole=mysqli_real_escape_string($con,$agelisting['AgentRole']);
		$birthdate=mysqli_real_escape_string($con,$agelisting['BirthDate']);
		$title=mysqli_real_escape_string($con,$agelisting['Title']);
		$countryname=mysqli_real_escape_string($con,$agelisting['CountryName']);	
		$officename=mysqli_real_escape_string($con,$agelisting['OfficeName']);
		$boardid=mysqli_real_escape_string($con,$agelisting['BoardID']);
		$licensenumber=mysqli_real_escape_string($con,$agelisting['LicenseNumber']);
		$mobilephone=mysqli_real_escape_string($con,$agelisting['MobilePhone']);
		$agenttype=mysqli_real_escape_string($con,$agelisting['AgentType']);
		$personalfax=mysqli_real_escape_string($con,$agelisting['PersonalFax']);
		
		echo "<br>";
		if ($row['total_agentid'] > 0) {
			$updatedon=date('Y-m-d H:i:s');
			$updatesql = "UPDATE agent SET agentid='$agentid',firstname='$firstname',middlename='$middlename',lastname='$lastname',fullname='$fullname',emailaddress='$emailaddress',status='$status',homephone='$homephone',addresspostalcode='$addresspostalcode',agentrole='$agentrole',birthdate='$birthdate',title='$title',countryname='$countryname',officename='$officename',boardid='$boardid',licensenumber='$licensenumber',mobilephone='$mobilephone',agenttype='$agenttype',agenttype='$agenttype',personalfax='$personalfax',updated_on='$updatedon' WHERE agentid='$agentid'";  
			if (mysqli_query($con, $updatesql)) {
			    echo "Updated for AgentID => ".$agentid;
			} else {
			    echo "Error: " . $sql . "<br>" . mysqli_error($con);
			}
		}else{
			$createon=date('Y-m-d H:i:s');
			$sql = "INSERT INTO agent (agentid,firstname,middlename,lastname,fullname,emailaddress,status, homephone,addresspostalcode,agentrole,birthdate,title,countryname,officename,boardid,licensenumber,mobilephone,agenttype,personalfax,created_on)VALUES ('$agentid','$firstname','$middlename','$lastname','$fullname','$emailaddress','$status','$homephone', '$addresspostalcode','$agentrole','$birthdate','$title','$countryname','$officename','$boardid','$licensenumber','$mobilephone','$agenttype','$personalfax','$createon')";
			if (mysqli_query($con, $sql)) {
			    echo "Insert ".$agentid;
			} else {
			    echo "Error: " . $sql . "<br>" . mysqli_error($con);
			}
		}		
	 	echo "<br>";
	 	if ($i > 100) {
	 		echo "API BREAK";
			break;
	 	}
		$i++; 
	}
	die();

	}


?>