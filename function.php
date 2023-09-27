<?php

//fonction pour se connecter a la bd
function dbConnect(){
    $conn = null;
    try {
        $conn = new PDO("mysql:host=localhost;dbname=api_db", "root", "");
    } catch (PDOException $e) {
        $conn = $e->getMessage();
    }return $conn;
}


//fonction pour enregistrer un utilisateur
function register($firstname,$lastname,$pseudo,$password){
    //hasher le mot de passe
    $passwordCrypt = password_hash($password, PASSWORD_DEFAULT);

    //connexion a la bd
    $db = dbConnect();

    // preparer la requete
    $request = $db->prepare("INSERT INTO users (firstname, lastname, pseudo, password) VALUES (?,?,?,?)");

    try {
        $request->execute(array($firstname,$lastname,$pseudo,$passwordCrypt));
        echo json_encode([
            "status" => 201,
            "message" => "everything good"
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            "status" => 500,
            "message" => $e->getMessage()
        ]);
    }
}

//fonction pour se connecter
function login($pseudo, $password){

    //connexion a la bd
    $db = dbConnect();

    //préparer la requete 
    $request = $db->prepare("SELECT * FROM users WHERE pseudo = ?");

    try {
        $request->execute(array($pseudo));
        // récuperer la réponse de la requete
        $user = $request->fetch(PDO::FETCH_ASSOC);

        // vérifier si l'utilisateur existe
        if(empty($user)){
            echo json_encode([
                "status" => 404,
                "message" => "user not found",
            ]);
        }else{
            // vérifier si le password est correct
            if(password_verify($password, $user['password'])){
                echo json_encode([
                    "status" => 200,
                    "message" => "félicitation...",
                    "userInfo" => $user
                ]);
            }else{
                echo json_encode([
                    "status" => 401,
                    "message" => "password incorrect"
                ]);
            }
        }
    } catch (PDOException $e) {
        echo json_encode([
            "status" => 500,
            "message" => $e->getMessage()
        ]);
    }


}

//fonction pour envoyer un message
function sendMessage($expeditor, $receiver, $message){

    //connexion a la bd
    $db = dbConnect();

    // preparer la requete
    $request = $db->prepare("INSERT INTO messages (message, expeditor_id,receiver_id) VALUES (?,?,?)");

    //executer la requete
    try {
        $request->execute(array($message,$expeditor,$receiver));
        echo json_encode([
            "status" => 201,
            "message" => "your message is safely sent..."
        ]);
        
    } catch (PDOException $e) {
        echo json_encode([
            "status" => 500,
            "message" => $e->getMessage()
        ]);
    }


}

//fonction pour récupérer la liste des users
function getListUser(){

    //connexion a la bd
    $db = dbConnect();

    // preparer la requete
    $request = $db->prepare("SELECT * FROM users");

    try {
        $request->execute();
        $listUsers = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            "status" => 200,
            "message" => "Voici la liste des users",
            "users" => $listUsers
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            "status" => 500,
            "message" => "Voici la liste des users",
            "data" => $e->getMessage()
        ]);
    }
}

// fonction pour recuperer la conversation entre 2 users
function getListMessage($expeditor, $receiver){
    // se connecter a la base de données
    $db = dbConnect();
    // preparer la requete
    $request = $db->prepare("SELECT * FROM messages WHERE expeditor_id = ? AND receiver_id = ? OR expeditor_id = ? AND receiver_id = ?");
    // executer la requete
    try{
        $request->execute(array($expeditor, $receiver, $receiver, $expeditor));
        // recuperer le resultat dans un tableau
        $messages = $request->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            "status"     => 200,
            "message"    => "voici la liste de votre discution",
            "listMessage"=> $messages
        ]);
    }catch(PDOException $e){
        echo json_encode([
            "status"    => 500,
            "message"   => $e->getMessage()
        ]);
    }
    
}
