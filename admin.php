<?php

$path = dirname(__FILE__);

include $path ."/include/classes/quiz_class.php";

if(!isset($_COOKIE['aquiz'])){

    $counter = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    $counter->query("UPDATE counter SET aquiz=aquiz+1");

    SetCookie('aquiz', '1');

    $counter->close();
}


$content = $quiz->aquiz_breadcrumbs();

switch($quiz->get_content_switch())
{


    case '':

        $content .= $quiz->echo_all_aquiz();

        break;


    case 'quiz':

        $content .= $quiz->echo_quiz_questions($quiz->get_quizId());

        break;


    case 'questions':

        $content .= $quiz->echo_get_edit_question($quiz->get_quizId(), $quiz->get_questId());

        break;


    case 'addquiz':

        $content .= $quiz->addquiz();

        break;


    case 'editQuizName':

        $content .= $quiz->edit_name_quiz($quiz->get_quizId());
        break;


    case 'newQuestion':

        $content .= $quiz->new_question($quiz->get_quizId());
        break;


    default:

        $content .=  "Если вы видите эту надпись, значить произошла какая то ошибка, и скорее всего эта ошибка в переключателе данных страницы";


}


include $path ."/include/themes/admin_theme.php";
