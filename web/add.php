<?php
require_once('config/session.php');
require_once("./lang/lang.php");
require_once(__DIR__ . '/config/session.php');
require_once(__DIR__ . "/card.php");
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>HomeQTT - <?php if(isset($_GET['type'])){echo ucfirst(add["add".$_GET['type']]);}else{echo ucfirst(general["add"]);}?></title>
    <style type="text/css" media="screen">
</style>
</head>
<body>
    <?php require_once("header.php");?>
    <div class="container">
        <?php
            if (isset($_GET['type'])) {
                if($_GET['type'] == "room"){
                    $form=true;$form_url="/config/room/add";$goto="/";?>
                    <h2><?php echo ucfirst(add["addroom"]);?>: </h2>
                    <form id="form">
                        <div class="input-container">
                            <label for=""><?php echo ucfirst(general["name"]);?></label>
                            <input type="text" name="name" placeholder="Office">
                        </div>
                    </form>
                    <a class="button wide" id="submit"><?php echo ucfirst(general["add"]);?></a>
                    <a class="button wide" href="/add"><?php echo ucfirst(general['back']);?></a>
                <?php }
                if($_GET['type'] == "accessory"){
                    $roomQ = $db->query('SELECT room_id, room_name FROM rooms ORDER BY "order" ASC');
                    $count = 0;
                    while ($row = $roomQ->fetchArray()) {
                        $count++;
                    }
                    if ($count > 0) {
                        if(!isset($_POST['object'])){ ?>
                            <h2><?php echo ucfirst(add["choosetypeof"]);?>: </h2>
                            <form method="post" class="full-width">
                                <div class="cards-container full-width">
                                    <?php 
                                    echo form_card_button(ucfirst(accessory["light"]),"light","lightbulb");
                                    echo form_card_button(ucfirst(accessory["weather-station"]),"weather-station","weather-station");
                                    echo form_card_button(ucfirst(accessory["temperature"]),"temperature","temperature");
                                    echo form_card_button(ucfirst(accessory["humidity"]),"humidity","humidity");
                                    echo form_card_button(ucfirst(accessory["energy"]),"energy","energy");                            
                                    ?>
                                </div>
                            </form>
                            <a class="button wide" href="/add"><?php echo ucfirst(general['back']);?></a>
                        <?php 
                        }
                        if($_GET['type'] == "accessory" && isset($_POST['object']) && !is_null($_POST['object'])){ ?>
                            <h2><?php echo ucfirst(add["add".$_POST['object']]);?>: </h2>
                            <form id="form">
                                <div class="input-container">
                                    <label for=""><?php echo ucfirst(general["name"]);?></label>
                                    <input type="text" name="name" placeholder="Office">
                                </div>
                                <div class="input-container">
                                    <label for=""><?php echo ucfirst(add["chooseroom"]);?></label>
                                    <select name="room" id="">
                                        <?php
                                         while ($data = $roomQ->fetchArray()) { 
                                            echo "<option value='".$data['room_id']."'>".$data['room_name']."</option>";
                                         }
                                        ?>
                                    </select>
                                </div>
                            <?php if($_POST['object'] == "light"){
                                $form=true;$form_url="/config/light/add";$goto="/";$needAce=true;
                                ?>
                                <div class="input-container">
                                    <label for=""><?php echo ucfirst(add["typeOfLight"]);?></label>
                                    <select name="type" id="">
                                        <option value='simple'>Simple - ON / OFF</option>
                                        <option value='dimmablePercentage' disabled>Dimmable - 0% / 100%</option>
                                        <option value='cct' disabled>CCT - Cold / Warm / Dimmable</option>
                                        <option value='rgbHue' disabled>RGB - Hue / Sat / CT</option>
                                        <option value='rgbDimmable' disabled>RGBW - Hue / Sat / CT / Dimmable</option>
                                        <option value='rgbcct' disabled>RGBCCT - Hue / Sat / Cold / Warm / Dimmable</option>
                                    </select>
                                </div>
                                <div class="input-container">
                                    <label for=""><?php echo ucfirst(add["setontopic"]);?></label>
                                    <input type="text" name="setOn" placeholder="light/room/seton">
                                </div>
                                <div class="input-container">
                                    <label for=""><?php echo ucfirst(add["getontopic"]);?></label>
                                    <input type="text" name="getOn" placeholder="light/room/geton">
                                </div>
                                <div class="input-container aceEditor-container">
                                    <label for="">Payload formatter (si nécéssaire)</label>
                                    <div id="editor"></div>
                                </div>
                                <div class="input-container">
                                    <label for=""><?php echo ucfirst(add["payloadon"]);?></label>
                                    <input type="text" name="payloadOn" placeholder="ON">
                                </div>
                                <div class="input-container">
                                    <label for=""><?php echo ucfirst(add["payloadoff"]);?></label>
                                    <input type="text" name="payloadOff" placeholder="OFF">
                                </div>
                            <?php }
                                if($_POST['object'] == "weather-station"){

                                } ?>
                            </form>
                            <a class="button wide" id="submit"><?php echo ucfirst(general["add"]);?></a>
                            <a class="button wide" href="/add?type=accessory"><?php echo ucfirst(general['back']);?></a>
                            <?php
                        }
                    }
                    else{ ?>
                        <div class="segment">
                        <h1><?php echo ucfirst(general['noroomcreated']);?></h1>
                        <div class="cards-container">
                            <h2><?php echo ucfirst(add['roomneeded']);?></h2>
                        </div>
                        <a class="button wide" href="/add"><?php echo ucfirst(general['back']);?></a>
                    </div>
                    <?php 
                    }
                }

            }
            else{ ?>
                <h2><?php echo ucfirst(add["whatadd"]);?></h2>
                    <a class="button wide" href="?type=room"><?php echo ucfirst(add["addroom"]);?></a>
                    <a class="button wide" href="?type=accessory"><?php echo ucfirst(add["addaccessory"]);?></a>
            <?php } /*
                $db = new SQLite3('../homeqtt.db');
                $mqttQ = $db->query("SELECT name, value FROM config WHERE name LIKE 'mqtt%'");
                $mqtt = $mqttQ->fetchArray();
                if($mqtt){
                    $userQ = $db->query("SELECT id FROM user");
                    $user = $userQ->fetchArray();
                    $status = exec("sudo systemctl is-active homeqtt");
                    if($user && $status != "active"){$form=false;$form_url="/config/check";?>
                        <h2>Setup is done !</h2>
                    <a class="button wide" id="submit">Check everythings and launch</a>
                    <?php }
                    else if($user && $status == "active"){?>
                        <h2>HomeQTT is setup and running !</h2>
                        <h2>Nothing to do here.</h2>
                        <a class="button wide" href="/">Go home</a>
                    <?php }
                    else{
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
                            <label for="">Use TLS</label>
                            <input type="checkbox" name="tls">
                        </div>

                        <div class="input-container-2 center">
                            <label for="">Verify Cert</label>
                            <input type="checkbox" name="check_cert">
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
                            <input type="file" name="db"><br>
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
                    <h2>No database detected: </h2>
                    <a class="button wide" href="?form=restore-backup">Restore backup</a>
                    <a class="button wide" href="?form=create-db">Create the database</a>
                <?php
                }
            }//end no database
       */ ?>
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
        if(document.getElementById("editor")){
            var editorValue = editor.getValue();
            if(editorValue.length > 0){
                data.append("payloadFormatter", editorValue);
            }
        }        
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
<?php } 
if(isset($needAce)){
    if($needAce){?>

<script src="/js/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    editor.setOptions({
        placeholder: `//Topic message is 'msg'
if(msg.switch.output){
    data = "ON";
}
else{
    data = "OFF";
}
return data;`});
</script>
<?php }
}?>
<script src="/js/index.js"></script>
</html>