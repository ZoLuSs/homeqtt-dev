<?php
require_once('config/co_bdd.php');
$housename = $db->querySingle('SELECT value FROM config WHERE name="house_name"');
?>
<div class="header">
    <div class="left-container">
        <a href="/" class="title button no-background">
            <img src="/img/logo-icon.png" alt="logo" class="logo">
            <span>HomeQTT</span>
        </a>
    </div>
    
    <div class="title-container">
        <span class="title"><?php echo $housename;?><span class="dash"> -&nbsp;</span><span class="title" id="clock"></span></span>
    </div>

    <div class="right-container">
        <div class="dropdown" id="add">
            <a class="button no-background" >
                <img src="/img/svg/plus.svg" alt="plus" height="25" width="25" />
            </a>
            <div class="dropdown-container">
                <a class="button" href="/add?type=room"><?php echo ucfirst(add['addroom']);?></a>
                <a class="button" href="/add?type=accessory"><?php echo ucfirst(add['addaccessory']);?></a>
            </div> 
        </div>

        <div class="dropdown" id="setup">
            <a class="button no-background" >
                <img src="/img/svg/option.svg" alt="option" height="30" width="30" />
            </a>
            <div class="dropdown-container">
                <a class="button" href="/setup/room">Room settings</a>
                <hr>
                <a class="button" href="logout"><?php echo ucfirst(general['logout']);?></a>
            </div> 
        </div>
    </div>
</div>