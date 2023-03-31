<?php 

function form_card_button($name, $type, $icon){
    $card = '<button class="card" onclick="this.form.submit()" name="object" value="' . $type . '">
                <div class="card-container action">';
    $card .= file_get_contents(__DIR__ . "/img/svg/".$icon.".svg");
    $card .= "  </div>
                <div class='card-title'><span>".$name."</span></div>
            </button>";
    return $card;
}

function card_light($name, $type, $icon, $on, $id){
    $card = "<div class='card light";
    if($on == 1){$card.=" active";}
    $card .= "' id='accessory_" . $id . "'>
        <div class='card-title'><span>" . $name . "</span></div>
            <div class='card-container action'>";
            $card .= file_get_contents(__DIR__ . "/img/svg/".$icon.".svg");
        $card.= "</div>
    </div>";
    return $card;
}