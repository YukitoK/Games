<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Hangman</title>
  </head>
  <body>

    <?php
        include 'HangmanConfig.php';
        include 'HangmanFunctions.php';
        if(isset($_SESSION['newWord'])) unset($_SESSION['answer']);
        if(!isset($_SESSION['answer'])){
            $_SESSION['attempts']=0;
            $answer = fetchWordArray($WORDLISTFILE);
            $_SESSION['answer'] = $answer;
            $_SESSION['hidden'] = hideCharacters($answer);
            echo 'Attempts Remaining: '.($MAX_ATTEMPTS-$_SESSION['attempts']).'<br>';
        }else{
            if(isset($_POST['userInput'])){
                $userInput = $_POST['userInput'];
                $_SESSION['hidden'] = checkAndReplace(strtolower($userInput), $_SESSION['hidden'], $_SESSION['answer']);
                checkGameOver($MAX_ATTEMPTS, $_SESSION['attempts'], $_SESSION['answer'], $_SESSION['hidden']);
            }
            $_SESSION['attempts'] = $_SESSION['attempts']+1;
            echo "Attempts Remaining: ".($MAX_ATTEMPTS-$_SESSION['attempts'])."<br>";
        }
        $hidden = $_SESSION['hidden'];
        foreach($hidden as $char) echo $char." ";

    ?>

    <script type="application/javascript">
        function validateInput(){
            var x = document.forms["inputForm"]["userInput"].value;
            if(x == "" || x == " "){
                alert("Please enter a character");
                return false;
            }
            if(!isNan(x)){
                alert("Please enter a character");
                return false;
            }
        }
    </script> 

    <form name="inputForm" action="" method="post">
    Your Guess: <input name="userInput" type="text" size="1" maxlength="1">
                <input type="submit" value="Check" onclick="return validateInput();">
                <input type="submit" value="Try Another Word" name="newWord">  
    </form> 
    
<?php //session_destroy(); 
//clearstatcache(); ?>

    
  </body>
</html>