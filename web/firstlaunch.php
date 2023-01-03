<?php 
// First launch
// Check if everything is ready for launch and if not ask for input
/*class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('mysqlitedb.db');
    }
}

$db = new MyDB();*/
//require_once('config.php');
if (file_exists('../homeqtt.db')) {
    $db = new SQLite3('../homeqtt.db');
    

    $result = $db->query("SELECT EXISTS (SELECT name FROM sqlite_master WHERE type='table' AND name='users');");
    $data = $result->fetchArray();
    if($data[0] == 1){
        echo "Table light exist";
    }
    else{
        echo "Database is missing light table. If it's the first launch, please delete homeqtt.db file and reload this page";
    }

} else {
    echo "Do you want to create or import database ?";
}
?>