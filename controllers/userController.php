<?php
require_once "../models/userModel.php";

class UserController{

    // method pour effectuer la bonne action (elle va filtrer les bons model ex: userModel, productModel, etc
    public static function loadModel($action, $data = null){
        switch($action){
            case"getuserlist":
                // appel de la method getuserlist
                UserModel::getUserList();
                break;
            case"getListMessage":
                // appel de la method getListMessage
                UserModel::getListMessage($data[0], $data[1]);
                break;
            case"login":
                // appel de la method login
                UserModel::login($data[0], $data[1]);
                break;
            case"register":
                // appel de la method register
                UserModel::register($data[0], $data[1], $data[2], $data[3]);
                break;
            case"send message":
                // appel de la method send message
                UserModel::sendMessage($data[0], $data[1], $data[2]);
                break;
            default:
            echo json_encode([
                "statut" => 404,
                "message" => "service not found..."
            ]);
        }
    }

}