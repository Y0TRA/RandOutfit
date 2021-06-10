<?   
session_start(); 
?>

<?

$fileTmpName = $_FILES['file_img']['tmp_name'];

$image = $_FILES['file_img'];
$image = getimagesize($fileTmpName);
// Сгенерируем новое имя файла на основе MD5-хеша
$name = md5_file($fileTmpName);
 
// Сгенерируем расширение файла на основе типа картинки
$extension = image_type_to_extension($image[2]);
 
// Сократим .jpeg до .jpg
$format = str_replace('jpeg', 'jpg', $extension);
 
// Переместим картинку с новым именем и расширением в папку /upload
if (!move_uploaded_file($fileTmpName, __DIR__ . '/upload/' . $name . $format)) {
  die('При записи изображения на диск произошла ошибка.');
}
 



require_once "config.php";
$action = utf8_encode('insert into wardrobe (name, file, owner) values(\'' . $_POST['name'] . '\',  \'' . $name . $format . '\',' . $_SESSION['user'] . ');');


try {
    $db = new PDO("pgsql:host=".dbconfig::$host.";dbname=".dbconfig::$dbname, dbconfig::$dbuser, dbconfig::$dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $res = $db->query($action);

    $res = $db->query('select max(id) from wardrobe');
    $id = ($res->fetch())[0];

    foreach($_POST['tags'] as $tag){
        $tags_actions = 'insert into items_tags (item, tag) values(' . $id . ',' . ($tag+1) . ')';
        $res = $db->query($tags_actions);
    
    }


    header("Location: index.php");
    exit;
} catch (PDOException $e) {
   
    echo "<pre>" . $e . "</pre>";
}

echo 'Картинка успешно загружена!';


?>