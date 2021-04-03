<?php

use App\User;

function changeDateFormate($date,$date_format){
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);    
}
function dateToPTBR($date){
    $result = new DateTime($date);
    return $result->format("d/m/Y"); 
}

function datetimeToPTBR($date){
    $result = new DateTime($date);
    return $result->format("d/m/Y h:m"); 
}

function dateString($date){
    $result = new DateTime($date);
    return $result->format("F j, Y");
}
   
function productImagePath($image_name)
{
    return public_path('images/products/'.$image_name);
}

function userIsAdmin($user){
    if($user->minRoleID($user)==2 || $user->minRoleID($user)==1){
        return true;
    } 
    return false;
}

function get_tipo_posts($tipo_post){
    echo '<option >Escolha o tipo</option>';
    foreach($tipo_post as $tipo){
        echo '<option value="'.$tipo->id.'" >'.$tipo->nome.'</option>';
    }
}