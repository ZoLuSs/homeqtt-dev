<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>HomeQTT - First launch</title>
</head>
<body>
    <div class="container" style="margin-top: 4em;"> 
        <img src="img/logo-icon.png" alt="logo" class="logo high">
        <h1>HomeQTT - First launch</h1>
    </div>
    <div class="container" id="main-container" style="">
        <?php
            if (file_exists('../homeqtt.db')) {
                $db = new SQLite3('../homeqtt.db');
                $mqttQ = $db->query("SELECT name, value FROM config WHERE name LIKE 'mqtt%'");
                $mqtt = $mqttQ->fetchArray();
                if($mqtt){
                    $userQ = $db->query("SELECT id FROM user");
                    $user = $userQ->fetchArray();
                    if($user){$form=false;$form_url="/config/check";?>
                        <h2 id="title">Install done !</h2>
                    <a class="button wide" id="submit">Check everythings and launch</a>
                    <?php }else{
                        $form=true;$form_url="/config/create-user";$goto="/firstlaunch";?>
                        <h2>Create first user: </h2>
                        <form id="form">
                              <div class="input-container">
                                <label for="">Username </label>
                                <input type="text" name="username">
                            </div>
                            <div class="input-container">
                                <label for="">Password </label>
                                <input type="password" name="password">
                            </div>
                        </form>
                        <a class="button wide" id="submit">Save</a>
                    <?php
                    }
                }
                else{
                    $form=true;$form_url="/config/create-mqtt";$goto="/firstlaunch";?>
                <h2>Set MQTT config: </h2>
                <form id="form">
                    <div class="input-container row">
                        <div class="input-container-2">
                            <label for="">Protocole </label>
                            <select name="protocol">
                                <option value="mqtt" selected>mqtt://</option>
                                <option value="ws">ws://</option>
                            </select>
                        </div>
                        <div class="input-container-2 center">
                            <label for="">TLS </label>
                            <input type="checkbox" name="tls">
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="">Host</label>
                        <input type="text" name="host">
                    </div>
                    <div class="input-container">
                        <label for="">Port</label>
                        <input type="number" name="port">
                    </div>
                    <div class="input-container">
                        <label for="">Username </label>
                        <input type="text" name="username">
                    </div>
                    <div class="input-container">
                        <label for="">Password </label>
                        <input type="password" name="password">
                    </div>
                </form>
                <a class="button wide" id="submit">Save</a>
                <?php
                }
            } 
            else { 
                if(isset($_GET["form"]) && !empty($_GET["form"])){
                    if($_GET["form"] == "restore-backup"){?>
                        <h2>Upload homeqtt.db file:</h2>
                        <form action="config/upload_db.php" method="post" id="form">
                            <input type="file" name="db" id="db"><br>
                            <a class="button wide" onclick="document.getElementById('form').submit();">Upload</a>
                        </form>
                        <a class="button wide" href="/firstlaunch">Back</a>
                    <?php
                    }
                    else if($_GET["form"] == "create-db"){
                        $form=false;$form_url="/config/create-db";$goto="/firstlaunch";?>                        
                        <h2 class="text-center">You are going to create the database.<br>If you already have a database, it will be deleted !</h2>
                        <a class="button wide" id="submit">Confirm creation</a>
                        <a class="button wide" href="/firstlaunch">Back</a>
                    <?php
                    }
                }
                else{ ?>
                    <h2 id="title">No database detected: </h2>
                    <a class="button wide" href="?form=restore-backup">Restore backup</a>
                    <a class="button wide" href="?form=create-db">Create the database</a>
                <?php
                }
            }//end no database
        ?>
    </div>
    <div class="modal" id="modal">
        <div class="modal-container">
            <span class="loader"></span>
        </div>
    </div>
</body>
<?php if(isset($form_url) && !empty($form_url)){ ?>
<script>
document.getElementById("submit").addEventListener("click", sendForm);
loading = document.getElementById("modal");
function sendForm() {
    loading.style.display = "flex";
    <?php if(isset($form) && $form){ ?>
        var form = document.getElementById("form");
        var data = new FormData(form);
    <?php } ?>
    fetch("<?php echo $form_url;?>", {
    <?php if(isset($form) && $form){ ?>
        method: "POST",
        body: data
    <?php }else{ ?>
        method: "POST"
    <?php } ?>
    }) .then(response => {
        if (response.status >= 200 && response.status <= 299) {
        <?php if(isset($goto) && !empty($goto)){ ?>
            window.location.href = "<?php echo $goto; ?>";
        <?php } else {?>
            loading.style.display = "none";
        <?php } ?>
        } else {
            loading.style.display = "none";
        }
        return response.json();
    }).then(result=>{console.log(result);});
}
</script>
<?php } ?>
</html>