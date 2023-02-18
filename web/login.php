<?php
session_start();
if($_SESSION["login"]){
    header("Location: /");
    exit();
}
if(isset($_POST["username"])){
    if(empty($_POST["username"])){
        http_response_code(400);
        exit(json_encode("Username is empty"));
    }else{
        if(isset($_POST["password"])){
            if(empty($_POST["password"])){
                http_response_code(400);
                exit(json_encode("Password is empty"));
            }else{
                $db = new SQLite3('../homeqtt.db');
                $userQ = $db->prepare('SELECT password FROM user WHERE username=:username');
                $userQ->bindValue(':username', $_POST["username"], SQLITE3_TEXT);
                $result = $userQ->execute();
                if($data = $result->fetchArray()){
                    if(password_verify($_POST["password"],$data["password"])){
                        $_SESSION["login"] = true;
                    }else{
                        http_response_code(400);
                        exit(json_encode("Password incorrect"));
                    }
                    
                }else{
                    http_response_code(400);
                    exit(json_encode("User not found"));
                }

            }
        }
    }
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>HomeQTT - Login</title>
</head>
<body>
    <div class="container" style="margin-top: 4em;"> 
        <img src="img/logo-icon.png" alt="logo" class="logo high">
        <h1>HomeQTT - Login</h1>
    </div>
    <div class="container">
    <?php $form=true;$form_url="login";$goto="/";?>
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
                        <a class="button wide" id="submit">Log in</a>
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
document.getElementById("form").addEventListener("keypress", function(event){
    if (event.key == "Enter"){
        sendForm();
    }
});

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