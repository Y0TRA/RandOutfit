<?   
session_start(); 
?>
    
<?
    



require_once "config.php";
$action = utf8_encode('insert into favorites (name, user_id) values(\'' . $_POST['name'] . '\', ' . $_SESSION['user'] . ');');


try {
    $db = new PDO("pgsql:host=".dbconfig::$host.";dbname=".dbconfig::$dbname, dbconfig::$dbuser, dbconfig::$dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $res = $db->query($action);

    $res = $db->query('select max(id) from favorites');
    $id = ($res->fetch())[0];

    foreach($_SESSION['items'] as $item){
        $tags_actions = 'insert into favs_outfits (fav_name, item) values(' . $id . ',' . $item . ')';
        $res = $db->query($tags_actions);
    
    }


    header("Location: index.php");
    exit;
} catch (PDOException $e) {
   
    echo "<pre>" . $e . "</pre>";
}


?>