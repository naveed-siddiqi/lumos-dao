<?php
    /* THIS FILE DEALS WITH ASSET FUNCTIONS */
    require("../library/Toml.php");
    require("../library/oauth/src/SecretFactory.php");
    require("../library/oauth/src/GoogleAuthenticator.php");
    require("./config.php");
    require("./prices.php");
    
    
    //uploading of asset image
    if ($_SERVER["REQUEST_METHOD"] === "POST" && $_GET['type'] == "upload") {  
        if (isset($_FILES["file"])) {
            $file = $_FILES["file"];
            $coverFlg = false;
            if (isset($_FILES["cover"])) { 
                 $cover = $_FILES["cover"];$coverFlg = true;
                 $imageCoverType = exif_imagetype($cover["tmp_name"]);
            }
            $uploadDirectory = 'images/'; // Define your upload directory
    
            // Check if the file is an image
            $imageType = exif_imagetype($file["tmp_name"]); 
            $allowedTypes = [
                IMAGETYPE_JPEG,
                IMAGETYPE_PNG,
                IMAGETYPE_GIF,
                IMAGETYPE_BMP
            ];
    
            if (!in_array($imageType, $allowedTypes)) {
                echo "0";
            } else {  
                if (move_uploaded_file($file["tmp_name"], $uploadDirectory . $_GET["name"])) {
                    //try and move cover img if present
                    if($coverFlg){
                        if (in_array($imageCoverType, $allowedTypes)) {
                            move_uploaded_file($cover["tmp_name"], $uploadDirectory . "cover_" . $_GET["name"]);
                        }
                    }
                    echo "1";
                } else {
                    echo "2";
                }
            }
        } else {
            echo "3";
        }
    }  
    
    //uploading of user image
    if ($_SERVER["REQUEST_METHOD"] === "POST" && $_GET['type'] == "upload_user_img") {  
        if (isset($_FILES["file"])) {
            $file = $_FILES["file"];
            $uploadDirectory = 'users/'; // Define your upload directory
    
            // Check if the file is an image
            $imageType = exif_imagetype($file["tmp_name"]); 
            $allowedTypes = [
                IMAGETYPE_JPEG,
                IMAGETYPE_PNG,
                IMAGETYPE_GIF,
                IMAGETYPE_BMP
            ];
    
            if (!in_array($imageType, $allowedTypes)) {
                echo "0";
            } else {  
                if (move_uploaded_file($file["tmp_name"], $uploadDirectory . $_GET["name"])) {
                    //update the user info
                    require('./db.php');
                    $imgpath = "https://" . $_SERVER['HTTP_HOST'] . "/.well-known/" . $uploadDirectory . $_GET["name"];
                    $user = $_GET["user"];
                    $query = "UPDATE users SET image='$imgpath' WHERE wallet = '$user'";
                	$result = mysqli_query($conn, $query);
                	if($result) {
                	   echo "1";
                	}else {echo "0";}
                } else {
                    echo "2";
                }
            }
        } else {
            echo "3";
        }
    }  
    
    //create subdomain and upload toml
    if ($_GET['type'] == "toml") { 
        //create subdomain 
        //first check if the subdomain has been created
        $domain = strtolower($_GET['value']);
        $dao = $_GET['dao'];
        $filename="./$domain/.well-known"; 
        if(!is_dir($filename)) {
            //check if the domain already exists
            mkdir($filename, 0755, true); //create the .well-known
            //create index.php to redirect to main page
            $redir = "<?php header('Location:https://$HOST_DOMAIN/dao/$dao'); ?>";
            file_put_contents("./$domain/index.php", $redir, FILE_APPEND);
            //get the ht_access file
            $access = file_get_contents("./access_file");
            file_put_contents("./$domain/.htaccess", $access, FILE_APPEND);
            $currentData = file_get_contents($filename . "/stellar.toml");
            $img = $_GET['image'];
            // Check if the dataToAppend is already in the file
            if (strpos($currentData, $_GET['asset']) === false) {
                // If dataToAppend is not found in the file, append it
                file_put_contents($filename . "/stellar.toml", $_GET['asset'], FILE_APPEND);
            }  
                echo 1;
        }
        else {
            //domain already exists
            echo 0;
        }
    } 
    
    //check if subdomain exists
    if ($_GET['type'] == "subdomain") {
        //create subdomain 
        //first check if the subdomain has been created
        $domain = strtolower($_GET['value']);
        $filename="./$domain/.well-known";
        if(is_dir($filename)) { //exists
             echo 1;
        }
        else {
            //domain alread exists
            echo 0;
        }
    } 
    
    //check if proposal exists
    if ($_GET['type'] == "proposal") {
        //create subdomain 
        //first check if the subdomain has been created
        $prop = $_GET['value'];
        $dao = strtolower($_GET['dao']);
        $filename="./$dao/proposal/$prop";
        if(is_dir($filename)) { //exists
             echo 1;
        }
        else {
            //domain alread exists
            echo 0;
        }
    } 
    
    //read toml
    if ($_GET['type'] == "loadtoml") {
        //create subdomain 
        $domain = strtolower($_GET['value']);
        $filename="./$domain/.well-known/stellar.toml";
        if(file_exists($filename)) { //exists
             echo file_get_contents($filename);
        }
        else {
            //domain alread exists
            echo 0;
        }
    } 
    
    //updating the description toml values
    if ($_GET['type'] == "modifyabout") { //updating the desc field
        $domain = strtolower($_GET['domain']);
        $filename="./$domain/.well-known/stellar.toml";
        if(file_exists($filename)) {
            // Read the contents of the file
            $currentData = file_get_contents($filename);
            
            // Define the new "desc" value
            $newDesc = $_GET['value']; $code = $_GET['name'];
            $newValue = ""; $key = "CURRENCIES";  
            $toml = new Toml(); $aToml = $toml::parse($currentData);
            $issuer = "";
            //loop through the currency array
            if(isset($aToml->$key)) {
                //get the array
                $toml = $aToml->$key;$key = 'code';$i = 0;
                foreach($toml as $val) {
                   if(isset($val[$key])) { 
                       if(trim($val[$key]) == $code) {  
                           //change the desc
                           $k = 'CURRENCIES';
                           ($aToml->$k)[$i]['desc'] = $newDesc;
                           $issuer = ($aToml->$k)[$i]['issuer'];
                       }
                   }
                   $i++;
                }
                /* Parsing back the values */
                //parse the accounts
                $key="ACCOUNTS";$flg = false;
                if(isset($aToml->$key)) {
                    $newValue = 'ACCOUNTS=['; $toml = $aToml->$key; 
                    for($i=0;$i<sizeof($toml); $i++) {$val = $toml[$i];
                        $newValue .= '"' . $val . '"';if($i<sizeof($toml) - 1){$newValue .= ",";}
                    }
                    $newValue .= "]"; $flg = true;
                }
                $key="DOCUMENTATION";
                if(isset($aToml->$key)) {
                    if($flg) {$newValue .= "\n\n";}
                    $newValue .= "[DOCUMENTATION]\n";$toml = $aToml->$key;  
                    foreach($toml as $key => $val) {
                        $newValue .= $key.'="'.$val."\"\n";
                    }
                }
                $key="CURRENCIES";
                if(isset($aToml->$key)) {
                    if($flg) {$newValue .= "\n";}
                    $toml = $aToml->$key;  
                    foreach($toml as $cur) {
                        $newValue .= "\n[[CURRENCIES]]\n";
                        foreach($cur as $key => $val) {
                            if($key == 'display_decimals') { $newValue .= $key.'='.$val."\n";}
                            else {$newValue .= $key.'="'.$val."\"\n";}
                        }
                    }
                }
                $newValue .= "\n\n\n";
                //save back the results
                file_put_contents($filename, $newValue);
                
            }
        }
        //update the db
        require('./db.php');
        //save back to db
        $query = "UPDATE daos SET description='$newDesc' WHERE code='$code' AND issuer = '$issuer'";
        $resp = mysqli_query($conn, $query);
        if($resp){echo 1;}else{echo 0;}
         
    } 
    
    //updating the adress toml values
    if ($_GET['type'] == "modifyaddress") { //updating the accounts field
        $domain = strtolower($_GET['domain']);
        $filename="./$domain/.well-known/stellar.toml";
        // Read the contents of the file
        $currentData = file_get_contents($filename);
        
        // Define the new "desc" value
        $newDesc = $_GET['value']; 
        $addr = $_GET['value'];
        //split into address and names
        $addr = explode("|@$$@|", $addr);
        if(sizeof($addr) > 0){$addr_name = $addr[1]; $addr = $addr[0];}
        else {$addr = $addr_name = "";}
        $newValue = ""; $key = "CURRENCIES";  
        $toml = new Toml(); $aToml = $toml::parse($currentData);
        $addr_name = strtolower($addr_name);
        
        //loop through  
        if(isset($aToml->$key) && $addr_name != 'issuing address' && $addr_name != 'distributing address') {
            //get the array
            
            /* Parsing back the values */
            //parse the accounts
            $key="ACCOUNTS";$flg = false;
            if(isset($aToml->$key)) { 
                $newValue = 'ACCOUNTS=['; $toml = $aToml->$key; 
                for($i=0;$i<sizeof($toml); $i++) {$val = $toml[$i];
                    if($val == $addr){
                        $flg = true;
                        //check if its removal
                        if($addr_name == 'empty') {
                            continue;
                        }
                    }
                    $newValue .= '"' . $val . '"';if($i<sizeof($toml) - 1){$newValue .= ",";}
                    
                }
                if(!$flg) {
                    //no present add it
                    if(sizeof($toml) > 0) {$newValue .= ",";}
                    $newValue .= '"' . $addr . '"';
                }
                $newValue .= "]"; $flg = true;
            }
            $key="DOCUMENTATION";
            if(isset($aToml->$key)) {
                if($flg) {$newValue .= "\n\n";}
                $newValue .= "[DOCUMENTATION]\n";$toml = $aToml->$key;  
                foreach($toml as $key => $val) {
                    $newValue .= $key.'="'.$val."\"\n";
                }
            } 
            
             //addin address names
            $key="WALLET_NAMES";
            if($flg) {$newValue .= "\n\n";} $flg = false;
            $newValue .= "[WALLET_NAMES]\n";$toml = $aToml->$key;  
            if(isset($aToml->$key)) {
                foreach($toml as $key => $val) {
                    if($key == $addr){
                        $flg = true;
                        if($addr_name == 'empty') {
                            continue;
                        }
                        else {
                            $val = $addr_name;
                        }
                    } //modifying name
                    $newValue .= $key.'="'.$val."\"\n";
                }
            }
            //add current one if not present
            if(!$flg){$newValue .= $addr.'="'.$addr_name ."\"\n";}
            $flg = true;
            $key="CURRENCIES";
            if(isset($aToml->$key)) {
                if($flg) {$newValue .= "\n";}
                $toml = $aToml->$key;  
                foreach($toml as $cur) {
                    $newValue .= "\n[[CURRENCIES]]\n";
                    foreach($cur as $key => $val) {
                        if($key == 'display_decimals') { $newValue .= $key.'='.$val."\n";}
                        else {$newValue .= $key.'="'.$val."\"\n";}
                    }
                }
            }
           
            $newValue .= "\n\n\n";
            //save back the results
            file_put_contents($filename, $newValue);
            echo 1;
        }
        else {
            echo 0;
        }
       
        
         
    } 

    //updating the socials toml values
    if ($_GET['type'] == "modifysocial") {  
        $domain = strtolower($_GET['domain']);
        $filename="./$domain/.well-known/stellar.toml";
        // Read the contents of the file
        $currentData = file_get_contents($filename);
        
        // Define the new "desc" value
        $newDesc = $_GET['value']; $addr = $_GET['value'];
        $newValue = ""; $key = "CURRENCIES";  
        $toml = new Toml(); $aToml = $toml::parse($currentData);
       
        //loop through the currency array
        if(isset($aToml->$key)) {
            //get the array
            
            /* Parsing back the values */
            //parse the accounts
            $key="ACCOUNTS";$flg = false;
            if(isset($aToml->$key)) {
                $newValue = 'ACCOUNTS=['; $toml = $aToml->$key; 
                for($i=0;$i<sizeof($toml); $i++) {$val = $toml[$i];
                    $newValue .= '"' . $val . '"';if($i<sizeof($toml) - 1){$newValue .= ",";}
                }
                $newValue .= "]"; $flg = true;
            }
            $key="DOCUMENTATION";
            if(isset($aToml->$key)) {
                //split the value
                $social = json_decode($_GET['value'], true); 
                if($flg) {$newValue .= "\n\n";}
                $newValue .= "[DOCUMENTATION]\n";$toml = $aToml->$key;  
                foreach($toml as $key => $val) {
                    if($key == 'ORG_INSTAGRAM' && isset($social['instagram'])){ $val = $social['instagram'];}
                    if($key == 'ORG_TWITTER' && isset($social['twitter'])){ $val = $social['twitter'];}
                    if($key == 'ORG_TELEGRAM' && isset($social['telegram'])){ $val = $social['telegram'];}
                    if($key == 'ORG_REDDIT' && isset($social['reddit'])){ $val = $social['reddit'];}
                    if($key == 'ORG_DISCORD' && isset($social['discord'])){ $val = $social['discord'];}
                    $newValue .= $key.'="'.$val."\"\n";
                }
            }
            $key="CURRENCIES";
            if(isset($aToml->$key)) {
                if($flg) {$newValue .= "\n";}
                $toml = $aToml->$key;  
                foreach($toml as $cur) {
                    $newValue .= "\n[[CURRENCIES]]\n";
                    foreach($cur as $key => $val) {
                        if($key == 'display_decimals') { $newValue .= $key.'='.$val."\n";}
                        else {$newValue .= $key.'="'.$val."\"\n";}
                    }
                }
            }
            $newValue .= "\n\n\n";
            //save back the results
            file_put_contents($filename, $newValue);
            echo 1;
        }
        else {
            echo 0;
        }
       
        
         
    } 
    
    //do the wrap 
    if($_GET['type'] == 'wrapasset') {
        //endpoint url
        $url = 'https://lumos-server.onrender.com/wrap?code=' . $_GET['code'] . "&issuer=" . $_GET['issuer'];
        $ch = curl_init();
        curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 1000,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false
            )
        );
        //execute
        $res = curl_exec($ch);
        if ($res !== false) {  
            // cURL request failed
            $data = json_decode($res);$key = 'status';  
            if(isset($data->$key)) {
                if($data->$key === true) {
                    echo 1;
                }
                else if($data->$key === 'error') {
                    $key = 'msg';
                    if($data->$key === 'exists') {
                        echo 1;
                    }
                    else {echo 2;}
                }
            }
            else {echo 0;}
        } else {
            //success
            echo 0;
        }
        
        // Close the cURL session
        curl_close($ch);
    }
    
    //uploading of proposal files and return a link address
    if ($_SERVER["REQUEST_METHOD"] === "POST" && $_GET['type'] == "proposal_upload") { 
        if (isset($_FILES["files0"])) {
            //loop through the number of files sent
            $flg = false; $link = ""; $dao = strtolower($_GET['dao']);
            for($i=0;$i<$_GET['num'] * 1;$i++){
                $file = $_FILES["files$i"];  
                $uploadDirectory = strtolower($_GET['dao']) . '/proposal/' . $_GET['proposal_name'] . '/files/'; // Define your upload directory
               
                //make directory if it dont exits
                if(!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);
                     
                }
                // Check if the file is an image
                $imageType = exif_imagetype($file["tmp_name"]);
                $allowedTypes = [
                    IMAGETYPE_JPEG,
                    IMAGETYPE_PNG,
                    IMAGETYPE_GIF,
                    IMAGETYPE_BMP,
                    IMAGETYPE_WEBP,
            ];
                $allowedDocumentTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'text/plain',
                    'application/rtf',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            ];
                if ((in_array($imageType, $allowedTypes) || in_array($file['type'], $allowedDocumentTypes))) {
                    if (move_uploaded_file($file["tmp_name"], $uploadDirectory . $file["name"])) {
                        $flg = $flg || true;
                        //construct link
                        $link .= "https://$dao." . $_SERVER['HTTP_HOST'] . "/proposal/" . $_GET['proposal_name'] . "/files/". $file["name"] . ",";
                    }
                }  
            }
            
            echo '{"status" : ' . $flg , ', "links": "' . $link . '"}';
        } else {
            echo '{"status" : 0, "links": ""}';
        }
    } 
    
    //to check if am image link is valid
    if ($_GET['type'] == "valid_image") {  
        $url = $_GET['value'];
        $headers = get_headers($url, 1);
    
        if ($headers !== false && strpos($headers[0], '200') !== false) {
            // Image is valid
            echo 1;
        } else {
            // Image is not valid
            echo 0;
        }
    }
    
    //to get list of holders
    if($_GET['type'] == 'asset_holder') { 
        $url = $_GET['url'];
        $ch = curl_init();
        curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
            )
        );
        //execute
        $res = curl_exec($ch);  
        if ($res !== false) {
            // cURL request failed
            $res = json_decode($res);
            if(isset($res->position)) {
                echo $res->position;
            }
            else {echo 0;}
        }
        else {echo 0;}
    }
    //to get no of comments
    if($_GET['type'] == 'wallet_comment') { 
        require('./db.php');
        $addr = $_GET['address'];
        $daoId = $_GET['dao_id'];
        $query = "SELECT * FROM proposal_comments WHERE dao_id='$daoId' AND wallet='$addr'";
	    $result = mysqli_query($conn, $query);
	    if(mysqli_num_rows($result)>0){
	        echo mysqli_num_rows($result);
	    }
	    else {echo 0;}
    }
    //to get no of comments
    if($_GET['type'] == 'wallets_comment') { 
        require('./db.php');
        $addr = $_GET['address'];
        $daoId = $_GET['dao_id'];
        $query = "SELECT * FROM proposal_comments WHERE wallet='$addr'";
	    $result = mysqli_query($conn, $query);
	    if(mysqli_num_rows($result)>0){
	        echo mysqli_num_rows($result);
	    }
	    else {echo 0;}
    }
    //get comments for a proposal
    if($_GET['type'] == 'get_comment') { 
        require('./db.php');
        $propId = $_GET['proposal_id'];
        $daoId = $_GET['dao'];
        $query = "SELECT * FROM proposal_comments WHERE proposal_id='$propId' AND dao_id='$daoId' ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    if(mysqli_num_rows($result)>0){
	        $res = array(); $i=0;
	        while($row= mysqli_fetch_array($result)){
	            $tmp = array(); //declare array
	            //structure result
	            $tmp['msg'] = $row['msg'];$tmp['address'] = $row['wallet'];
	            $tmp['date'] = $row['date'];$tmp['proposal_id'] = $row['proposal_id'];
	            $res[$i] = json_encode($tmp);
	            $i++;
	        }
	        echo json_encode($res);
	    }
	 
	    else {echo "";}
    }
    //get user comments
    if($_GET['type'] == 'user_comment') { 
        require('./db.php');
        $addr = $_GET['address'];
        $daoId = $_GET['dao'];
        $query = "SELECT * FROM proposal_comments WHERE wallet ='$addr' ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    if(mysqli_num_rows($result)>0){
	        $res = array(); $i=0;
	        while($row= mysqli_fetch_array($result)){
	            $tmp = array(); //declare array
	            //structure result
	            $tmp['msg'] = $row['msg'];$tmp['address'] = $row['wallet'];
	            $tmp['date'] = $row['date'];$tmp['proposal_id'] = $row['proposal_id'];
	            $res[$i] = json_encode($tmp);
	            $i++;
	        }
	        echo json_encode($res);
	    }
	    else {echo "";}
    }
    //get tx
    if($_GET['type'] == 'get_tx') { 
        require('./db.php');
        $daoId = $_GET['dao'];
        $query = "SELECT * FROM tx WHERE dao_id ='$daoId' ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    if(mysqli_num_rows($result)>0){
	        $res = array(); $i=0;
	        while($row= mysqli_fetch_array($result)){
	            $tmp = array(); //declare array
	            //structure result
	            $tmp['action'] = $row['action'];$tmp['signer'] = $row['signer'];
	            $tmp['date'] = $row['date'];$tmp['data'] = $row['data'];
	            $tmp['hash'] = $row['hash'];
	            $res[$i] = json_encode($tmp);
	            $i++;
	        }
	        echo json_encode($res);
	    }
	    else {echo "";}
    }
    if($_GET['type'] == 'get_dao_users') {  
        require('./db.php');
        $daoId = $_GET['dao'];
        $query = "SELECT * FROM tx WHERE dao_id ='$daoId' AND (LOWER(action) LIKE LOWER('%create new dao%') OR LOWER(action) LIKE LOWER('%joined dao%') OR LOWER(action) LIKE LOWER('%left dao%')) ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    if(mysqli_num_rows($result)>0){
	        $res = array(); $i=0;
	        while($row= mysqli_fetch_array($result)){
	            $tmp = array(); //declare array
	            //structure result
	            $tmp['user'] = $row['signer']; $tmp['action'] = $row['action']; 
	            $res[$i] = json_encode($tmp);
	            $i++;
	        }
	        echo json_encode($res);
	    }
	    else {echo "";}
    }
    
    //get user tx
    if($_GET['type'] == 'get_user_tx') { 
        require('./db.php');
        $daoId = $_GET['dao'];
        $adr = $_GET['address'];
        $query = "SELECT * FROM tx WHERE dao_id ='$daoId' AND signer='$adr' ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    if(mysqli_num_rows($result)>0){
	        $res = array(); $i=0;
	        while($row= mysqli_fetch_array($result)){
	            $tmp = array(); //declare array
	            //structure result
	            $tmp['action'] = $row['action'];$tmp['signer'] = $row['signer'];
	            $tmp['date'] = $row['date'];$tmp['data'] = $row['data'];
	            $tmp['hash'] = $row['hash'];
	            $res[$i] = json_encode($tmp);
	            $i++;
	        }
	        echo json_encode($res);
	    }
	    else {echo "";}
    }
    //to get account age
    if($_GET['type'] == 'wallet_age') { 
        $address = $_GET['address'];
        $ch = curl_init();
        curl_setopt_array($ch, array(
                CURLOPT_URL => "https://horizon-testnet.stellar.org/accounts/$address/transactions",
                CURLOPT_RETURNTRANSFER => true
            )
        );
        //execute
        $res = curl_exec($ch);  
        if ($res !== false) {
            // cURL request failed
            $res = json_decode($res);  
            $timestamp = $res->_embedded->records[0]->created_at; 
            // Convert the timestamp to a Unix timestamp
            $timestampInSeconds = strtotime($timestamp);
            // Get the current time as a Unix timestamp
            $currentTimestamp = time();  
            // Calculate the elapsed time in seconds
            $secondsInAMonth = 30 * 24 * 60 * 60;
            // Calculate the approximate number of months
            $elapsedMonths = ($currentTimestamp - $timestampInSeconds) / $secondsInAMonth;
            echo round($elapsedMonths);
        }
        else {
            echo 0;
        }
    }
    
    //to get no of trades for an account
    if($_GET['type'] == 'wallet_trade') { 
        $address = $_GET['address'];
        $ch = curl_init();
        curl_setopt_array($ch, array(
                CURLOPT_URL => "https://horizon-testnet.stellar.org/accounts/$address/trades",
                CURLOPT_RETURNTRANSFER => true
            )
        );
        //execute
        $res = curl_exec($ch);  
        if ($res !== false) {
            // cURL request failed
            $res = json_decode($res);  
            echo sizeof($res->_embedded->records);
        }
        else {
            echo 0;
        }
    }
    
    //to get usd balance of a wallet
    if($_GET['type'] == 'xlm_usd') { 
        $address = $_GET['address'];
        if((time() - $XLM_USD_LAST_UPDATED_DATE) > 86400) {
            //greater than a day, update
            $ch = curl_init();
            curl_setopt_array($ch, array(
                    CURLOPT_URL => "https://ticker.stellar.org/",
                    CURLOPT_RETURNTRANSFER => true
                )
            );
            //execute
            $res = curl_exec($ch);  
            if ($res !== false) {  
                // cURL request failed
                $res = json_decode($res);  
                if($res !== null) { 
                    $res = $res->pairs;$n=0;
                    foreach ($res as $pair) { 
                        if($pair->name == 'XLM_USD') {
                            $XLM_USD_PRICE = 1 / $pair->price;
                        }
                    }
                }
            } 
            $XLM_USD_LAST_UPDATED_DATE = time(); //update the date
            //save back results to config.php
            file_put_contents('./prices.php', "<?php \n " . '$' . "XLM_USD_PRICE = $XLM_USD_PRICE;\n".'$'."XLM_USD_LAST_UPDATED_DATE = $XLM_USD_LAST_UPDATED_DATE; \n ?>");
        }
        //get the xlm balance
        $ch = curl_init();
        curl_setopt_array($ch, array(
                CURLOPT_URL => "https://horizon-testnet.stellar.org/accounts/$address",
                CURLOPT_RETURNTRANSFER => true
            )
        );
        //execute
        $res = curl_exec($ch);  
        if ($res !== false) {
            // cURL request failed
            $res = json_decode($res);  
            $res = $res->balances;
            $_bal = 0;
            //loop through
            foreach ($res as $bal) { 
                if($bal->asset_type == 'native') {
                    $_bal = $bal->balance;
                    break;
                }
            }
            echo ($_bal * $XLM_USD_PRICE);
        }
        else {echo 0;}
    }
    
    //to add comments to proposal
    if($_GET['type'] == 'add_comment') { 
        //do the msyql connection
        require('./db.php');
        //insert into the database
            $addr = $_GET['address'];
            $msg = $_GET['msg'];
            $propId = $_GET['proposal_id'];
            $daoId = $_GET['dao_id'];
            $query = "INSERT INTO proposal_comments (wallet, msg, proposal_id, dao_id) 
    	               VALUES ('$addr', '$msg', '$propId', '$daoId')";
    	 	$res = mysqli_query($conn, $query);
    	 	if($res){
    	 		echo 1;
    	 	}  
    	 	else {
    	 	    echo 0;
    	 	}
    }
    
    //to add txs  
    if($_GET['type'] == 'add_tx') { 
        //do the msyql connection
        require('./db.php');
        //insert into the database
            $addr = $_GET['address'];
            $act = $_GET['action'];
            $data = $_GET['data'];
            $daoId = $_GET['dao_id'];
            $hash = $_GET['hash'];
            $query = "INSERT INTO tx (signer, action, data, dao_id, hash) 
    	               VALUES ('$addr', '$act', '$data', '$daoId', '$hash')";
    	 	$res = mysqli_query($conn, $query);
    	 	if($res){
    	 		echo 1;
    	 	}  
    	 	else {
    	 	    echo 0;
    	 	}
    }
    //to ban a member
    if($_GET['type'] == 'ban') { 
        //do the msyql connection
        require('./db.php');
        //insert into the database
            $user = $_GET['user'];
            $daoId = $_GET['dao_id'];
            $query = "INSERT INTO tx (signer, action, data, dao_id) 
    	               VALUES ('$addr', '$act', '$data', '$daoId')";
    	 	$res = mysqli_query($conn, $query);
    	 	if($res){
    	 		echo 1;
    	 	}  
    	 	else {
    	 	    echo 0;
    	 	}
    }
    //to send message  
    if($_GET['type'] == 'send_msg') {  
        //do the msyql connection
        require('./db.php');
        //insert into the database
            $sender = $_GET['sender'];
            $receiver = $_GET['receiver'];
            $msg = $_GET['msg'];
            $daoId = $_GET['dao_id'];
            $id = uniqid('msg', true);
            $query = "INSERT INTO message (sender, receiver, msg, dao, msgid) 
    	               VALUES ('$sender', '$receiver', '$msg', '$daoId', '$id')";
    	 	$res = mysqli_query($conn, $query);
    	 	if($res){
    	 	    $query = "SELECT * FROM message WHERE msgid ='$id'";
	            $result = mysqli_query($conn, $query);
        	    if(mysqli_num_rows($result)>0){$row= mysqli_fetch_array($result); echo $row['id'];}
    	 		else {echo $id;}
    	 	}  
    	 	else {
    	 	    echo 0;
    	 	}
    }
    //to get message  
    if($_GET['type'] == 'get_msg') {  
        //do the msyql connection
        require('./db.php');
        //insert into the database
        $signer = $_GET['signer'];
        $daoId = $_GET['dao_id'];
        $index = $_GET['index'];
        $query = "SELECT * FROM message WHERE dao ='$daoId' AND (receiver='$signer' OR receiver='all' OR sender='$signer') AND id >= $index ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    if(mysqli_num_rows($result)>0){
	        $res = array(); $i=0;
	        while($row= mysqli_fetch_array($result)){
	            $tmp = array(); //declare array
	            //structure result
	            $tmp['msg'] = $row['msg'];$tmp['sender'] = $row['sender'];
	            $tmp['date'] = $row['date'];$tmp['receiver'] = $row['receiver'];
	            $tmp['dao'] = $row['dao'];$tmp['id'] = $row['id'];$tmp['status'] = $row['status'];
	            $res[$i] = json_encode($tmp);
	            $i++;
	        }
	        echo json_encode($res);
	    }
	    else {echo "{}";}
    }
    //to read message  
    if($_GET['type'] == 'read_msg') {  
        //do the msyql connection
        require('./db.php');
        //insert into the database
        $reader = $_GET['reader'];
        $sender = $_GET['sender'];
        $msgId = $_GET['id'];
        $daoId = $_GET['dao_id'];
        $query = "UPDATE message SET status='read' WHERE dao ='$daoId' AND sender='$sender' AND receiver='$reader' AND id <= $msgId";
	    $res = mysqli_query($conn, $query);
	    if($res){
	        $reader = substr($reader,0,15);
	        $query = "UPDATE message SET status = CONCAT(status, '$reader,')  WHERE dao ='$daoId' AND sender='$sender' AND receiver='all' AND id <= $msgId";
	        $res = mysqli_query($conn, $query);
	        if($res) {echo 1;}else{echo 0;}
    	}  
    	else {
    	   echo 0;
    	}
    }
    //to verify admin  
    if($_GET['type'] == 'isadmin') { 
         $url = strtolower($_GET['url']);
         // Read the contents of the file
         $currentData = file_get_contents($url);
         //split into address and names
         $addr = $_GET['user'];
         $toml = new Toml(); $aToml = $toml::parse($currentData);
         //checking for admins
         $key="WALLET_NAMES";
         $flg = false; 
         $toml = $aToml->$key;  
          
         if(isset($aToml->$key)) {
                foreach($toml as $key => $val) {
                    if($key == $addr){ 
                        if($val == 'admin') {  
                            $flg = true;
                            break;    
                        }
                    } 
                }
            }
         $key="CURRENCIES";
         if(isset($aToml->$key)) {
            $toml = $aToml->$key;  
            foreach($toml as $cur) {
                foreach($cur as $key => $val) {
                    if($key == 'issuer') { 
                        if($val == $addr) {$flg = true;break;}
                    }
                }
            }
        }
        echo true;
    }
    //to enable 2FA
    if($_GET['type'] == 'get_2fa') {
        require('./db.php');
        $issuer = "LumosDao";
        $accountName = $_GET['user'];
        $secretFactory = new SecretFactory();
        $secret = $secretFactory->create($issuer, $accountName);
        $res= array();
        $res['uri'] = $secret->getUri();
        $res['secret'] = $secret->getSecretKey();
        echo json_encode($res);
    }
    //to verify 2fa otp
    if($_GET['type'] == 'verify_2fa') {
        require('./db.php'); 
        $issuer = "LumosDao";
        $accountName = $_GET['user'];
        $code = $_GET['code'];
        $key = $_GET['key'];
        $tmp = array(); $tmp['status'] = false;
        if($key != "") { 
	        $oAuth = new GoogleAuthenticator();
            $res = $oAuth->authenticate($key, $code);
            if($res == true) {
                //save back the key
                $query = "SELECT * FROM users WHERE wallet ='$accountName' ORDER BY ID DESC";
        	    $result = mysqli_query($conn, $query);
        	    if(mysqli_num_rows($result)>0){
        	         //update secret key
        	         $query = "UPDATE users SET 2fa_secret_key='$key' WHERE wallet='$accountName' ";
        	         $result = mysqli_query($conn, $query);
        	         if($result) {
        	             $tmp['status'] = true;
        	         }
        	    }
        	    else {
        	        //insert into 
        	        $img = 'https://id.lobstr.co/'. $accountName . '.png';
        	        $query = "INSERT INTO users (wallet, 2fa_secret_key, image)
        	                   VALUES('$accountName', '$key', '$img') ";
        	        $result = mysqli_query($conn, $query);
        	        if($result) {
        	            $tmp['status'] = true;
        	        }
        	    }
           }
	    }
        echo json_encode($tmp);
    }
    //to add bulletin
    if($_GET['type'] == 'add_bulletin') { 
        //do the msyql connection
        require('./db.php');
        //insert into the database
            $addr = $_GET['address'];
            $msg = $_GET['msg'];
            $daoId = $_GET['dao_id'];
            $id = uniqid('bulletin', true); 
            $query = "INSERT INTO bulletins (user, msg, dao_id, bid) 
    	               VALUES ('$addr', '$msg', '$daoId','$id')";
    	 	$res = mysqli_query($conn, $query); 
    	 	$tmp = array();$tmp['status'] = false;
    	 	if($res){
    	 		$tmp['status'] = true;
    	 		$tmp['id'] = $id;
    	 	}  
    	 	echo json_encode($tmp); 
    }
    //to get bulletin
    if($_GET['type'] == 'get_bulletin') { 
        //do the msyql connection
        require('./db.php');
        //insert into the database
        $user = $_GET['user'];
        $daoId = $_GET['dao_id'];
        $query = "SELECT * FROM bulletins WHERE dao_id ='$daoId' ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    $res = array();
	    if(mysqli_num_rows($result)>0){
	        $i=0;
	        while($row= mysqli_fetch_array($result)){
	            $res[$i] = $row;
	            $t = sizeof(explode(",", $row['likes'])) - 1;
	            $res[$i]['likes'] = ($t > 0) ? $t : 0;
	            $t = sizeof(explode(",", $row['dislikes'])) - 1;
	            $res[$i]['dislikes'] = ($t > 0) ? $t : 0;
	            $res[$i]['my_likes'] = (strpos($row['likes'], $user) > -1);
	            $res[$i]['my_dislikes'] = (strpos($row['dislikes'], $user) > -1);
	            //process poll data
	            if($row['type'] == 'poll') {
	                $poll = json_decode(json_encode(json_decode($row['polls']), true));$polls = array();$n=0;$totalVotes = 0;
	                for($x=0;$x<($poll->num * 1);$x++) {
                        if(isset($poll->$x)) {
                            $polls[$n] = array();
                            $polls[$n]['value'] = $poll->$x->value;
                            $t = sizeof(explode(",", $poll->$x->votes)) - 1;
                            $polls[$n]['votes'] = ($t > 0) ? $t : 0;
                            $polls[$n]['voted'] = (strpos($poll->$x->votes, $user) > -1);
                            $totalVotes += $polls[$n]['votes'] * 1;
                            $n++;
                        }
                    }
                    //calculate the percentage
                    for($x=0;$x<$n;$x++) {
                        if(isset($polls[$x])) {
                            $polls[$x]['percent'] =  ($totalVotes > 0) ? round((100/$totalVotes) * $polls[$x]['votes']) : 0;
                        }
                    }
                    $polls['num'] = $n;
                    $res[$i]['polls'] = $polls;
	            }
	            $i++;
	        }   
	    }
	    echo json_encode($res);
    }
    //to add poll
    if($_GET['type'] == 'add_poll') { 
        //do the msyql connection
        require('./db.php');
        //insert into the database
            $addr = $_GET['address'];
            $msg = $_GET['msg'];
            $daoId = $_GET['dao_id'];
            $id = uniqid('poll', true); 
            $poll = json_decode($_GET['polls']);
            $poll = json_decode(json_encode($poll), true);
            $tmp = array();$tmp['status'] = false;
            if(isset($poll['num'])) {
                if(($poll['num'] * 1) > 0) {
                    $polls = array();$n=0;
                    for($i=0;$i<($poll['num'] * 1);$i++) {
                        if(isset($poll[$i])) {
                            $polls[$n] = array();
                            $polls[$n]['value'] = $poll[$i];
                            $polls[$n]['votes'] = "";
                            $n++;
                        }
                    }
                    if($n > 0) {
                        $polls['num'] = $n;
                    }
                }
                if(isset($polls['num'])) {
                    $polls = json_encode($polls);
                    $query = "INSERT INTO bulletins (user, msg, dao_id, bid, polls, type) 
            	               VALUES ('$addr', '$msg', '$daoId','$id', '$polls', 'poll')";
            	 	$res = mysqli_query($conn, $query); 
            	 	if($res){
            	 		$tmp['status'] = true;
            	 		$tmp['id'] = $id;
            	 	}  
                }
            }
            echo json_encode($tmp); 
    }
    //to like bulletin
    if($_GET['type'] == 'like_bulletin') { 
        //do the msyql connection
        require('./db.php');
        $user = $_GET['user'];
        $id = $_GET['id'];
        $query = "SELECT * FROM bulletins WHERE bid ='$id' LIMIT 1";
	    $result = mysqli_query($conn, $query);
	    $res = array(); $res['status'] = false;
	    if(mysqli_num_rows($result)>0){
	        while($row= mysqli_fetch_array($result)){
	            //present
	            $type = 0; $likes = "";$dislikes = $row['dislikes'];
	            if(strpos($row['likes'], $user) > -1) {
	                //remove
	                $likes = str_replace($user.",", "", $row['likes']);
	            }
	            else {
	                $likes = $row['likes'] . $user . ",";
	                //remove from dislike too
	                $dislikes = str_replace($user.",", "", $row['dislikes']);
	                $type = 1;
	            }
	            //save back
	            $query = "UPDATE bulletins SET likes='$likes', dislikes='$dislike' WHERE bid = '$id'";
	            $resp = mysqli_query($conn, $query);
	            if($resp) {
	                $res['status'] = true;
	                $res['type'] = $type;
	            }
	        }   
	    }
	    echo json_encode($res);
    }
    //to dislike bulletin
    if($_GET['type'] == 'dislike_bulletin') { 
        //do the msyql connection
        require('./db.php');
        $user = $_GET['user'];
        $id = $_GET['id'];
        $query = "SELECT * FROM bulletins WHERE bid ='$id' ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    $res = array(); $res['status'] = false;
	    if(mysqli_num_rows($result)>0){
	        while($row= mysqli_fetch_array($result)){
	            //present
	            $type = 0;$likes = $row['likes'];
	            if(strpos($row['dislikes'], $user) > -1) {
	                //remove
	                $dislikes = str_replace($user.",", "", $row['dislikes']);
	            }
	            else {
	                $dislikes = $row['dislikes'] . $user . ",";
	                $likes = str_replace($user.",", "", $row['likes']);
	                $type = 1;
	            }
	            //save back
	            $query = "UPDATE bulletins SET dislikes='$dislikes', likes='$likes' WHERE bid ='$id'";
	            $resp = mysqli_query($conn, $query);
	            if($resp) {
	                $res['status'] = true;
	                $res['type'] = $type;
	            }
	        }   
	    }
	    echo json_encode($res);
    }
    //to vote on poll
    if($_GET['type'] == 'vote_poll') { 
        //do the msyql connection
        require('./db.php');
        $user = $_GET['user'];
        $id = $_GET['id'];
        $pid = $_GET['pid'];
        $query = "SELECT * FROM bulletins WHERE bid ='$id' LIMIT 1";
	    $result = mysqli_query($conn, $query);
	    $res = array(); $res['status'] = false;
	    if(mysqli_num_rows($result)>0){
	        while($row= mysqli_fetch_array($result)){
	            if($row['type'] == 'poll') {
    	            //present
    	            $poll = json_decode(json_encode(json_decode($row['polls']), true));
	                if(isset($poll->$pid)) {
	                    //loop through the poll and check if its has already voted
	                    $flg = false;
	                    for($x=0;$x<($poll->num * 1);$x++) {
                            if(isset($poll->$x)) {
                                if(strpos($poll->$x->votes, $user) > -1) {
                                    $flg = true;break;
                                }
                            }
                        }
                        if(!$flg) {
                            //vote it
                            $poll->$pid->votes .= $user . "," ;
                            $polls = json_encode($poll);
            	            //save back
            	            $query = "UPDATE bulletins SET polls='$polls' WHERE bid = '$id'";
            	            $resp = mysqli_query($conn, $query);
            	            if($resp) {
            	                $res['status'] = true;
            	                $res['type'] = 'done';
            	                //resend current voting data
            	                $polls = array();$n=0;$totalVotes = 0;
            	                for($x=0;$x<($poll->num * 1);$x++) {
                                    if(isset($poll->$x)) {
                                        $polls[$n] = array();
                                        $polls[$n]['value'] = $poll->$x->value;
                                        $t = sizeof(explode(",", $poll->$x->votes)) - 1;
                                        $polls[$n]['votes'] = ($t > 0) ? $t : 0;
                                        $polls[$n]['voted'] = (strpos($poll->$x->votes, $user) > -1);
                                        $totalVotes += $polls[$n]['votes'] * 1;
                                        $n++;
                                    }
                                }
                                //calculate the percentage
                                for($x=0;$x<$n;$x++) {
                                    if(isset($polls[$x])) {
                                        $polls[$x]['percent'] =  ($totalVotes > 0) ? round((100/$totalVotes) * $polls[$x]['votes']) : 0;
                                    }
                                }
            	            }
            	            $res['polls'] = $polls;
            	            $res['status'] = true;
                        }
                        else {
                             $res['status'] = true;
            	             $res['type'] = 'voted';   
                        }
	                }
	            }
	            else {
	                $res['msg'] = 'bulletin';
	            }
	        }   
	    }
	    echo json_encode($res);
    }
    
    //to send bulletin comments
    if($_GET['type'] == 'add_bulletin_comment') { 
        //do the msyql connection
        require('./db.php');
        //insert into the database
            $addr = $_GET['user'];
            $msg = $_GET['msg'];
            $bid = $_GET['bid'];
            $id = uniqid('bulletin_comment', true);
            $query = "INSERT INTO bulletins_comments (user, msg, bid, cid) 
    	               VALUES ('$addr', '$msg', '$bid', '$id')";
    	 	$res = mysqli_query($conn, $query);
    	 	if($res){
    	 	     //save the number of comment to bulletin
    	 	     $query = "SELECT * FROM bulletins_comments WHERE bid ='$bid'";
        	     $result = mysqli_query($conn, $query);
        	     if($result) {
        	        $num = mysqli_num_rows($result);
        	        $query = "UPDATE bulletins SET comments = '$num' WHERE bid ='$bid'";
        	        $result = mysqli_query($conn, $query);
        	        if($result) {
        	            echo 1;
        	        }
        	        else {
        	            echo 0;
        	        }
        	     }
        	     else {echo 0;}
        	}  
    	 	else {
    	 	    echo 0;
    	 	}
    } 
    //to get bulletin comments
    if($_GET['type'] == 'get_bulletin_comment') { 
        //do the msyql connection
        require('./db.php');
        //insert into the database
        $bid = $_GET['bid'];
        $query = "SELECT * FROM bulletins_comments WHERE bid ='$bid' ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    $res = array();
	    if(mysqli_num_rows($result)>0){
	        $i=0;
	        while($row= mysqli_fetch_array($result)){
	            $res[$i] = $row;
	            $i++;
	        }   
	    }
	    echo json_encode($res);
    }
    //to add tweet
    if($_GET['type'] == 'add_tweet') { 
        //do the msyql connection
        require('./db.php');
        //insert into the database
            $addr = $_GET['address'];
            $code = $_GET['code'];
            $dao = $_GET['dao_id'];
            $id = uniqid('tweet_code', true);
            $query = "INSERT INTO tweet (user, code, dao, tid) 
    	               VALUES ('$addr', '$code', '$dao', '$id')";
    	 	$res = mysqli_query($conn, $query);
    	 	$tmp = array(); $tmp['status'] = false;
    	 	if($res){
    	 	    $embed_endpoint = 'https://publish.twitter.com/oembed?url=' . urlencode($code);
                $response = file_get_contents($embed_endpoint);
                $tmp['html'] = json_decode($response)->html;
	            $tmp['status'] = true;
        	}  
            
            echo json_encode($tmp);
    
    }
    //to get bulletin comments
    if($_GET['type'] == 'get_tweet') { 
        //do the msyql connection
        require('./db.php');
        //insert into the database
        $id = $_GET['dao_id'];
        $query = "SELECT * FROM tweet WHERE dao ='$id' ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    $res = array();
	    if(mysqli_num_rows($result)>0){
	        $i=0;
	        while($row= mysqli_fetch_array($result)){
	            $res[$i] = $row;
	            //fecth tweet
	            $embed_endpoint = 'https://publish.twitter.com/oembed?url=' . urlencode($row['code']);
                $response = file_get_contents($embed_endpoint);
                $res[$i]['html'] = json_decode($response)->html;
	            $i++;
	        }   
	    }
	    echo json_encode($res);
    }
    
    /* ALERTS 
        3. ⁠if the result is announced for a proposal where I voted 
        5. ⁠someone designates his voting power to me
        6. ⁠someone likes my comment that I added on the proposal
        7. ⁠someone likes my comment on the bulletin
    */
    //add new alert
    if($_GET['type'] == 'add_alert') {  
        //do the msyql connection
        require('./db.php');
        $resp = array();
        $resp['status'] = false;
        //insert into the database
        $user = $_GET['user'];
        $other = $_GET['other'];
        $action = $_GET['action'];
        $link = $_GET['link'];
        $type = $_GET['alert_type']; 
        $title = $_GET['title'];
        //only register alert not done by user
        if($user != $other) {
            $query = "INSERT INTO alert (title, action, user, other, type, link) 
        	              VALUES ('$title', '$action', '$user', '$other', '$type', '$link')";
        	$res = mysqli_query($conn, $query);
        	echo mysqli_error($conn);
        	if($res){
        	    $resp['status'] = true;
        	}  
        }
        echo json_encode($resp);
    }
    //to get user alerts
    if($_GET['type'] == 'get_user_alert') { 
        require('./db.php');
        $user = $_GET['user'];
        $query = "SELECT * FROM alert WHERE user ='$user' ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    $res = array();
	    if(mysqli_num_rows($result)>0){
	        $i=0;
	        while($row= mysqli_fetch_array($result)){
	            $tmp = array(); //declare array
	            //structure result
	            $tmp['action'] = $row['action'];
	            $tmp['title'] = $row['title'];
	            $tmp['link'] = $row['link'];
	            $tmp['user'] = $row['user'];
	            $tmp['other'] = $row['other'];
	            $tmp['type'] = $row['type'];
	            $tmp['date'] = $row['date']; 
	            $res[$i] = json_encode($tmp);
	            $i++;
	        }
	    }
	    //set the status to read
	    $query = "UPDATE alert SET status = 'read' WHERE user ='$user'";
	    $result = mysqli_query($conn, $query);
	    echo json_encode($res);
    }
    //to get user alerts unread num
    if($_GET['type'] == 'get_user_alert_no') { 
        require('./db.php');
        $user = $_GET['user'];
        $query = "SELECT * FROM alert WHERE user = '$user' AND status = 'unread'";
	    $result = mysqli_query($conn, $query);
	    $res = array();$res['num'] = 0;
	    $res['num'] = mysqli_num_rows($result);
	    echo json_encode($res);
    }
    /** to get dao metadata
     * param {dao_owner_id}
     * param {dao_array}
    returns metadata and all daos
    **/
    if($_GET['type'] == 'get_metadata') {
        require('./db.php');
        $daoId = $_GET['dao_id']; 
        $res = array(); 
	    //get number of users
        $query = "SELECT * FROM daos ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    $a_user = "";
	    if(mysqli_num_rows($result)>0){
	        $i=0; 
	        while($row= mysqli_fetch_array($result)){
	            $user = explode(",", $row['users'] . "," . $row['issuer']);
	            foreach($user as $id) { 
                    $id = preg_replace('/[^0-9a-zA-Z]+/', '', $id);
                    if($id != "") {
                        if(!(strpos($a_user, $id) > -1)) {
                            //add and count
                            $a_user .= $id;
                            $i++;
                        }
                    }
                }
            }
	    }
	    $res['users'] = $i;
	    $query = "SELECT * FROM proposals WHERE dao_id ='$daoId'";
	    $result = mysqli_query($conn, $query);
	    $i = mysqli_num_rows($result);
	    $res['proposals'] = $i;
	    
	    //return result
	    echo json_encode($res);
    }
    /** Save new dao info off chain
     * @params {token, url, dao_id}
    **/
    if($_GET['type'] == 'new_dao') {
        require('./db.php');
        $daoId = $_GET['dao_id'];  
        $token = $_GET['token'];
        $url = $_GET['url'];
        $code = $_GET['code'];
        $image = $_GET['image'];
        $cover_image = $_GET['cover_image'];
        $desc = $_GET['about'];
        $issuer = $_GET['issuer'];
        $name = $_GET['name'];
       
        $res = array(); $res['status'] = false;
        //check if dao exists already
        $query = "SELECT * FROM daos WHERE token ='$token' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        if(!(mysqli_num_rows($result)>0)){
        	 //insert into 
        	 $query = "INSERT INTO daos (token, url, dao_id, name, code, image, description, issuer, cover)
        	        VALUES('$token', '$url', '$daoId', '$name','$code','$image','$desc','$issuer', '$cover_image') ";
        	 $result = mysqli_query($conn, $query);
        	 if($result) {
        	     $res['status'] = true;
        	 }
        }
        else{$res['status'] = true;}
        echo json_encode($res);
    }
    //return all dao information
    if($_GET['type'] == 'get_all_dao') {
        require('./db.php');
        $daoIds = $_GET['all_dao']; 
        $daoIds = explode(",", $daoIds);
        $user = $_GET['user'];
        $res = array(); $res['status'] = false;
        if(sizeof($daoIds) > 0) {
            $idString = array();
            //preparing the ids
            foreach($daoIds as $id) { 
                if($id != "") {
                   $id = preg_replace('/[^0-9a-zA-Z]+/', '', $id);
                   if($id != "") {
                       array_push($idString, "'" . $id . "'");
                   }
                }
            }
            $idString = implode(",", $idString);
            if($idString != "") {
                //querying the database
                $query = "SELECT * FROM daos WHERE token IN ($idString) ORDER BY ID DESC";
                $result = mysqli_query($conn, $query);
        	    if(mysqli_num_rows($result)>0){
        	        while($row= mysqli_fetch_array($result)){
        	            $res[$row['token']] = $row;
        	            $res[$row['token']]['joined'] = (strpos($row['users'], $user) > -1);
        	            $mem = explode(",", $row['users']);
        	            $i = 0;
        	            if(sizeof($mem) > 0) {
        	                foreach($mem as $members) {
        	                    if($members != "") {$i++;}
        	                }
        	            }
        	            $res[$row['token']]['members'] = $i + 1;
                    }
	            }
	            $res['status'] = true;
            }
        }
	    
	    //return result
	    echo json_encode($res);
    }
    //return all users
    if($_GET['type'] == 'get_all_dao_users') {
        require('./db.php');
        $res = array(); $res['status'] = false;
        //querying the database
        $query = "SELECT * FROM daos ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    $a_user = "";
	    if(mysqli_num_rows($result)>0){
	        $res['users'] = array();
	        while($row= mysqli_fetch_array($result)){
	            $user = explode(",", $row['users'] . "," . $row['issuer']);
	            foreach($user as $id) { 
                    $id = preg_replace('/[^0-9a-zA-Z]+/', '', $id);
                    if($id != "") {
                        if(!(strpos($a_user, $id) > -1)) {
                            //add and count
                            $a_user .= $id;
                            array_push($res['users'], $id);
                        }
                    }
                }
            }
	    }
	    $res['status'] = true; 
	    
	    //return result
	    echo json_encode($res);
    }
    /** add member to dao
     * @params {token, user}
    **/
    if($_GET['type'] == 'dao_user') {
        require('./db.php');
        $token = $_GET['token'];
        $user = $_GET['user'];
        $res = array(); $res['status'] = false;
        //check if dao exists already
        $query = "SELECT * FROM daos WHERE token ='$token' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>0){
        	 while($row= mysqli_fetch_array($result)){
        	     $users  = "";
        	     if($_GET['_type'] == 'join') {
        	         if(!(strpos($row['users'], $user) > -1)){ 
        	             $users = $row['users'] . $user . ",";
        	         }
        	     }
        	     else {
        	         $users = str_replace($user . ",", "", $row['users']);
        	     }
        	     //save back to db
        	     $query = "UPDATE daos SET users='$users' WHERE token='$token'";
        	     $resp = mysqli_query($conn, $query);
                 if($resp) {
                	 $res['status'] = true;
                 }
        	 }
        }
        
        echo json_encode($res);
    }
    /** increase active proposals for dao
     * @params {token}
    **/
    if($_GET['type'] == 'dao_active_proposal') {
        require('./db.php');
        $token = $_GET['token'];
        $res = array(); $res['status'] = false;
        //check if dao exists already
        $query = "SELECT * FROM daos WHERE token ='$token' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>0){
        	 while($row= mysqli_fetch_array($result)){
        	     $active  = ($row['active_proposals'] * 1) + 1;
        	     //save back to db
        	     $query = "UPDATE daos SET active_proposals='$active' WHERE token='$token'";
        	     $resp = mysqli_query($conn, $query);
                 if($resp) {
                	 $res['status'] = true;
                 }
        	 }
        }
        
        echo json_encode($res);
    }
    /** remove proposals for dao
     * @params {token}
    **/
    if($_GET['type'] == 'remove_proposal') {
        require('./db.php');
        $prop_id = $_GET['prop_id'];
        $res = array(); $res['status'] = false;
        //check if dao exists already
        $query = "DELETE FROM proposals WHERE prop_id='$prop_id'";
        $resp = mysqli_query($conn, $query);
        if($resp) {
            $res['status'] = true;
        }
        
        echo json_encode($res);
    }
    /** Save new proposal info off chain
     * @params {token, url, dao_id}
    **/
    if($_GET['type'] == 'new_proposal') {
        require('./db.php');
        $daoId = $_GET['dao_id'];  
        $dao = $_GET['dao'];
        $links = $_GET['links'];
        $propId = $_GET['prop_id'];
        $desc = $_GET['about'];
        $name = $_GET['name'];
        $user = $_GET['user'];
       
        $res = array(); $res['status'] = false;
        //check if dao exists already
        $query = "SELECT * FROM proposals WHERE prop_id ='$propId' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        if(!(mysqli_num_rows($result)>0)){
        	 //insert into 
        	 $query = "INSERT INTO proposals (dao, dao_id, title, about, prop_id, links, creator)
        	        VALUES('$dao', '$daoId', '$name', '$desc','$propId', '$links', '$user') ";
        	 $result = mysqli_query($conn, $query);
        	 if($result) {
        	     $res['status'] = true;
        	 }
        }
        else{$res['status'] = true;}
        echo json_encode($res);
    }
    /** To save voting reasons 
     * @params {reason, prop_id, dao_id, voter}
     **/
     if($_GET['type'] == 'vote_reason') {
        //do the msyql connection
        require('./db.php');
        //insert into the database
        $res = array(); $res['status'] = false;
        $user = $_GET['user'];
        $prop_id = $_GET['prop_id'];
        $dao_id = $_GET['dao_id'];
        $reason = $_GET['reason'];
        //check if the voter has been inserted already
        $query = "SELECT * FROM voteinfo WHERE voter ='$user' AND dao_id='$dao_id' AND prop_id='$prop_id' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        if(!(mysqli_num_rows($result)>0)){
        	 //insert into 
        	 $query = "INSERT INTO voteinfo (prop_id, dao_id, voter, reasons) 
    	           VALUES ('$prop_id', '$dao_id', '$user', '$reason')";
        	$result = mysqli_query($conn, $query);
        	if($result){
        		$res['status'] = true;
        	}  
        }
        else {
            //update the voter info info
            $query = "UPDATE voteinfo SET reasons='$reason' WHERE voter = '$user'AND dao_id='$dao_id' AND prop_id='$prop_id'";
            $result = mysqli_query($conn, $query);
            if($result) {
                $res['status'] = true;
            }
        } 
        echo json_encode($res);
    }
    //get all proposal off chain info
    if($_GET['type'] == 'get_all_proposal') {
        require('./db.php');
        $propIds = $_GET['all_proposal']; 
        $dao_id = $_GET['dao_id']; 
        $propIds = explode(",", $propIds);
        $res = array(); $res['status'] = false;
        if(sizeof($propIds) > 0) {
            $idString = array();
            //preparing the ids
            foreach($propIds as $id) { 
                if($id != "") {
                   $id = preg_replace('/[^0-9a-zA-Z]+/', '', $id);
                   if($id != "") {
                       array_push($idString, "'" . $id . "'");
                   }
                }
            }
            $idString = implode(",", $idString);
            if($idString != "") {
                //querying the database
                $query = "SELECT * FROM proposals WHERE prop_id IN ($idString) AND dao = '$dao_id' ORDER BY ID DESC";
                $result = mysqli_query($conn, $query);
        	    if(mysqli_num_rows($result)>0){
        	        while($row= mysqli_fetch_array($result)){
        	            $res[$row['prop_id']] = $row;
        	            $res[$row['prop_id']]['description'] = $row['about'];
        	        }
	            }
	            $res['status'] = true;
            }
        }
	    
	    //return result
	    echo json_encode($res);
    }
    //get all voter off chain info
    if($_GET['type'] == 'get_all_vote') {
        require('./db.php');
        $voteIds = $_GET['all_voters']; 
        $prop_id = $_GET['prop_id'];
        $dao = $_GET['dao_id'];
        
        $voteIds = explode(",", $voteIds);
        $res = array(); $res['status'] = false;
        if(sizeof($voteIds) > 0) {
            $idString = array();
            //preparing the ids
            foreach($voteIds as $id) { 
                if($id != "") {
                   $id = preg_replace('/[^0-9a-zA-Z]+/', '', $id);
                   if($id != "") {
                       array_push($idString, "'" . $id . "'");
                   }
                }
            }
            $idString = implode(",", $idString);
            if($idString != "") {
                //querying the database
                $query = "SELECT * FROM voteinfo WHERE voter IN ($idString) AND dao_id = '$dao' AND prop_id = '$prop_id' ORDER BY ID DESC";
                $result = mysqli_query($conn, $query);
        	    if(mysqli_num_rows($result)>0){
        	        while($row= mysqli_fetch_array($result)){
        	            $res[$row['voter']] = $row;
        	        }
	                $res['status'] = true;
                }
	        }
        }
	    
	    //return result
	    echo json_encode($res);
    }
    
    /** SOCIAL MEDIA AUTHS **/
    
    /** twitter auth
     * @params {code| refreashToken}
     **/
    if($_GET['type'] == 'twitter_auth') {
        require('./db.php');
        $token = $_GET['dao'];
        $code = $_GET['code'];
        $res = array(); $res['status'] = false; 
 
        //check if dao exists already
        $query = "SELECT * FROM daos WHERE token ='$token' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>0){
        	 while($row= mysqli_fetch_array($result)){
        	     //save back to db
        	     $query = "UPDATE daos SET twitter='$code' WHERE token='$token'";
        	     $resp = mysqli_query($conn, $query);
                 if($resp) {
                	 $res['status'] = true;
                 }
        	 }
        }
        echo json_encode($res);
    }
    /** Telegram auth
     * @params {id}
    **/
    if($_GET['type'] == 'telegram_auth') {
        require('./db.php');
        $token = $_GET['dao'];
        $id = $_GET['id'];
        $res = array(); $res['status'] = false; 
 
        //check if dao exists already
        $query = "SELECT * FROM daos WHERE token ='$token' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>0){
        	 while($row= mysqli_fetch_array($result)){
        	     //save back to db
        	     $query = "UPDATE daos SET telegram='$id' WHERE token='$token'";
        	     $resp = mysqli_query($conn, $query);
                 if($resp) {
                	 $res['status'] = true;
                 }
        	 }
        }
        echo json_encode($res);
    }
    /** reddit auth
    **/
    if($_GET['type'] == 'reddit_auth') {
        require('./db.php');
        require('./utils.php');
        if(isset($_GET['error'])) {
            header('location:lumosdao.io');
        }
        else {  
            $authorizationCode = $_GET['code']; // Retrieve the authorization code from the query parameters
            $dao = substr($_GET['state'], 0, strpos($_GET['state'], ":"));
            $domain = substr($_GET['state'], strpos($_GET['state'], ":") + 1);
                
            // Prepare request parameters
            $params = array(
                'grant_type' => 'authorization_code',
                'code' => $authorizationCode,
                'redirect_uri' => $REDDIT_REDIRECT_URI
            );
            // Prepare headers
            $headers = array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic ' . base64_encode("$REDDIT_ID:$REDDIT_SECRET"),
                'User-Agent: Lumosdao/1.0'  
            );
            // Make a POST request to the access token endpoint
            $accessTokenUrl = 'https://www.reddit.com/api/v1/access_token';
            $ch = curl_init($accessTokenUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            curl_close($ch);
            // Parse the response
            $data = json_decode($response, true);
            if(isset($data['refresh_token'])) {
                //fetch the user name
                $accessToken = $data['access_token']; //the user access token
                $refreshToken = $data['refresh_token'];
                // Prepare headers
                $headers = array(
                    'Authorization: Bearer ' . $accessToken,
                    'User-Agent: Lumosdao/1.0'  
                );
                // Make a GET request to the 'me' endpoint
                $meUrl = 'https://oauth.reddit.com/api/v1/me';
                $ch = curl_init($meUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $response = curl_exec($ch);
                curl_close($ch);
                // Parse the response
                $data = json_decode($response, true);
                if(isset($data['subreddit'])){
                    //save the share url first 
                    $shareUri = "https://reddit.com" . $data['subreddit']['url'];  
                    $temp = array(); $temp['reddit'] = $shareUri;
                    if(modifySocial($domain, json_encode($temp))) {
                        //check if dao exists already
                        $query = "SELECT * FROM daos WHERE token ='$dao' ORDER BY ID DESC";
                        $result = mysqli_query($conn, $query);
                        if(mysqli_num_rows($result)>0){
                        	 while($row= mysqli_fetch_array($result)){
                        	     //save back to db
                        	     $query = "UPDATE daos SET reddit='$refreshToken' WHERE token='$dao'";
                        	     $resp = mysqli_query($conn, $query);
                                 if($resp) {
                                	  echo "<script>alert('Reddit connected');window.location.href='https://lumosdao.io/dao/$dao';</script>";
                                 }
                        	 }
                        }
                    }
                    else { echo '<script>alert("Something went wrong");window.location.href="https://www.lumosdao.io";</script>';}
                }
                else {  
                    echo '<script>alert("Something went wrong");window.location.href="https://www.lumosdao.io";</script>';
                }
            }
            else { 
                echo '<script>alert("Something went wrong");window.location.href="https://www.lumosdao.io";</script>';
            }
            

        }
         
    }
    
    /** Save new user info
     * @params {name, bio}
    **/
     
    if($_GET['type'] == 'modify_user') {
        require('./db.php');
        $name = $_GET['name'];
        $bio = $_GET['bio'];
        $user = $_GET['user'];
       
        $res = array(); 
        $res['status'] = false;
        //check if user exists already
        $query = "SELECT * FROM users WHERE wallet ='$user' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        if(!(mysqli_num_rows($result)>0)){
        	 //insert into 
        	 $img = 'https://id.lobstr.co/'. $user . '.png';
        	 $query = "INSERT INTO users (wallet, name, bio, image)
        	        VALUES('$user', '$name', '$bio', '$img') ";
        	 $result = mysqli_query($conn, $query);
        	 if($result) {
        	     $res['status'] = true;
        	 }
        }
        else {
            //update the user info
            $query = "UPDATE users SET name='$name', bio = '$bio' WHERE wallet = '$user'";
        	$result = mysqli_query($conn, $query);
        	if($result) {
        	    $res['status'] = true;
        	}
        }
        echo json_encode($res);
    }
    /** get user info
     * @params {user}
    **/
    if($_GET['type'] == 'get_user') {
        require('./db.php');
        $user = $_GET['user'];
       
        $res = array(); 
        $res['status'] = false;
        // //check if user exists already
        // $query = "SELECT * FROM users WHERE wallet ='$user' ORDER BY ID DESC";
        // $result = mysqli_query($conn, $query);
        // if(mysqli_num_rows($result)>0){
        // 	 //insert into 
        // 	 $res['user'] = mysqli_fetch_array($result);
        // 	 $res['status'] = true;
        // }
        
        echo json_encode($res);
    }
    /** get user dao metadata info
     * @params {user}
    **/
    if($_GET['type'] == 'get_user_meta') {
        require('./db.php');
        $user = $_GET['user'];
        $res = array(); 
        $res['status'] = true;
        //get number of daos joined
        $query = "SELECT * FROM daos ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        $i=0;
        if(mysqli_num_rows($result)>0){
            $res['daos'] = array();
            while($row= mysqli_fetch_array($result)){
            	 if(strpos($row['users']. $row['issuer'], $user) > -1) {
            	     $i++;
            	 } 
            }
        }
        $res['daos'] = $i;
        //fetch proposals joined
        $query = "SELECT * FROM proposals Where creator='$user' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        $i= mysqli_num_rows($result);
        $res['proposals'] = $i;
        //fetch number of comment
        $query = "SELECT * FROM proposal_comments Where wallet='$user' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        $i= mysqli_num_rows($result);
        $res['comments'] = $i;
        //fetch number of votes
        $query = "SELECT * FROM voteinfo Where voter='$user' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        $i= mysqli_num_rows($result);
        $res['votes'] = $i;
        
        echo json_encode($res);
    }
    /** get all the dao a user has joined
     * @params {user}
    **/
    if($_GET['type'] == 'get_user_join_dao') {
        require('./db.php');
        $user = $_GET['user'];
        $res = array(); 
        $res['status'] = false;
        //check if user exists already
        $query = "SELECT * FROM daos ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>0){
            $res['daos'] = array();
            while($row= mysqli_fetch_array($result)){
            	 if(strpos($row['users']. $row['issuer'], $user) > -1) {
            	     array_push($res['daos'], $row['token']);
            	     $res['status'] = true;
            	 } 
            }
        }
        
        echo json_encode($res);
    }
    /** get all the dao a user has joined with info
     * @params {user}
    **/
    if($_GET['type'] == 'get_user_join_daometa') {
        require('./db.php');
        $user = $_GET['user'];
        $dao_id = $_GET['dao_id'];
        $res = array(); 
        $res['status'] = false;
        //check if user exists already
        $query = "SELECT * FROM daos WHERE dao_id='$dao_id' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>0){
            $res['daos'] = array();
            while($row= mysqli_fetch_array($result)){
            	 if(strpos($row['users']. $row['issuer'], $user) > -1) {
            	     array_push($res['daos'], $row);
            	     $res['status'] = true;
            	 } 
            }
        }
        
        echo json_encode($res);
    }
    /** redirect to a user image or default if none
     * @params {user}
    **/
    if($_GET['type'] == 'user_img') {
        $user = $_GET['user'];
        // Check if the image URL is valid
        $imgUrl = "https://$HOST_DOMAIN/.well-known/users/$user.png";
        $imageInfo = @getimagesize($imgUrl);
        //check if image is valid
        if ($imageInfo !== false) {
            header("Location: $imgUrl");
        }
        else{
            header("Location: https://id.lobstr.co/$user.png");
        }
        exit; // Stop further execution
    }
    /** user twitter auth
     * @params {code| refreashToken}
     **/
    if($_GET['type'] == 'user_twitter_auth') {
        require('./db.php');
        $user = $_GET['user'];
        $code = $_GET['code'];
        $url = $_GET['url'];
        $res = array(); $res['status'] = false; 
 
        //check if dao exists already
        $query = "SELECT * FROM users WHERE wallet ='$user' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        if(!(mysqli_num_rows($result)>0)){
        	 //insert into 
        	 $img = 'https://id.lobstr.co/'. $user . '.png';
        	 $query = "INSERT INTO users (twitter, twitter_url, wallet, image)
        	        VALUES('$code', '$url', $user', '$img') ";
        	 $result = mysqli_query($conn, $query);
        	 if($result) {
        	     $res['status'] = true;
        	 }
        }
        else {
            //update the user info
            $query = "UPDATE users SET twitter='$code', twitter_url='$url' WHERE wallet = '$user'";
        	$result = mysqli_query($conn, $query);
        	if($result) {
        	    $res['status'] = true;
        	}
        }
        echo json_encode($res);
    }
    /** Github auth 
     * @params {code}
    **/
    if($_GET['type'] == 'user_github_auth') {
    //check if code present
    if (isset($_GET['code'])) {
        require('./db.php');
        $code = $_GET['code'];
        $tokenURL = 'https://github.com/login/oauth/access_token';
        //config params
        $params = array(
            'client_id' => $GITHUB_CLIENT_ID,
            'client_secret' => $GITHUB_CLIENT_SECRET,
            'code' => $code,
            'redirect_uri' => 'https://lumosdao.io/.well-known/asset.php?type=user_github_auth',
        );

        //Make a POST request to exchange the authorization code for an access token
        $ch = curl_init($tokenURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $response = curl_exec($ch);
        curl_close($ch);
        // Parse the response to extract the access token
        parse_str($response, $data);
        // Check if access token is present in the response
        if (isset($data['access_token'])) {  
            // Access token obtained successfully
            $accessToken = $data['access_token'];
            $accessToken = $data['access_token'];
            $userURL = 'https://api.github.com/user';
            // Set up cURL handle
            $ch = curl_init();  
            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $userURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                //'Accept: application/vnd.github+json',
                'User-Agent:  Dropzey',
                'Authorization: Bearer ' . $accessToken,
                'X-GitHub-Api-Version: 2022-11-28'
            ));
            // Execute cURL request
            $userResponse = curl_exec($ch);
            $userInfo = json_decode($userResponse, true);
            
            if($userInfo['html_url']){
                $url = $userInfo['html_url'];
            }
            else{
                $url = "";
            }
            $user = $_GET['state'];
            $query = "SELECT * FROM users WHERE wallet ='$user' ORDER BY ID DESC";
            $result = mysqli_query($conn, $query);
            if(!(mysqli_num_rows($result)>0)){
            	 //insert into 
            	 $img = 'https://id.lobstr.co/'. $user . '.png';
            	 $query = "INSERT INTO users (github, github_url, wallet, image)
            	        VALUES('$accessToken', '$url', $user', '$img') ";
            	 $result = mysqli_query($conn, $query);
            	 if($result) {
                    echo "<script>alert('Github connected');window.location.href='https://lumosdao.io';</script>";
            	 }
            }
            else {
                //update the user info
                $query = "UPDATE users SET github='$accessToken', github_url = '$url' WHERE wallet = '$user'";
            	$result = mysqli_query($conn, $query);
            	if($result) {
            	      echo "<script>alert('Github connected');window.location.href='https://lumosdao.io';</script>";
            	}
            } 
            
        } else {
            // Handle error: Access token not received
            echo '<script>alert("Something went wrong");window.location.href = "https://' . $_SERVER['HTTP_HOST'] . '"</script>';
        }
    } else {
        // Handle error: Authorization code not received
        echo '<script>alert("Github error<br>Unable to authorize");window.location.href = "https://' . $_SERVER['HTTP_HOST'] . '"</script>';
    }
  }
   
?>