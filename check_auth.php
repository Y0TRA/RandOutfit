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


<?php

        require_once "config.php";
        try {
            $db = new PDO("pgsql:host=".dbconfig::$host.";dbname=".dbconfig::$dbname, dbconfig::$dbuser, dbconfig::$dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            
        } catch (\Throwable $th) {
            echo "<pre>" . $th . "</pre>";
        }
            if (isset($_POST["type"]["all"])) {
                $res = $db->query("select password from auth where login='" . $_POST['login'] . "'");
                $pass = ($res->fetch())[0];
                if (md5($_POST['password']) == $pass){
                    $res = $db->query("select id from auth where login='" . $_POST['login'] . "' and password='" . $pass . "'");
                    $id = ($res->fetch())[0];
                    
                    $_SESSION['user'] = $id;

                    header("Location: index.php"); 
                    exit();
                    
                }

                echo "Неверные данные";
                header("Location: auth.php"); 
                exit();
            }
            else if (isset($_POST["type"]["specific"])) {
                try{ $res = $db->query("insert into auth (login, password) values('" . $_POST['login'] . "', '" . md5($_POST['password']) .  "')");
                } catch (\Throwable $th) {
                    echo "<pre>" . $th . "</pre>";
                }

                echo  ($res->fetch());
                 try {
                     echo $_POST['login'];
                     echo md5($_POST['password']);
                    $res = $db->query("select id from auth where login='" . $_POST['login'] . "' and password='" . md5($_POST['password']) . "'");
                 } catch (\Throwable $th) {
                    echo "<pre>" . $th . "</pre>";
                }
                 
                 $id = ($res->fetch())[0];
                
                 $_SESSION['user'] = $id;
                 header("Location: index.php"); 
                 exit(); 
            }


?>

</body>

</html>