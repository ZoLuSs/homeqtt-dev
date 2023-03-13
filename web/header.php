<?php
require_once('config/co_bdd.php');
$housename = $db->querySingle('SELECT value FROM config WHERE name="house_name"');
?>
<div class="header">
    <div class="left-container">
        <a href="/" class="title button no-background">
            <img src="img/logo-icon.png" alt="logo" class="logo">
            <span>HomeQTT</span>
        </a>
    </div>


    <div class="title-container">
        <span class="title"><?php echo $housename;?> -&nbsp;<span class="title" id="clock"></span></span>
    </div>

    <div class="right-container">

        <a class="button no-background" href="add">
            <img src="/img/svg/plus.svg" alt="plus" height="25" width="25" /> 
        </a>
        <a  class="button no-background">
            <img src="/img/svg/option.svg" alt="option" height="30" width="30" />
        </a>
         
   
    </div>

</div>