<?php
    /* THIS FILE DEALS WITH ASSET FUNCTIONS */
    require("../library/Toml.php");
    require("./config.php");
    
    
   
    //uploading of asset image
    if ($_SERVER["REQUEST_METHOD"] === "POST" && $_GET['type'] == "upload") {  
        if (isset($_FILES["file"])) {
            $file = $_FILES["file"];
            $uploadDirectory = 'images/'; // Define your upload directory
    
            // Check if the file is an image
            $imageType = exif_imagetype($file["tmp_name"]);
            $allowedTypes = [
                IMAGETYPE_JPEG,
                IMAGETYPE_PNG,
                IMAGETYPE_GIF,
            ];
    
            if (!in_array($imageType, $allowedTypes)) {
                echo "Invalid image file format. Please upload a JPEG, PNG, or GIF image.";
            } else {
                if (move_uploaded_file($file["tmp_name"], $uploadDirectory . $_GET["name"])) {
                    echo "1";
                } else {
                    echo "0";
                }
            }
        } else {
            echo "0";
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
    
    //check if subdomain exists
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
?>
