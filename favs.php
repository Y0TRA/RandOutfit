<?   
session_start(); 
?>

<!doctype html>
<html lang="ru">

<head>
    <!-- Обязательные метатеги -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>RandOutfit</title>
</head>

<body>


    <!-- Дополнительный JavaScript; выберите один из двух! -->

    <!-- Вариант 1: Bootstrap в связке с Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary ">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Гардероб</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="favs.php">Избранное</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"  href="add.php">Добавить одежду</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="get_outfit.php">Подобрать комплект</a>
                        </li>
                        <li class="nav-item">
							<a class="nav-link" href="out.php">Выйти из аккаунта</a>
						</li>
                    </ul>

                </div>
            </div>
        </nav>


        <div class="row row-cols-1 row-cols-md-3 g-4">

            <?

require_once "config.php";
$action = utf8_encode('select id, name from favorites where user_id=' . $_SESSION['user']);
try {
    $db = new PDO("pgsql:host=".dbconfig::$host.";dbname=".dbconfig::$dbname, dbconfig::$dbuser, dbconfig::$dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $res = $db->query($action);
   
} catch (PDOException $e) {
   
    echo "<pre>" . $e . "</pre>";
}


while ($outfit = $res->fetch()){
    $items_in_outfit = $db->query("select name, file from wardrobe where id in (select item from favs_outfits where fav_name= " . $outfit[0] . ")");

    
?>
        <form method="POST" action="delete.php" enctype="multipart/form-data">
        <h3><? echo $outfit[1] ?></h3>
        <div class="row">
        <div class="col">
                <input type="hidden" name="outfit_id" value="<? echo $outfit[0]?>">
                <button type="submit" class="btn btn-primary">Удалить</button>
         </div>
<?

     while ($item = $items_in_outfit->fetch()) {

?>


            <div class="card col" style="width: 18rem;">
                <img src="upload/<?php echo $item[1];   ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text"><?php echo $item[0]?></p>
                </div>
            </div>

            <?

}
echo "</form>";

}

?>
       

</body>

</html>