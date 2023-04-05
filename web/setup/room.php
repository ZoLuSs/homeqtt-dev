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
    <title>HomeQTT - Room settings</title>
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

$roomQ = $db->query('SELECT room_name FROM rooms ORDER BY "order" ASC');
$countRoom = 0;
while ($row = $roomQ->fetchArray()) {
    $countRoom++;
}
// Vérifie si la requête a retourné des résultats
if ($countRoom > 0) {
    $form=true;$form_url="/config/room/update-order";$goto="/";
    ?>
    <div class="segment">
      <h1>Rooms managment</h1>
      <h2>Drag and drop rooms to change order and save.</h2>
      <div class="table-container">
        <table class="table">
          <tbody id="maTable">
  
    <?php
    // Boucle sur chaque ligne du résultat et affiche les valeurs de chaque colonne
    while ($data = $roomQ->fetchArray()) {
        ?>
            <tr draggable="true">
              <td class="col-1"><?php echo $data['room_name'];?></td>
              <td class="col-2">
                <a class="button">Renommer</a>
                <a class="button">Supprimer</a>
              </td>
            </tr>
<?php
    }?>
          </tbody>
      </table>
    </div>
  </div>
<a class="button wide" id="submit"><?php echo ucfirst(general["save"]);?></a>
<?php } 
else{ ?>
<div class="segment">
    <h1><?php echo ucfirst(general['noroomcreated']);?></h1>
</div>
<?php } ?>
</div>
    <div class="modal" id="modal-loader">
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
loading = document.getElementById("modal-loader");
function sendForm() {
    loading.style.display = "flex";
    <?php if(isset($form) && $form){ ?>
        var form = document.getElementById("form");
        let data = JSON.stringify(Array.from(order.entries()));
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
    }).then(result=>{console.log(result);});
}
<?php } ?>

    </script>
</html>
