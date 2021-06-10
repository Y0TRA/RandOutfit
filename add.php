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
                            <a class="nav-link" href="favs.php">Избранное</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="add.php">Добавить одежду</a>
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
        <?
        require_once "config.php";
        try {
            $db = new PDO("pgsql:host=".dbconfig::$host.";dbname=".dbconfig::$dbname, dbconfig::$dbuser, dbconfig::$dbpass);
            $res = $db->query("SELECT tag from hashtags");
        } catch (\Throwable $th) {
            echo "<pre>" . $th . "</pre>";
        }
?>

        <form method="POST" action="upload.php" enctype="multipart/form-data">

            <div class="d-flex flex-column bd-highlight mb-3">
                <div class="input-group mb-3 p-2 bd-highlight">
                    <input type="file" class="form-control" id="inputGroupFile02" name="file_img">
                    <label class="input-group-text" for="inputGroupFile02">Загрузить</label>
                </div>
                <div class="col-auto">
                    <label class="visually-hidden" for="autoSizingInput">Название</label>
                    <input type="text" class="form-control" id="autoSizingInput" name = "name" laceholder="Название">
                </div>
                <div class="p-2 bd-highlight">Отметьте хештеги</div>
            </div>
            <div class="btn-group form-group mb-3" role="group" aria-label="Basic checkbox toggle button group">

                <?
            $i = 0;
        while ($row = $res->fetch()){
        
            
            echo "<input type=\"checkbox\" class=\"btn-check\" name=\"tags[]\"value=\"" . $i . "\" id=\"btncheck" . $i . "\" autocomplete=\"off\">
                    <label class=\"btn btn-outline-primary\" for=\"btncheck" . $i . "\">" . $row[0] . "</label>";
            $i = $i + 1;
        
    }
    
            ?>


            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
        </form>
</body>

</html>