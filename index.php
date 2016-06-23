<?php

$path = dirname(__FILE__);

include $path ."/include/classes/quiz_class.php";

if(!isset($_COOKIE['quiz'])){

    $counter = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    $counter->query("UPDATE counter SET quiz=quiz+1");

    SetCookie('quiz', '1');

    $counter->close();
}

switch($quiz->get_content_switch())
{

    case '':

        $content = $quiz->echo_all_quiz();

        break;


    case 'quiz':

        $content =  $quiz->start_quiz($quiz->get_quizId());

        break;



    default:

        $content =  "Если вы видите эту надпись, значить произошла какая то ошибка, и скорее всего эта ошибка в переключателе данных страницы";

}









include $path ."/include/themes/main_theme.php";