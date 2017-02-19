
document.write("<?php  
require_once(dirname(__FILE__)."/../include/common.inc.php");  
if(!empty($aid)){  
    if($type=="c"){  
        $row = $db->GetOne("select count(*) as c from dede_feedback where aid='{$aid}'");  
        if($row['c']<1){  
            echo "0";  
        }else {  
            echo $row['c'];  
        }  
    }else if($type=="f"){  
        $frow = $db->GetOne("select count(*) as f from dede_member_stow where aid='{$aid}'");  
        if($frow['f']<1){  
            echo "0";  
        }else {  
            echo $frow['f'];  
        }  
    }  
}  
else{echo "0";}  
?>"); 