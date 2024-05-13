<?php

    /* UTILS FUNCTIONS */
    
    //updating the socials toml values
    function modifySocial($domain, $value) {  
        $domain = strtolower($domain);
        $filename="./$domain/.well-known/stellar.toml";
        // Read the contents of the file
        $currentData = file_get_contents($filename);
        
        // Define the new "desc" value
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
                $social = json_decode($value, true); 
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
            return 1;
        }
        else {
            return 0;
        }
    } 
      
?>