<?php
    /* THIS FILE DEALS WITH ASSET FUNCTIONS */
    require("../library/Toml.php");
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
    
    //create subdomain and upload toml
    if ($_GET['type'] == "toml") { 
        //create subdomain 
        //first check if the subdomain has been created
        $domain = strtolower($_GET['value']);
        $filename="./$domain/.well-known";
        if(!is_dir($filename)) {
            //create the subdomain
            $url = "https://$CPANEL_HOST/cpsess$CPANEL_ID/execute/SubDomain/addsubdomain?domain=$domain&rootdomain=$HOST_DOMAIN&dir=/public_html/.well-known/$domain";
            $curl = curl_init($url);
            $headers = [
                'Authorization: cpanel ' . $CPANEL_USERNAME . ':' . $CPANEL_API_TOKEN,
            ];
            // Set cURL options
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl); 
            if ($response !== false) {
                // Read the contents of the file
                $resd = $response;
                $response = json_decode($response);   
                if($response->status == 1 || strpos($resd, "already exists") !== false) {
                    mkdir($filename, 0755, true); //create the .well-known
                    //mkdir($filename . '/images', 0755, true); //create the .well-known/images
                    //create index.php to redirect to main page
                    $redir = "<?php header('Location:https://$HOST_DOMAIN'); ?>";
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
                    echo 3;
                }
            } else {
                //something went wrong
                echo 2;
                 
            }
        }
        else {
            //domain alread exists
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
        // Read the contents of the file
        $currentData = file_get_contents($filename);
        
        // Define the new "desc" value
        $newDesc = $_GET['value']; $code = $_GET['name'];
        $newValue = ""; $key = "CURRENCIES";  
        $toml = new Toml(); $aToml = $toml::parse($currentData);
       
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
            echo 1;
        }
        else {
            echo 0;
        }
       
        
         
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
                    $newValue .= '"' . $val . '"';if($i<sizeof($toml) - 1){$newValue .= ",";}
                    if($val == $addr){$flg = true;}
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
                    if($key == $addr){$val = $addr_name;$flg = true;} //modifying name
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
                $social = explode('||$$', $_GET['value']); 
                if($flg) {$newValue .= "\n\n";}
                $newValue .= "[DOCUMENTATION]\n";$toml = $aToml->$key;  
                foreach($toml as $key => $val) {
                    if($key == 'ORG_INSTAGRAM' && isset($social[0])){ $val = $social[0];}
                    if($key == 'ORG_TWITTER' && isset($social[1])){ $val = $social[1];}
                    if($key == 'ORG_TELEGRAM' && isset($social[2])){ $val = $social[2];}
                    if($key == 'ORG_REDDIT' && isset($social[3])){ $val = $social[3];}
                    if($key == 'ORG_DISCORD' && isset($social[4])){ $val = $social[4];}
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
        $url = 'https://173.212.232.150:443/wrap?code=' . $_GET['code'] . "&issuer=" . $_GET['issuer'];
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
                    IMAGETYPE_BMP
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
            $query = "INSERT INTO message (sender, receiver, msg, dao) 
    	               VALUES ('$sender', '$receiver', '$msg', '$daoId')";
    	 	$res = mysqli_query($conn, $query);
    	 	if($res){
    	 		echo 1;
    	 	}  
    	 	else {
    	 	    echo 0;
    	 	}
    }
    //to verify admin  
    if($_GET['type'] == 'isadmin') { 
         echo 1;
    }
    
?>
