<?php




function debug($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}

function trimTab($tab)
{
    $t = [];
    foreach ($tab as $item) {
        array_push($t, trim($item));
    }
    return $t;
}

function deleteSpecialChar($str)
{

    // remplacer tous les caractères spéciaux par une chaîne vide
    $res = str_replace(array(' ', '%', '@', '\'', ';', '<', '>', '+', '*', '[', ']', ',', '?', '|', '$', '§', '!', '&'
    , '_', '`', '=', '^', '(', ')', '{', '}', '#', "~", ':', ';', '/','0', '1' , '2' , '3' , '4' , '5' , '6' , '7' , '8'
    ,'9' ,'é' , 'è' , 'à' , 'ç' ,'ù'), '', $str);

    return $res;
}