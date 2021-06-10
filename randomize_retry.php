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
                            <a class="nav-link" href="#">Избранное</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="add.php">Добавить одежду</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="get_outfit.php">Подобрать комплект</a>
                        </li>
                        <li class="nav-item">
							<a class="nav-link" href="out.php">Выйти из аккаунта</a>
						</li>
                    </ul>

                </div>
            </div>
        </nav>

        <form method="POST" action="add_to_favs.php" enctype="multipart/form-data">
        <div class="row row-cols-1 row-cols-md-3 g-4">

           
            <?
        
        $_SESSION['items'] = array();
        $tags = array();


        
        require_once "config.php";
        try {

        

            $tags_for_session = $_SESSION['tags'];
            $tags = array();


            $_SESSION['items'] = array();

            foreach($tags_for_session as $tag){
                if($tag != 0 and $tag !=1 and $tag !=2 and $tag !=3) $tags[] = $tag;

            }

           
            $db = new PDO("pgsql:host=".dbconfig::$host.";dbname=".dbconfig::$dbname, dbconfig::$dbuser, dbconfig::$dbpass);
           
            if (in_array("0", $tags_for_session)){
                $outfit_id = array();
                $outfit_name = array();
                $outfit_file = array();
                
               
                $action = "select id, name, file from wardrobe where owner=" . $_SESSION['user'] ." and id in (select item from items_tags where tag=1)";
                foreach($tags as $tag){
                    $action = $action . " and id in (select item from items_tags where tag=" . ($tag+1) . ")";
                  
                }
                $res = $db->query($action);
                while ($item = $res->fetch()){
                    $outfit_id[] = $item[0];
                    $outfit_name[] = $item[1];
                    $outfit_file[] = $item[2];
                }
                $value = array_rand($outfit_name, 1);
                $_SESSION['items'][] = $outfit_id[$value];
            

                echo "<div class=\"card\" style=\"width: 18rem;\">
                <img src=\"upload/" . $outfit_file[$value] . "\" class=\"card-img-top\" alt=\"...\" >
                <div class=\"card-body\">
                    <p class=\"card-text\">" . $outfit_name[$value] .  "</p>
                </div>
                
            </div>";
                
            }
            if (in_array("1", $tags_for_session)){
                $outfit_id = array();
                $outfit_name = array();
                $outfit_file = array();
                
             
                $action = "select id, name, file from wardrobe where owner=" . $_SESSION['user'] ." and id in (select item from items_tags where tag=2)";
                foreach($tags as $tag){
                    $action = $action . " and id in (select item from items_tags where tag=" . ($tag+1) . ")";
                  
                }
               
                $res = $db->query($action);
                while ($item = $res->fetch()){
                    $outfit_id[] = $item[0];
                    $outfit_name[] = $item[1];
                    $outfit_file[] = $item[2];
                }
                $value = array_rand($outfit_name, 1);
                $_SESSION['items'][] = $outfit_id[$value];
                

                echo "<div class=\"card\" style=\"width: 18rem;\">
                <img src=\"upload/" . $outfit_file[$value] . "\" class=\"card-img-top\" alt=\"...\">
                <div class=\"card-body\">
                    <p class=\"card-text\">" . $outfit_name[$value]  . "</p>
                </div>
            </div>";
           
                
            }
            if (in_array("2", $tags_for_session)){
                $outfit_id = array();
                $outfit_name = array();
                $outfit_file = array();
                
                $action = "select id, name, file from wardrobe where owner=" . $_SESSION['user'] ." and id in (select item from items_tags where tag=3)";
                foreach($tags as $tag){
                    $action = $action . " and id in (select item from items_tags where tag=" . ($tag+1) . ")";
                  
                }
                $res = $db->query($action);
                while ($item = $res->fetch()){
                    $outfit_id[] = $item[0];
                    $outfit_name[] = $item[1];
                    $outfit_file[] = $item[2];
                }
                $value = array_rand($outfit_name, 1);
                $_SESSION['items'][] = $outfit_id[$value];

                echo "<div class=\"card\" style=\"width: 18rem;\">
                <img src=\"upload/" . $outfit_file[$value] . "\" class=\"card-img-top\" alt=\"...\">
                <div class=\"card-body\">
                    <p class=\"card-text\">" . $outfit_name[$value] . "</p>
                </div>
            </div>";
                
            }
            if (in_array("3", $tags_for_session)){
                $outfit_id = array();
                $outfit_name = array();
                $outfit_file = array();
                
                $action = "select id, name, file from wardrobe where  owner=" . $_SESSION['user'] ." and id in (select item from items_tags where tag=4)";
                foreach($tags as $tag){
                    $action = $action . " and id in (select item from items_tags where tag=" . ($tag+1) . ")";
                  
                }
                $res = $db->query($action);
                while ($item = $res->fetch()){
                    $outfit_id[] = $item[0];
                    $outfit_name[] = $item[1];
                    $outfit_file[] = $item[2];
                }
                $value = array_rand($outfit_name, 1);
                $_SESSION['items'][] = $outfit_id[$value];

                echo "<div class=\"card\" style=\"width: 18rem;\">
                <img src=\"upload/" . $outfit_file[$value] . "\" class=\"card-img-top\" alt=\"...\">
                <div class=\"card-body\">
                    <p class=\"card-text\">" . $outfit_name[$value] . "</p>
                </div>
            </div>";
                
            }

        } catch (\Throwable $th) {
            echo "<pre>" . $th . "</pre>";
        }

       

      
?>
        </div>
        <div class="col-auto">
                    <label class="visually-hidden" for="autoSizingInput">Название комплекта для добавления в избранное</label>
                    <input type="text" class="form-control" id="autoSizingInput" name = "name" placeholder="Название">
                </div>
        <div class="mb-3">
                <input type="hidden" name="" value="<? $_POST['tags'] ?>">
                <button type="submit" class="btn btn-primary">Добавить в избранное</button>
            </div>
            </form>
        <form method="POST" action="randomize_retry.php" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="hidden" name="tags" value="<? $tags ?>">
                <button type="submit" class="btn btn-primary">Подобрать другое по тем же хештегам</button>
            </div>
        </form>



</body>

</html>