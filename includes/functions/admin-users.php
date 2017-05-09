<?php
function access_dashboard()
{
    echo '<script>window.location="./index.php"</script>';
}


function Connected()
{

    // var_dump($_SERVER['QUERY_STRING']);//REQUEST_URI

    //             die();


    if(!isset($_SESSION['admin']))
    {
        if((isset($_GET['Module']) && $_GET['Module']!= 'Login') || !isset($_GET['Module']))
        {
            //ob_start();
            echo('<script>window.location="?module=Login&redirect='. $_SERVER['QUERY_STRING'] .'";</script>');
        }
    }else{
        return true;
    }
}

function Liste($table,$fieldid,$field,$where,$selected)
{
    $DB = Database::getInstance();
    //$Table
    //$Fieldid
    //$Field
    //$Where
    $sql = "select $fieldid,$field from "._DB_PREFIX_."$table where $where";
//    echo '<option>'.$sql.'</option>';
    $sth = $DB->pdo->query($sql);
    $sth->execute();
    while($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        if(isset($selected) && is_numeric($selected))
        {
            if($row[$fieldid] == $selected)
            {
                echo '<option value="'.$row[$fieldid].'" selected="selected">'.stripslashes($row[$field]).'</option>';
            }else{
                echo '<option value="'.$row[$fieldid].'">'.stripslashes($row[$field]).'</option>';
            }
        }else{
            echo '<option value="'.$row[$fieldid].'">'.stripslashes($row[$field]).'</option>';
        }

    }
    echo 'ok';
}
function user(){
    echo $_SESSION['admin'];
}
function confirm_login()
{
    if(!isset($_SESSION['user_id']))
    {
        redirect_to("login.php");
    }
}
?>