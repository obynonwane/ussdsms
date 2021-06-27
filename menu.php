<?php 
include_once "util.php";
class Menu {
    protected $text;
    protected $sessionID;

    function __construct(){}

    public function mainMenuRegistered(){
        $response  = "CON Reply with\n";
        $response .= "1. Send money\n";
        $response .= "2. Withdraw\n";
        $response .= "3. Check balance\n";
        echo $response;
    }
    public function mainMenuUnRegistered(){
        $response  = "CON Welcome to this app. Reply with\n";
        $response .= "1. Register\n";
        echo $response;
    }
    public function registerMenu($textArray){
        $level = count($textArray);
        if($level == 1){
            echo "CON Please enter your full name";
        } else if($level == 2){
            echo "CON Please enter  your pin ";
        } else if($level == 3){
            echo "CON Please re-enter  your pin ";
        } else if($level == 4){
            $name = $textArray[1];
            $pin = $textArray[2];
            $confirmPin  = $textArray[3];
            if($pin != $confirmPin){
                echo "END your pins do not match. Please try again";
            }
            //we can register the user 
            //send sms
            echo "END You have been registered";
        } else {
           
        }
    }
    public function sendMoneyMenu($textArray){
        $level = count($textArray);
        if($level == 1){
            echo "CON Enter mobile number of the receiver";
        } else if($level == 2){
            echo "CON Enter amount";
        } else if($level == 3){
            echo "CON Enter your pin";
        } else if($level == 4){
            $response = "CON send " . $textArray[2] . " " . $textArray[3] . "\n";
            $response .= "1. confirm \n "; 
            $response .= "2. cancel \n "; 
            $response .= Util::$GO_BACK .  " .Back\n";
            $response .= Util::$GO_TO_MAIN_MENU . " .Main menu\n";
            echo $response;
        } else if($level == 5 && $textArray[4] == 1){
            //confirm
            echo "END thank you your request has been processed";
        } else if($level == 5 && $textArray[4] == 2){
            //cancel
            echo "END thank you for using our service";
        } else if($level == 5 && $textArray[4] == Util::$GO_BACK){
            echo "END You have requested to go back one step - PIN";
        } else if($level == 5 && $textArray[4] == Util::$GO_TO_MAIN_MENU){
            echo "END You have requested to go back to main menu";
        } else {
            echo "END Invalid Entry";
        }
    }
    public function withdrawMoneyMenu($textArray){
        $level = count($textArray);
        if($level == 1){
            echo "CON Enter agent number:";
        } else if($level == 2) {
            echo "CON Enter amount:";
        } else if($level == 3 ) {
            echo "CON Enter your pin:";
        } else if($level == 4) {
            echo "CON withdraw ". $textArray[2] . " from agent " . $textArray[1] . "\n 1. Confirm\n 2. Cancel\n" ;
        } else if($level == 5 && $textArray[4] == 1){
            //confirm
            echo "END Your request is been processed";

        } else if($level == 5 && $textArray[4] == 2){
            //cancel
            echo "END Operation is canceled, Thank you";
        }else {
            echo "END Invalid Entry";
        }
    }
    public function checkBalanceMenu($textArray){
        $level = count($textArray);
        if($level == 1){
            echo "CON Enter pin:";
        } else if($level == 2) {
            //Logic 
            //check Pin correctnes
            echo "END We are processing your request and you will receive an sms shortly:";
        } else {
            echo "END Invalid Entry";
        }
    }

    public function middleware($text){
        //remove menu for going back and to the main menu
        return $this->goBack($this->goToMainMenu($text));
    }
    public function goBack($text){
        $explodedText =  explode("*", $text);
        while(array_search(Util::$GO_BACK, $explodedText) != false) {
            $firstIndex = array_search(Util::$GO_BACK, $explodedText);
            array_slice($explodedText, $firstIndex-1, 2);
        }
        return join("*", $explodedText);
    }

    public function goToMainMenu($text){
        $explodedText =  explode("*", $text);
        while(array_search(Util::$GO_TO_MAIN_MENU, $explodedText) != false){
            $firstIndex = array_search(Util::$GO_TO_MAIN_MENU, $explodedText);
            $explodedText = array_slice($explodedText, $firstIndex + 1);
        }
        return join("*", $explodedText);
    }

}

?>