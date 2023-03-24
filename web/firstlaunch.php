<?php require_once("./lang/lang.php");?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>HomeQTT - <?php echo ucfirst(firstlaunch["firstlaunch"]);?></title>
</head>
<body>
    <div class="container" style="margin-top: 4em;"> 
        <img src="img/logo-icon.png" alt="logo" class="logo high">
        <h1>HomeQTT - <?php echo ucfirst(firstlaunch["firstlaunch"]);?></h1>
    </div>
    <div class="container">
        <?php
            if (file_exists('../homeqtt.db')) {
                $db = new SQLite3('../homeqtt.db');
                $mqttQ = $db->query("SELECT name, value FROM config WHERE name LIKE 'mqtt%'");
                $mqtt = $mqttQ->fetchArray();
                if($mqtt){
                    $userQ = $db->query("SELECT id FROM user");
                    $user = $userQ->fetchArray();
                    if($user){
                        $houseQ = $db->query("SELECT name, value FROM config WHERE name LIKE 'house_%'");
                        $house = $houseQ->fetchArray();
                        $status = exec("sudo systemctl is-active homeqtt");
                        if($house && $status != "active"){$form=false;$form_url="/config/check";$goto="/firstlaunch"?>
                            <h2><?php echo firstlaunch["setupdone"];?></h2>
                        <a class="button wide" id="submit"><?php echo firstlaunch["checkandlaunch"];?></a>
                        <?php }
                        else if($house && $status == "active"){?>
                            <h2><?php echo firstlaunch["setupandrunning"];?></h2>
                            <h2><?php echo firstlaunch["nothinghere"];?></h2>
                            <a class="button wide" href="/"><?php echo general["gohome"];?></a>
                        <?php }
                        else{
                            $form=true;$form_url="/config/create-house";$goto="/firstlaunch";?>
                            <h2><?php echo ucfirst(firstlaunch['createhouse']);?> : </h2>
                            <form id="form">
                                <div class="input-container">
                                    <label for=""><?php echo ucfirst(general['housename']);?></label>
                                    <input type="text" name="housename">
                                </div>
                            </form>
                            <a class="button wide" id="submit"><?php echo ucfirst(general['save']);?></a>
                        <?php
                        }
                    }
                    else{
                        $form=true;$form_url="/config/create-user";$goto="/firstlaunch";?>
                        <h2><?php echo ucfirst(firstlaunch['createfirstuser']);?> : </h2>
                        <form id="form">
                            <div class="input-container">
                                <label for=""><?php echo ucfirst(general['username']);?></label>
                                <input type="text" name="username">
                            </div>
                            <div class="input-container">
                                <label for=""><?php echo ucfirst(general['password']);?></label>
                                <input type="password" name="password">
                            </div>
                        </form>
                        <a class="button wide" id="submit"><?php echo ucfirst(general['save']);?></a>
                    <?php
                    }
                }
                else{
                    $form=true;$form_url="/config/create-mqtt";$goto="/firstlaunch";?>
                <h2><?php echo firstlaunch["setmqtt"];?>: </h2>
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
                            <label for=""><?php echo firstlaunch["useTLS"];?></label>
                            <input type="checkbox" name="tls">
                        </div>

                        <div class="input-container-2 center">
                            <label for=""><?php echo firstlaunch["verifycert"];?></label>
                            <input type="checkbox" name="check_cert">
                        </div>
                    </div>
                    <div class="input-container">
                        <label for="">Broker</label>
                        <input type="text" name="broker">
                    </div>
                    <div class="input-container">
                        <label for="">Port</label>
                        <input type="number" name="port">
                    </div>
                    <div class="input-container">
                        <label for=""><?php echo ucfirst(general['username']);?></label>
                        <input type="text" name="username">
                    </div>
                    <div class="input-container">
                        <label for=""><?php echo ucfirst(general['password']);?></label>
                        <input type="password" name="password">
                    </div>
                </form>
                <a class="button wide" id="submit"><?php echo ucfirst(general['save']);?></a>
                <?php
                }
            } 
            else { 
                if(isset($_GET["form"]) && !empty($_GET["form"])){
                    if($_GET["form"] == "restore-backup"){?>
                        <h2><?php echo firstlaunch['uploadfile'];?>:</h2>
                        <form action="config/upload_db.php" method="post" id="form">
                            <input type="file" name="db"><br>
                            <a class="button wide" onclick="document.getElementById('form').submit();"><?php echo ucfirst(general['upload']);?></a>
                        </form>
                        <a class="button wide" href="/firstlaunch"><?php echo ucfirst(general['back']);?></a>
                    <?php
                    }
                    else if($_GET["form"] == "create-db"){
                        $form=false;$form_url="/config/create-db";$goto="/firstlaunch";?>                        
                        <h2 class="text-center"><?php echo firstlaunch["createDbString1"];?><br><?php echo firstlaunch["createDbString2"];?></h2>
                        <a class="button wide" id="submit"><?php echo firstlaunch["confirmCreate"];?></a>
                        <a class="button wide" href="/firstlaunch"><?php echo ucfirst(general['back']);?></a>
                    <?php
                    }
                }
                else{ ?>
                    <h2><?php echo firstlaunch["noDbFind"];?>: </h2>
                    <a class="button wide" href="?form=restore-backup"><?php echo firstlaunch["restorebckp"];?></a>
                    <a class="button wide" href="?form=create-db"><?php echo firstlaunch["createDb"];?></a>
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