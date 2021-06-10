<?
    class dbconfig
    {
        public static $dbuser = "yotra";
        public static $dbpass = "shawermos123";
        public static $host = "localhost";
        public static $dbname = "randoutfit";
    }

    $tables = [
        "hashtags" => array(
            "id", 
            "tag"
        ),
        "wardrobe" => array(
            "id", 
            "name", 
            "file", 
            "owner"
        ),
        "items_tags" => array (
            "id",
            "item",
            "tag"
        ), 

        "auth" => array(
            "id", 
            "login", 
            "password"
        )
    ];
?>

