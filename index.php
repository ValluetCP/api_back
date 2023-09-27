<?php
header("Access-Control-Allow-Origin: *");

//inclure function.php
require_once "function.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    //REQUEST_METHOD : est une constante qui vérifie si la requête est de type GET

    $url = $_SERVER['REQUEST_URI'];
    // récupérer l'url que l'utilisateur à tapé dans le navigateur (ou envoyé comme requête)

    $url = trim($url, "\/");
    // permet de supprimer le slash et l'anti-slash de début et de fin

    $url = explode("/", $url);
    // converti une chaîne de caractère en tableau

    $action = $url[1];
    // pour afficher uniquement l'index 1

    if($action == "getuserlist"){
        getListUser();
    }else if($action == "getListMessage"){
        getListMessage($url[2], $url[3]);
    }else{
        echo json_encode([
            "status"     => 404,
            "message"    => "not found "
        ]);
    }
    
}
else{
    //ce que l'utilisateur envoi via le formulaire, on le récupère
    $data = json_decode(file_get_contents("php://input"),true);
    // file_get_contents : fonction qui permet de récupérer tout le contenu du fichier que l'on stock dans $data

    if($data['action'] == "login"){
        //appel de la fonction login
        login($data['pseudo'], $data['password']);

    }else if($data['action'] == "register"){
        // on fait appel à la fonction register pour enregistrer le user
        register($data['firstname'], $data['lastname'], $data['pseudo'], $data['password']);

    }else if($data['action'] == "send message"){
        //appel de la fonction sendMessage
        sendMessage($data['expeditor'], $data['receiver'], $data['message']);

    }else{
        echo json_encode([
            "status" => 404,
            "message" => "password incorrect"
        ]);
    }



}