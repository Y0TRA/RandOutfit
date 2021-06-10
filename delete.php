<?   
session_start(); 
?>
    
<?
    



require_once "config.php";
$action = 'delete from favs_outfits where fav_name = ' . $_POST['outfit_id'] . '';
$action2 = utf8_encode('delete from favorites where id = ' . $_POST['outfit_id'] . '');
echo $action;


try {
    $db = new PDO("pgsql:host=".dbconfig::$host.";dbname=".dbconfig::$dbname, dbconfig::$dbuser, dbconfig::$dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $res = $db->query($action);
    $res = $db->query($action2);

   

    header("Location: favs.php");
    exit;
} catch (PDOException $e) {
   
    echo "<pre>" . $e . "</pre>";
}


?>