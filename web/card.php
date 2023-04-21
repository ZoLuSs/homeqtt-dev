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
    $activeClass = $on == 1 ? " active" : "";
    $iconPath = __DIR__ . "/img/svg/".$icon.".svg";
    $iconContent = file_get_contents($iconPath);
    $card = <<<HTML
        <div class="card light{$activeClass}" id="accessory_{$id}" data-type="{$type}">
            <div class="card-title"><span>{$name}</span></div>
            <div class="card-container action">{$iconContent}</div>
        </div>
    HTML;
    return $card;
}