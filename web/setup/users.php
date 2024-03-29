<?php
require_once(__DIR__ . '/../config/session.php');
require_once(__DIR__ . "/../lang/lang.php");
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/index.css">
    <title>HomeQTT - <?php echo ucfirst(general['users']);?></title>
    <script src="/js/socketio/socket.io.min.js"></script>
    <style>
        li {
  cursor: move;
}
    </style>
</head>
<body>
<?php require_once(__DIR__ . "/../header.php");?>
<div class="container">
<?php

$userQ = $db->query('SELECT id, username FROM user ORDER BY ID ASC');
while ($row = $userQ->fetchArray()) {
  $countUser++;
}
    $form=true;$form_url="/config/room/update-order";$goto="/";
    ?>
    <div class="segment">
      <h1><?php echo ucfirst(general['usersmgmt']);?></h1>
      <div class="table-container">
        <table class="table">
          <tbody id="maTable">
  
    <?php
    while ($data = $userQ->fetchArray()) {
        ?>
            <tr draggable="true">
              <td class="col-1"><?php echo $data['username'];?></td>
              <td class="col-2">
                <a class="button">Renommer</a>
                <?php if($countUser > 1){ ?>
                <a class="button" id="delete" onclick='sendJSON("/config/user/delete", {"userid": <?php echo $data["id"];?>}, "/setup/users")'>Supprimer</a>
                <?php } ?>
              </td>
            </tr>
    <?php
    }?>
          </tbody>
      </table>
    </div>
  </div>
<a class="button wide" id="submit"><?php echo ucfirst(general["save"]);?></a>

</div>
    <div class="modal" id="modal">
        <div class="modal-container">
            <span class="loader"></span>
        </div>
    </div>
</body>
<script>
const token = "<?php 
require_once(__DIR__ . "/../config/jwt.php");
$jwt = generate_jwt("payload");
echo $jwt;?>";
const socket = io.connect('http://<?php echo $_SERVER['SERVER_NAME']; ?>:4001', {
  query: {token}
});
</script>
<script src="/js/index.js"></script>
<script>
var items = document.querySelectorAll('#maTable tr');
var dragSrcEl = null;
var order = new Map();

function handleDragStart(e) {
  dragSrcEl = this;
  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.innerHTML);
}

function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault();
  }

  e.dataTransfer.dropEffect = 'move';

  return false;
}

function handleDrop(e) {
  if (e.stopPropagation) {
    e.stopPropagation();
  }

  if (dragSrcEl != this) {
    var dragHTML = dragSrcEl.innerHTML;
    var dropHTML = this.innerHTML;

    dragSrcEl.innerHTML = dropHTML;
    this.innerHTML = dragHTML;
  }

  return false;
}

function handleDragEnd(e) {
  var items = document.querySelectorAll('#maTable tr');

  for (var i = 0; i < items.length; i++) {
    var key = items[i].getElementsByTagName('td')[0].innerHTML;
    var value = i;
    order.set(key, value);
  }
  console.log(order);
}

for (var i = 0; i < items.length; i++) {
  items[i].addEventListener('dragstart', handleDragStart, false);
  items[i].addEventListener('dragover', handleDragOver, false);
  items[i].addEventListener('drop', handleDrop, false);
  items[i].addEventListener('dragend', handleDragEnd, false);
}

<?php if(isset($form_url) && !empty($form_url)){ ?>
document.getElementById("submit").addEventListener("click", sendForm);

function sendForm() {
    loading.style.display = "flex";
    <?php if(isset($form) && $form){ ?>
        var form = document.getElementById("form");
        <?php if(isset($_GET['adduser'])){ ?>
            var data = new FormData(form);
            <?php }
            else { ?>
            let data = JSON.stringify(Array.from(order.entries()));
            <?php } ?>
    <?php } ?>
    fetch("<?php echo $form_url;?>", {
    <?php if(isset($form) && $form){ ?>
        method: "POST",
        header: {
            'Content-Type': 'application/json'
        },
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
    }).then(result=>{
        showNotification(result, "error", 5000);
    });
}
<?php } ?>

    </script>
</html>
