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


        //SourceID = propertyid
		//get property photo or Thumbnail using sourceID	
	  	$search = $rets->SearchQuery("Media","Media","(SourceID=1313)",array("Format" => "COMPACT"));
	    echo '<pre>'; 
	    while ($photos = $rets->FetchRow($search)){
			echo '<pre>'; 
		    print_r($photos);
		    $i++;
		}
		


		/*
		for get Thumbnail URLs
		$search = $rets->SearchQuery("Media","Media","(SourceID=1313),(MediaCategory=1)",array("Format" => "COMPACT"));

		for get properties image URLs
		$search = $rets->SearchQuery("Media","Media","(SourceID=1313),(MediaCategory=1)",array("Format" => "COMPACT"));


		Full-size photo URLs are returned using MediaCategory=|2. (Thumbnail URLs are returned using
		MediaCategory=|1. (vertical bar (|) designates a Lookup value instead of a literal value.)
		Tip: When testing your DMQL2 queries, your RETS client may generate code that is encoded. Use an online tool to

		
		
		A = If you wish to download Thumbnails (80x60), Standard photos (320x240), or Higher-Resolution
		photos (640x480), include in your Media Resource Request Type=Thumbnail, Type=Photo, or
		Type=HRPhoto.
		    */
    	


die();



     
	

	 

	}


?>