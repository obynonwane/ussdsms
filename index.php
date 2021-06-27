<?php

    include_once 'menu.php';
    include_once 'db.php';
    include_once 'user.php';

    // Read the variables sent via POST from our API
    $sessionId   = $_POST["sessionId"];
    $serviceCode = $_POST["serviceCode"];
    $phoneNumber = $_POST["phoneNumber"];
    $text        = $_POST["text"];

    $user  = new User($phoneNumber);
    $db = new DBConnector();
    $pdo = $db->connectToDB();

    $menu = new Menu();
    $text = $menu->middleware($text);
    

    if($text == '' && $user->isUserRegistered($pdo)) {
        //user is registered and string is empty
        $menu->mainMenuRegistered($user->readName($pdo));
    }else if($text == '' && !$user->isUserRegistered($pdo)) {
        //user is unregistered and string is empty
        $menu->mainMenuUnRegistered();
    } else if(!$user->isUserRegistered($pdo)) { 
        //user is unregistered and string is not empty
        $textArray = explode("*", $text);
        switch($textArray[0]){
            case 1:
                $menu->registerMenu($textArray, $phoneNumber, $pdo);
                break;
                default:
                    echo "END Invalid choice. Please try again";
        }
    } else {
        //user is registered and string is not empty
        $textArray = explode("*", $text);
        switch($textArray[0]) {
            case 1:
                $menu->sendMoneyMenu($textArray);
                break;
            case 2:
                $menu->withdrawMoneyMenu($textArray);
                break;
            case 3:
                $menu->checkBalanceMenu($textArray);
                break;
             default:
                    echo "END Invalid choice. Please try again";
        }
    }