<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>HomeQTT - First launch</title>
</head>
<body>
    <div class="container" style="margin-top: 5em;"> 
        <img src="img/logo-icon.png" alt="logo" class="logo high">
        <h1>HomeQTT - First launch</h1>
    </div>
    <div class="container">
        <?php
        if(isset($_GET["form"])){
            if($_GET["form"] == "restore-backup"){?>
            <h2 id="title">Restore backup: </h2>
            <h3>Upload homeqtt.db file:</h3>
            <form action="config/upload_db.php" method="post" id="form">
                <input type="file" name="db" id="db"><br>
                <a class="button full-width" onclick="document.getElementById('form').submit();">Upload</a>
                
            </form>
            <a class="button full-width" href="/firstlaunch">Back</a>
            <?php
            }
        }
        else{
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
    
            } else { ?>
            <h2 id="title">No database detected: </h2>
    
    
            <a class="button full-width" href="?form=restore-backup">Restore backup</a>
            
            <a class="button full-width" id="create-db-btn">Create the database</a>
    
    
            <div id="create-db" style="display: none;">
            <form action="" method="post">
                    <label for="">Test: </label><input type="text" name="" id="">
                    <label for="">Test: </label><input type="text" name="" id="">
                    <label for="">Test: </label><input type="text" name="" id="">
                </form>
            </div>
            <?php
            } //end No database
            
        }//end if $_GET["form"]
        ?>








    </div>
</body>
</html>