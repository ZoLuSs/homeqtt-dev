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
                <svg width="25" height="25">
                    <?php echo file_get_contents(__DIR__ . "/img/svg/plus.svg"); ?>
                </svg>
            </a>
            <div class="dropdown-container">
                <a class="button" href="/add?type=room"><?php echo ucfirst(add['addroom']);?></a>
                <a class="button" href="/add?type=accessory"><?php echo ucfirst(add['addaccessory']);?></a>
            </div> 
        </div>

        <div class="dropdown" id="setup">
            <a class="button no-background" >
                <svg width="30" height="30">
                    <?php echo file_get_contents(__DIR__ . "/img/svg/option.svg"); ?>
                </svg>
            </a>
            <div class="dropdown-container">
                <a class="button" href="/setup/room">Room settings</a>
                <hr>
                <a class="button" href="logout"><?php echo ucfirst(general['logout']);?></a>
            </div> 
        </div>
    </div>
</div>