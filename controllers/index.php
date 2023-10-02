<?php
header("Access-Control-Allow-Origin: *");

echo json_encode([
    "status" => 200,
    "message" => "ok"
]);
// //inclure function.php
// require_once "function.php";

// if($_SERVER["REQUEST_METHOD"] == "GET"){
//     //REQUEST_METHOD : est une constante qui vérifie si la requête est de type GET

//     // $_SERVER :

//     $url = $_SERVER['REQUEST_URI'];
//     // récupérer l'url que l'utilisateur à tapé dans le navigateur (ou envoyé comme requête)

//     $url = trim($url, "\/");
//     // permet de supprimer le slash et l'anti-slash de début et de fin

//     $url = explode("/", $url);
//     // converti une chaîne de caractère en tableau
//     // explode : va supprimer tous les "/" et retourner un tableau indexé avec le reste des éléments sous forme de chaîne de caractère.

//     $action = $url[1];
//     // pour afficher uniquement l'index 1

//     if($action == "getuserlist"){
//         getListUser();
//     }else if($action == "getListMessage"){
//         getListMessage($url[2], $url[3]);
//     }else{
//         echo json_encode([
//             "status"     => 404,
//             "message"    => "not found "
//         ]);
//     }
    
// }


// else{
//     //ce que l'utilisateur envoi via le formulaire, on le récupère
//     $data = json_decode(file_get_contents("php://input"),true);
//     // file_get_contents : fonction qui permet de récupérer tout le contenu du fichier que l'on stock dans $data
//     // json_decode : converti en format tableau associatif PHP
//     //  js comprend le langage JSON mais pas PHP
//     //  pour communiquer avec la base de donnée, on a besoin du langage PHP

//     if($data['action'] == "login"){
//         //appel de la fonction login
//         login($data['pseudo'], $data['password']);

//     }else if($data['action'] == "register"){
//         // on fait appel à la fonction register pour enregistrer le user
//         register($data['firstname'], $data['lastname'], $data['pseudo'], $data['password']);

//     }else if($data['action'] == "send message"){
//         //appel de la fonction sendMessage
//         sendMessage($data['expeditor'], $data['receiver'], $data['message']);

//     }else{
//         echo json_encode([
//             "status" => 404,
//             "message" => "password incorrect"
//         ]);
//     }



// }