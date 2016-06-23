<?php


define('DB_SERVER', 'localhost');
define('DB_USER', 'dataBase');
define('DB_PASS', 'Fujitsu');
define('DB_NAME', 'deafcos');


class quiz
{

// Шаблоны страниц


    // Главная страница викторин

        // шаблон итема на главной странице викторины
        private $tmp_main_quiz_item = "<a href='/?quiz={[-id-]}'><b>{[-name-]}</b></a><br>{[-description-]}<br><br>";

        // обертка главной страницы редактирования с викторинами
        private $tmp_main_aquiz_outer = "{[-inner_main_aquiz_items-]} <a class='btn btn-xs btn-primary' href='/admin.php?addquiz=add'>Новая викторина</a>";

        // шаблон итема на главной странице администрирования викторин
        private $tmp_main_aquiz_item = "
<div class='{[-outer_class-]}'>
    <div class='tmp_main_aquiz_item' quizId='{[-id-]}'>
        <a href='/admin.php?quiz={[-id-]}'><b>{[-name-]}</b></a> <a href='/admin.php?editQuizName={[-id-]}'><span class='glyphicon glyphicon-pencil'></span></a><br>
        {[-description-]}
    </div>
    <button class='quiz_Visibil_Switch {[-On/Off_class-]}' type='button'>{[-On/Off_name-]}</button>
    <button class='dell_quiz btn btn-xs btn-danger' type='button'>удалить</button>

</div>


";

    private $tmp_main_aquiz_data = [

        'switchONmain' => 'outer_tmp_main_aquiz_item',
        'switchOFFmain' => 'outer_tmp_main_aquiz_item_OFF',

        'On_btn_class' => 'btn btn-xs btn-link',
        'On_btn_name' => 'Включить',

        'Off_btn_class' => 'btn btn-xs btn-default',
        'Off_btn_name' => 'Выключить',

    ];



    // Страница с вопросами

        // общий шаблон всей страницы с вопросами
        private $tmp_questions_main = "<h3>{[-quiz_name-]} </h3>{[-questions_block-]} <a href='/admin.php?newQuestion={[-quiz_id-]}' id='new_question' class='btn btn-xs btn-primary'>Добавить вопрос</a>";

        // шаблон итема на странице с вопросами
        private $tmp_questions_item = "<div class='questions_item'><span quesId='{[-ques_id-]}' class='dell_question btn btn-xs btn-danger'>x</span> {[-ques_quesNum-]}. <a href='/admin.php?quiz={[-quiz_id-]}&question={[-ques_quesNum-]}'>{[-ques_question-]}</a></div>";


    // Страница редактирования вопроса
    private $tmp_edit_question_main = "

<h3><a href='/admin.php?quiz={[-quiz_id-]}'>{[-quiz_name-]}</a> </h3>

<form action='/admin.php' method='POST'  id='edit_question_form'>

<div>


<label for='edit_chNumber' class='chNumber'>Сменить номер на:</label>
<input type='text' id='edit_chNumber' name='edit_chNumber' value='{[-quesNum-]}' required>

<a href='{[-back-]}' class='btn btn-xs btn-primary{[-back-class-]}'>Назад</a>
<span id='currentNumber'>{[-quesNum-]}</span> из <span id='maxNumber'>{[-quesCount-]}</span>
<a href='{[-next-]}' class='btn btn-xs btn-primary{[-next-class-]}'>Дальше</a>
<a href='/admin.php?newQuestion={[-quiz_id-]}' class='new_ques_button btn btn-xs btn-primary'>+</a>

</div>


<label for='question sr-only' class='question_label sr-only'>Вопрос:</label>
<textarea id='question' name='question' rows='2' placeholder='Введите вопрос' required autofocus>
{[-question-]}
</textarea>

<div id='variants_block'>
    {[-variants_block-]}
</div>



<div id='add_variant' class='btn btn-xs btn-primary'>Добавить</div>

<div class='answer_block'>

    <label for='ansv' class='answer_lable'>Правильный ответ:</label>
    <input type='text' id='edit_right_answer' name='edit_answer' value='{[-rightVariantNum-]}' required autofocus>

    <label for='cite' class='cite_lable'>Цитата:</label>
    <input type='text' id='edit_cite' name='edit_cite' placeholder='Цитата' value='{[-citation-]}' autofocus>

</div>

<label for='comment' class='comment_lable' >Комментарий:</label>
<textarea name='comment' id='edit_comment' placeholder='Сюда можете добавить комментарий (необязательно)' autofocus>{[-comment-]}</textarea>

<input id='edit_quizId' type='hidden' value='{[-quiz_id-]}'>


<button class='btn btn-lg btn-primary btn-block' type='submit'>Сохранить</button>
</form>

";



// Шаблон добавление нового вопроса
    private $tmp_new_question = "

<h3><a href='/admin.php?quiz={[-quiz_id-]}'>{[-quiz_name-]}</a> </h3>

<form action='/admin.php' method='POST'  id='new_question_form'>

<div>


<label for='edit_chNumber' class='chNumber'>Сменить номер на:</label>
<input type='text' id='edit_chNumber' name='edit_chNumber' value='{[-quesNum-]}' required>

<span>Будет под номером: </span><span id='currentNumber'>{[-quesNum-]}</span>
</div>


<label for='question sr-only' class='question_label sr-only'>Вопрос:</label>
<textarea id='question' name='question' rows='2' placeholder='Введите вопрос' required autofocus></textarea>

<div id='variants_block'>
    <div class='variants_block'>
        <label for='var1' class='label_variant'>1</label><input type='text'  name='var1' class='edit_variant' placeholder='Укажите вариант ответа' required>
    </div>
    <div class='variants_block'>
        <label for='var2' class='label_variant'>2</label><input type='text'  name='var2' class='edit_variant' placeholder='Укажите вариант ответа' required>
    </div>
</div>



<div id='add_variant' class='btn btn-xs btn-primary'>Добавить</div>

<div class='answer_block'>

    <label for='ansv' class='answer_lable'>Правильный ответ:</label>
    <input type='text' id='edit_right_answer' name='edit_answer' required autofocus>

    <label for='cite' class='cite_lable'>Цитата:</label>
    <input type='text' id='edit_cite' name='edit_cite' placeholder='Цитата' autofocus>

</div>

<label for='comment' class='comment_lable' >Комментарий:</label>
<textarea name='comment' id='edit_comment' placeholder='Сюда можете добавить комментарий (необязательно)' autofocus></textarea>

<input id='edit_quizId' type='hidden' value='{[-quiz_id-]}'>


<button class='btn btn-lg btn-primary btn-block' type='submit'>Сохранить</button>
</form>

";






    // шаблон одного итема варианта вопроса
    private $tmp_edit_question_var_item = "

    <div class='variants_block'>
    <label for='var{[-varNum-]}' class='label_variant'>{[-varNum-]}</label><input type='text'  name='var{[-varNum-]}' class='edit_variant' placeholder='Укажите вариант ответа' value='{[-variant-]}' required>{[-dell_variant_button-]}
    </div>

";

    private $dell_variant_button = "<span class='dell_var_item btn btn-xs btn-danger'>удалить</span>";


// страница добавления викторины
    private $tmp_add_quiz = "

<h3>Создание викторины</h3>

<div id='add_quiz_error'>викторина с таким названием уже есть, придумайте другое название</div>

<form action='/admin.php' method='POST'  id='add_quiz_form'>


    <label for='quiz_name' class='quiz_name_lable sr-only'>Имя Викторины</label>
    <textarea id='quiz_name' name='quiz_name' rows='2' placeholder='Имя викторины' required autofocus></textarea>



    <label for='quiz_comment' class='quiz_comment_lable sr-only'>Комментарий к викторине</label>
    <textarea id='quiz_comment' name='quiz_comment' rows='2' placeholder='Комментарий к викторине (не обязательно)'></textarea>


    <button id='quiz_submit' class='btn btn-lg btn-primary' type='submit'>Создать</button>

</form>

";




// страница добавления викторины
    private $tmp_new_quiz = "

<h3>Редактирование имени викторины</h3>

<div id='edit_quiz_message'></div>

<form action='/admin.php' method='POST'  id='edit_quiz_name_form'>


    <label for='quiz_name' class='quiz_name_lable sr-only'>Имя Викторины</label>
    <textarea id='quiz_name' name='quiz_name' rows='2' placeholder='Имя викторины' required autofocus>{[-name-]}</textarea>



    <label for='quiz_comment' class='quiz_comment_lable sr-only'>Комментарий к викторине</label>
    <textarea id='quiz_comment' name='quiz_comment' rows='2' placeholder='Комментарий к викторине (не обязательно)'>{[-comment-]}</textarea>

    <input id='quiz_id' type='hidden' value='{[-id-]}'>

    <button id='quiz_submit' class='btn btn-lg btn-primary' type='submit'>Сохранить</button>

</form>

";





// Переключатель контента
    private $content_switch = '';


// Идентификатор викторины
    private $quizId;

// Идентификатор вопроса
    private $questId;

// переменная базы данных
    private $mysqli;



// конструктор, подключение к базе данных
    public function __construct()
    {
        $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        if ($this->mysqli->connect_errno)
        {
            printf("Не удалось подключиться: %s\n", $this->mysqli->connect_error);
            exit();
        }


        if (!$this->mysqli->set_charset("utf8")) {
            printf("Ошибка при загрузке набора символов utf8: %s\n", $this->mysqli->error);
        }
    }


// возвращает массив ответа на запрос к базе данных
    private function query($sql)
    {

        $q = $this->mysqli->query($sql);

        if(is_object($q)) {

            $res = [];

            while ($row = $q->fetch_array()) {
                $res[] = $row;
            }

            return $res;

        } else {

            return null;

        }

    }

// все викторины, которые доступны
    public function all_quiz()
    {

        $sql_all_quiz = "SELECT * FROM modx_quiz_names WHERE display = 1";


        $all_quiz = $this->query($sql_all_quiz);

        return $all_quiz;
    }

// начало просмотра викторины
    public function start_quiz($quizId)
    {

        // Шаблон посмотра первого вопроса
        $tmp_question_main =
"
    <h3>{[-quiz_name-]} <span class='badge'><span id='quesNum'>{[-quesNum-]}</span> из <span id='quesCount'>{[-quesCount-]}</span></span></h3>


<div id='quesPanel' class='panel panel-default'>

    <div class='panel-heading'>
        <div id='question' class='panel-title'>{[-question-]}</div>
    </div>


    <div class='panel-body'>

        <div id='variants_block'>
            {[-variants_block-]}
        </div>

        <div id='correctAnswer' class='hidden_block'>
            <div class='alert alert-success' role='alert'>
                <strong>Правильно!</strong>
                <span class='rCite'></span>
                <div class='comment'>Комментарий</div>
            </div>
        </div>

        <div id='incorrectAnswer' class='hidden_block'>
            <div class='alert alert-danger' role='alert'>
                <strong>Неправильно!</strong>
                <span class='rCite'></span>
                <div class='comment'>Комментарий</div>
            </div>
        </div>

        <div id='nextBtnBlock' class='hidden_block' >
            <button id='nextBtn' class='btn btn-primary btn-block' disabled='disabled' type='submit'>Дальше</button>
        </div>

    </div>

</div>

        <div id='endQuiz' class='hidden'>
            <br>
            <div class='text-center'>Спасибо что прошли викторину</div>
            <br>
            <a href='/' class='btn btn-primary btn-block'>На начало</a>
        </div>


        <div id='error_block' class='hidden_block'>
            <div class='alert alert-warning' role='alert'>
                <strong>Долго нет ответа с сервера!</strong>
                <div>
                    возможно связь потеряна, либо очень медленный интернет, <br>
                    проверьте соединение
                </div>

            </div>
        </div>


    <script>

        var rightVariantNum = '{[-rightVariantNum-]}';
        var citation = '{[-citation-]}';
        var comment = '{[-comment-]}';
        var quiz_id = '{[-quiz_id-]}';

    </script>

";

        // шаблон варианта ответа на вопрос
        $tmp_question_var_item = "<div class='variant btn btn-lg btn-default btn-block' varNum='{[-varNum-]}'>{[-variant-]}</div>";



        // данные викторины
        $quiz = $this->single_quiz_data($quizId);

        // количество вопросов в викторине
        $quesCount = $this->question_Count($quizId);

        // данные первого вопроса
        $ques = $this->single_question_data($quizId, 1);

        // варианты ответа на первый вопрос
        $variants = $this->variants_data($ques['id']);


        // блок с вариантами ответов
        $variants_block = '';

        foreach ($variants as $var) {

            $var_data = [

                0 => $var['varNum'],
                1 => $var['variant'],
            ];

            $var_places = [

                0 => '{[-varNum-]}',
                1 => '{[-variant-]}',
            ];

            $variants_block .= str_replace($var_places, $var_data, $tmp_question_var_item);
        }


        $edit_data = [

            0 => $variants_block,
            1 => $quiz['id'],
            2 => $quiz['name'],
            3 => $ques['quesNum'],
            4 => $quesCount,
            5 => $ques['question'],
            6 => $ques['rightVariantNum'],
            7 => $ques['citation'],
            8 => $ques['comment'],

        ];

        $edit_places = [

            0 => '{[-variants_block-]}',
            1 => '{[-quiz_id-]}',
            2 => '{[-quiz_name-]}',
            3 => '{[-quesNum-]}',
            4 => '{[-quesCount-]}',
            5 => '{[-question-]}',
            6 => '{[-rightVariantNum-]}',
            7 => '{[-citation-]}',
            8 => '{[-comment-]}',

        ];

        return str_replace($edit_places, $edit_data, $tmp_question_main);

    }

// следующий вопрос викторины
    private function next_quiz_question($arr)
    {

        // Индекс викторины
        $quizId = $arr[0];

        // Номер вопроса
        $quesNum = $arr[1]+1;

        // Всего вопросов
        $quesCount = $arr[2];

        // Индекс ответа
        $answerIndex = $arr[3];


        // если это последний вопрос (количество вариантов меньше номера вопроса)
        if($quesCount < $quesNum){

            return "done";

        }


        // данные вопроса
        $ques = $this->single_question_data($quizId, $quesNum);

        // варианты ответа на вопрос
        $variants = $this->variants_data($ques['id']);

        $varCount = count($variants);

        $out = [

            'quesNum' => $quesNum,
            'ques' => $ques['question'],
            'rightVariantNum' => $ques['rightVariantNum'],
            'citation' => $ques['citation'],
            'comment' => $ques['comment'],
            'varCount' => $varCount

        ];


        $varArr =[];

        $i = 1;
        foreach($variants as $var){

//            $ind = "var" .$i;
            $varArr[$i] = $var['variant'];
            $i++;
        }

        $out['variants'] = $varArr;

        return json_encode($out);
    }

// возвращает массив с данными всех викторин (даже тех, которые недоступны к просмотру)
    public function all_aquiz()
    {

        $sql_all_quiz = "SELECT * FROM modx_quiz_names";

        $all_quiz = $this->query($sql_all_quiz);

        return $all_quiz;
    }

// устанавливает значение переключателя контента
    public function check_request()
    {

// переключение видимости/невидимости викторины
        if($_POST['quiz_Switch']){
            echo $this->quiz_Visibil_Switch($_POST['quiz_Switch']);
            exit;
        }

// добавление новой викторины в базу данных
        if($_POST['add_quiz']){
            echo $this->addquiz_create($_POST['name'], $_POST['comment']);
            exit;
        }

// удаление викторины из базы данных
        if($_POST['dell_quiz']){
            echo $this->dell_quiz($_POST['id']);
            exit;
        }

// редактирование имени викторины
        if($_POST['update_quiz']){
            echo $this->update_quiz($_POST['id'], $_POST['name'], $_POST['comment']);
            exit;
        }

// сохранение вопроса викторины в базе данных
        if($_POST['edit_question_form']){
            echo $this->save_edit_questions();
            exit;
        }

// сохранение нового вопроса викторины в базе данных
        if($_POST['new_question_form']){
            echo $this->save_new_questions();
            exit;
        }

// удаление вопроса
        if($_POST['dell_ques']){
            echo $this->dell_one_questions($_POST['dell_ques']);
            exit;
        }

// прохождение викторины
        if($_POST['quesAnswer']){

            echo $this->next_quiz_question($_POST['quesAnswer']);
            exit;
        }



// ответ на незарегистрированный пост
        if($_POST){
            exit;
        }




// вывод всех викторин на страницу
        if(isset($_GET['quiz']) == true){

            $this->content_switch = 'quiz';
            $this->quizId = $_GET['quiz'];

            if(isset($_GET['question']) == true){

                $this->content_switch = 'questions';
                $this->questId = $_GET['question'];
            }

        }

// вывод страницы добавление новой викторины
        if(isset($_GET['addquiz']) == true){

            if($_GET['addquiz'] == 'add'){

                $this->content_switch = 'addquiz';

            }

        }

// редактирование названия и комментария викторины
        if(isset($_GET['editQuizName']) == true){

            $this->content_switch = 'editQuizName';
            $this->quizId = $_GET['editQuizName'];

        }

// добавление нового вопроса
        if(isset($_GET['newQuestion']) == true){

            $this->content_switch = 'newQuestion';
            $this->quizId = $_GET['newQuestion'];

        }


        return null;
    }

// возвращает значение переключателя контента
    public function get_content_switch()
    {
        return $this->content_switch;
    }

// получить идентификатор текущей викторины
    public function get_quizId()
    {
        return $this->quizId;
    }

// получить идентификатор текущего вопроса
    public function get_questId()
    {

        return $this->questId;

    }

// Вывести все викторины
    public function echo_all_quiz()
    {
        $out = '';

        foreach ($this->all_quiz() as $v) {

            $data = [

                0 => $v['id'],
                1 => $v['name'],
                2 => $v['description']

            ];

            $places = [

                0 => '{[-id-]}',
                1 => '{[-name-]}',
                2 => '{[-description-]}'

            ];

            $out .= str_replace($places, $data, $this->tmp_main_quiz_item);

        }

        return $out;

    }

// Вывести все викторины для редактирования
    public function echo_all_aquiz()
    {

        $inner_main_aquiz_items = '';

        foreach ($this->all_aquiz() as $v) {

            $data = [

                0 => $v['id'],
                1 => $v['name'],
                2 => $v['description'],
                3 => $v['display'],
                4 => ($v['display'] == 0)?($this->tmp_main_aquiz_data['switchOFFmain']):($this->tmp_main_aquiz_data['switchONmain']),
                5 => ($v['display'] == 0)?($this->tmp_main_aquiz_data['On_btn_class']):($this->tmp_main_aquiz_data['Off_btn_class']),
                6 => ($v['display'] == 0)?($this->tmp_main_aquiz_data['On_btn_name']):($this->tmp_main_aquiz_data['Off_btn_name']),
            ];

            $places = [

                0 => '{[-id-]}',
                1 => '{[-name-]}',
                2 => '{[-description-]}',
                3 => '{[-display-]}',
                4 => '{[-outer_class-]}',
                5 => '{[-On/Off_class-]}',
                6 => '{[-On/Off_name-]}',
            ];

            $inner_main_aquiz_items .= str_replace($places, $data, $this->tmp_main_aquiz_item);

        }

        $outer_data = [

            0 => $inner_main_aquiz_items,

        ];

        $outer_places = [

            0 => '{[-inner_main_aquiz_items-]}',

        ];

        return str_replace($outer_places, $outer_data, $this->tmp_main_aquiz_outer);

    }

// данные викторины по ее идентификатору
    public function single_quiz_data($id)
    {

        $sql_quiz = "SELECT * FROM modx_quiz_names WHERE id=$id LIMIT 1";

        $quiz = $this->query($sql_quiz)[0];

        return $quiz;

    }

// данные всех вопросов викторины по ее идентификатору
    public function quiz_questions_data($id)
    {

        $sql_quiz_questions = "SELECT * FROM modx_quiz_questions WHERE quizId=$id";

        $questions = $this->query($sql_quiz_questions);

        return $questions;

    }


// получить количество вопросов в викторине по идентификатору викторины
    private function question_Count($quiz)
    {

        $data = $this->quiz_questions_data($quiz);
        $sql_question_Count = count($data);


        return $sql_question_Count;

    }

// данные вопроса по его номеру и идентификатору викторины
    public function single_question_data($quiz, $question)
    {

        $sql = "SELECT * FROM modx_quiz_questions WHERE quizId=$quiz AND quesNum=$question LIMIT 1";

        $single_questions = $this->query($sql)[0];

        return $single_questions;

    }

// получение всех вариантов ответа вопроса по его идентификатору
    public function variants_data($questionId)
    {

        $sql_variants_raw = "SELECT * FROM modx_quiz_variants WHERE questionId=$questionId";

        $variants_raw = $this->query($sql_variants_raw);

        $variants = [];

        foreach ($variants_raw as $var) {

            $variants[$var['varNum']] = $var;

        }

        return $variants;

    }

// получение всех вопросов конкретной викторины вместе с данными викторины
    public function get_quiz_questions($id)
    {

        $quiz = $this->single_quiz_data($id);
        $questions = $this->quiz_questions_data($id);
        $questions_block = '';
        $questionsOrder = [];

        foreach($questions as $q){

            $questionsOrder[$q['quesNum']] = $q;

        }



        for($i=1; $i<=count($questionsOrder); $i++){

            $ques_data = [

                0 => $questionsOrder[$i]['id'],
                1 => $questionsOrder[$i]['quesNum'],
                2 => $questionsOrder[$i]['question'],

            ];

            $ques_places = [

                0 => '{[-ques_id-]}',
                1 => '{[-ques_quesNum-]}',
                2 => '{[-ques_question-]}'

            ];

            $questions_block .= str_replace($ques_places, $ques_data, $this->tmp_questions_item);

        }


        $quiz_data = [

            0 => $questions_block,
            1 => $quiz['id'],
            2 => $quiz['name'],
            3 => $quiz['description']
        ];

        $quiz_places = [

            0 => '{[-questions_block-]}',
            1 => '{[-quiz_id-]}',
            2 => '{[-quiz_name-]}',
            3 => '{[-quiz_description-]}'
        ];

        return str_replace($quiz_places, $quiz_data, $this->tmp_questions_main);

    }

// вывод данных викторины по ее идентификтору и всех ее вопросов
    public function echo_quiz_questions($id)
    {

        return $this->get_quiz_questions($id);

    }

// получение данных редактирования конкретного вопроса по его номеру, конкретной викторины по ее идентификатору
    public function get_edit_question($quizId , $questionId)
    {

        // викторина по идентификатору
        $quiz = $this->single_quiz_data($quizId);

        // количество вопросов в этой викторине
        $quesCount = $this->question_Count($quizId);

        // один конкретный вопрос по номеру, конкретной викторины по идентификатору
        $ques = $this->single_question_data($quizId, $questionId);

        // все варианты конкретного вопроса
        $variants = $this->variants_data($ques['id']);

        // переход к следующему вопросу
        $next_lnk = ($questionId == $quesCount)?("/admin.php?quiz=$quizId&question=$questionId"):("/admin.php?quiz=$quizId&question=" .($questionId+1));
        // отключение/включение кнопки перехода к слудующему вопросу
        $next_lnk_class = ($questionId == $quesCount)?(" disabled "):("");


        // возврат к предыдущему вопросу
        $back_lnk = ($questionId == 1)?("/admin.php?quiz=$quizId&question=$questionId"):("/admin.php?quiz=$quizId&question=" .($questionId-1));
        // отключение/включение кнопки возврата к предыдущему вопросу
        $back_lnk_class = ($questionId == 1)?(" disabled "):(" ");


        // блок с вариантами ответов
        $variants_block = '';

        foreach ($variants as $var) {


            $var_data = [

                0 => $var['varNum'],
                1 => $var['variant'],
                2 => (($var['varNum']==1) or ($var['varNum']==2))?(''):$this->dell_variant_button,
            ];

            $var_places = [

                0 => '{[-varNum-]}',
                1 => '{[-variant-]}',
                2 => '{[-dell_variant_button-]}',
            ];


            $variants_block .= str_replace($var_places, $var_data, $this->tmp_edit_question_var_item);

        }


        $edit_data = [

            0 => $variants_block,
            1 => $quiz['id'],
            2 => $quiz['name'],
            3 => $ques['quesNum'],
            4 => $quesCount,
            5 => $ques['question'],
            6 => $ques['rightVariantNum'],
            7 => $ques['citation'],
            8 => $ques['comment'],
            9 => $next_lnk,
            10 => $back_lnk,
            11 => $next_lnk_class,
            12 => $back_lnk_class,

        ];

        $edit_places = [

            0 => '{[-variants_block-]}',
            1 => '{[-quiz_id-]}',
            2 => '{[-quiz_name-]}',
            3 => '{[-quesNum-]}',
            4 => '{[-quesCount-]}',
            5 => '{[-question-]}',
            6 => '{[-rightVariantNum-]}',
            7 => '{[-citation-]}',
            8 => '{[-comment-]}',
            9 => '{[-next-]}',
            10 => '{[-back-]}',
            11 => '{[-next-class-]}',
            12 => '{[-back-class-]}',

        ];

        return str_replace($edit_places, $edit_data, $this->tmp_edit_question_main);

    }

// вывод данных редактирования конкретного вопроса по его номеру, конкретной викторины по ее идентификатору
    public function echo_get_edit_question($quizId , $questionId)
    {

        return $this->get_edit_question($quizId , $questionId);

    }


// переключение видимости викторины
    private function quiz_Visibil_Switch($quizId)
    {

        $sql_quiz_Visibil_Switch = "SELECT display FROM modx_quiz_names WHERE id=$quizId LIMIT 1";


        $display = $this->query($sql_quiz_Visibil_Switch)[0];

        if($display['display'] == 1){

            $sql_update = "UPDATE  modx_quiz_names SET display=0 WHERE id=$quizId";

            $this->query($sql_update);


            if($this->query($sql_quiz_Visibil_Switch) != $display['display']){
                return 'Ok';
            } else {
                return 'Ошибка при записи в базу данных, перезагрузити страницу';
            }

        }else{

            $sql_update = "UPDATE  modx_quiz_names SET display=1 WHERE id=$quizId";
            $this->query($sql_update);

            if($this->query($sql_quiz_Visibil_Switch) != $display['display']){
                return 'Ok';
            } else {
                return 'Ошибка при записи в базу данных, перезагрузити страницу';
            }

        }

    }

// страница создания викторины
    public function addquiz()
    {

        return $this->tmp_add_quiz;

    }

// обработка запроса на создание викторины
    public function addquiz_create($quiz_name, $quiz_comment)
    {

    // сделать трим, стрип и прочие проверки введенных данных
        $name = strip_tags(stripslashes(trim($quiz_name)));
        $comment = strip_tags(stripslashes(trim($quiz_comment)));


    // проверка имени на повторение в базе данных
        $name_exist = $this->query("SELECT * FROM modx_quiz_names WHERE name='$name'")[0];

    // если есть отдать ошибку
        if(!empty($name_exist['name'])){
            return 'nameEXIST';
        }

    // сделать запись в базу данных и проверить
        $this->query("INSERT INTO modx_quiz_names (name, description, display) VALUES ('$name', '$comment', 0)");
        $name_exist = $this->query("SELECT * FROM modx_quiz_names WHERE name='$name'")[0];

    // Проверить запись
        if(empty($name_exist['name'])){

            return 'writeError';

        }

        return "/admin.php?newQuestion={$name_exist['id']}";
    }

// обработка запроса на удаление викторины
    public function dell_quiz($quizId)
    {

        $this->dell_questions($quizId);

        $this->query("DELETE FROM modx_quiz_names WHERE id=$quizId");

        $test_data = $this->query("SELECT * FROM modx_quiz_names WHERE id=$quizId LIMIT 1")[0];

        if(empty($test_data['id'])){
            return 'done';
        }

        return 'Неудалось удалить викторину, попробуйте обновить страницу';
    }


// удаление одного вопроса по его id
    public function dell_one_questions($quesId)
    {

        // получаем данные вопроса с конкретным номером, конкретной викторины
        $question = $this->query("SELECT * FROM modx_quiz_questions WHERE id='$quesId' LIMIT 1")[0];

        // удаляем все варианты ответов на вопрос по id полученного вопроса
        $this->dell_question_variants($quesId);

        // удаляем вопрос по id
        $this->query("DELETE FROM modx_quiz_questions WHERE id=$quesId");

        $test=$this->query("SELECT * FROM modx_quiz_questions WHERE id=$quesId");

        if(count($test)!=0){

            return "Неполучается удалить из БД вопрос под id '$quesId'\n" .$test['question'];
        }

        // пересчитываем номера вопросов
        $questions = $this->query("SELECT * FROM modx_quiz_questions WHERE quizId=" .$question['quizId']);
        $questionCount = count($questions);


        $quesOrder = [];

        // выставляем вопросы в правильном порядке
        foreach($questions as $ques){

            $quesOrder[$ques['quesNum']] = $ques;

        }

        $c = $questionCount+3;
        $ord = 1;
        $newQuestionsOrder = [];
        // выравниваем порядок вопросов
        for($i=1; $i<=$c; $i++){


            if(isset($quesOrder[$i]) === true){

                $newQuestionsOrder[$ord] = $quesOrder[$i];
                $ord++;
            }

        }


        $errors = '';
        // обновляем новые номера в базе данных
        for($i=1; $i<=$questionCount; $i++){

            $id = $newQuestionsOrder[$i]['id'];
            $sql = "UPDATE `modx_quiz_questions` SET `quesNum`='$i' WHERE `id`='$id'";
            $this->query($sql);

            $test = $this->query("SELECT * FROM modx_quiz_questions WHERE `id`='$id' LIMIT 1")[0];

            if($test['quesNum']!=$i){

                $errors .= "Не получается изменить порядковый номер вопроса под индексом $id \n" .$test['quesNum'] .". " .$test['question'] ."\n\n";

            }

            if($errors!=''){
                return $errors;
            }

        }

        return 'done';
    }


// удаление вопросов викторины
    public function dell_questions($quizId)
    {

        // перебрать все вопросы и удалить все их варианты по id
        $questions = $this->query("SELECT * FROM modx_quiz_questions WHERE quizId=$quizId");
        foreach($questions as $q){

            $this->dell_question_variants($q['id']);
        }

        // удалить все вопросы по id
        $this->query("DELETE FROM modx_quiz_questions WHERE quizId=$quizId");

        // проверка удаление вопросов
        $error = '';
        foreach($questions as $q){

            $test = $this->query("SELECT * FROM modx_quiz_questions WHERE quizId=" .$q['id'] ." LIMIT 1")[0];

            if($test['id'] == $q['id']){
                $error .= "не удалось удалить вопрос с индексом {$q['id']}\n {$q['question']}  \n\n";
            }

        }

        // если есть ошибки, вывести сообщение и остановить программу
        if($error!=''){

            echo $error;
            exit();

        }

    }

// удаление вариантов вопроса
    public function dell_question_variants($quesId)
    {

        // удаление всех вариантов по id вопроса
        $this->query("DELETE FROM modx_quiz_variants WHERE questionId=$quesId");

        // проверка вариантов на существование
        $test_data = $this->query("SELECT * FROM modx_quiz_variants WHERE questionId=$quesId LIMIT 1")[0];

        if(count($test_data) != 0){
            echo "Неполучилось удалить варианты ответа на вопрос под индексом $quesId";
            exit();
        }

    }

// редактирование названия викторины
    public function edit_name_quiz($quizId)
    {

        $sql_edit_name_quiz = "SELECT * FROM modx_quiz_names WHERE id=$quizId LIMIT 1";

    // выбрать данные викторины
        $data = $this->query($sql_edit_name_quiz)[0];

    // заменить данными плэйсхолдеры в шаблоне или добавить их

        $quiz_data = [

            0 => $data['id'],
            1 => $data['name'],
            2 => $data['description']
        ];

        $quiz_places = [

            0 => '{[-id-]}',
            1 => '{[-name-]}',
            2 => '{[-comment-]}'
        ];


        return str_replace($quiz_places, $quiz_data, $this->tmp_new_quiz);

    }

// сохранение изменения названия и комментария викторины
    private function update_quiz($quizId, $quizName, $quizComment)
    {

        $isName = $this->query("SELECT * FROM modx_quiz_names WHERE name='$quizName'")[0];

    // проверяем имя на существование
        if(empty($isName['name'])==true){

            $this->query("UPDATE modx_quiz_names SET name='$quizName', description='$quizComment' WHERE id=$quizId");

            $isRecord = $this->query("SELECT * FROM modx_quiz_names WHERE name='$quizName'")[0];

            if($isRecord['id']==$quizId){

                return "Записал";

            } else {

                return 'Ошибка при записи данных в базу данных.';

            }

        } else if($isName['id']==$quizId) {

            if($isName['description'] != $quizComment){

                $this->query("UPDATE modx_quiz_names SET description='$quizComment' WHERE id=$quizId");

                $isRecord = $this->query("SELECT * FROM modx_quiz_names WHERE name='$quizName'")[0];

                if($isRecord['description']==$quizComment){

                    return "Записал";

                } else {

                    return 'Ошибка при записи данных в базу данных.';

                }

            }

            return "Ничего не изменено, все данные такие же";

        } else {

            return 'Такое имя викторины уже существует';

        }

    }

// Новый вопрос. Вывод данных для нового вопроса
    public function new_question($quizId)
    {
        // сделать запрос на имя викторины по идентификатору
        $quiz = $this->single_quiz_data($quizId);

        // количество вопросов в этой викторине
        $quesCount = $this->question_Count($quizId);


        // получить необходимые данные

        $edit_data = [

            0 => $quiz['id'],
            1 => $quiz['name'],
            2 => $quesCount,
            3 => $quesCount+1,

        ];

        $edit_places = [

            0 => '{[-quiz_id-]}',
            1 => '{[-quiz_name-]}',
            2 => '{[-quesCount-]}',
            3 => '{[-quesNum-]}',

        ];

        return str_replace($edit_places, $edit_data, $this->tmp_new_question);

    }

// сохранение изменения в вопросе
    private function save_edit_questions()
    {

    // получение данных

        $newNumber = $_POST['newNumber'];
        $currentNumber = $_POST['currentNumber'];
        $quizId = $_POST['quizId'];
        $question = $_POST['question'];
        $amountVariants = $_POST['amountVariants'];
        $rightAnswer = $_POST['rightAnswer'];
        $cite = $_POST['cite'];
        $comment = $_POST['comment'];
        $variants = [];
        $currentQues = ($newNumber==0)?($currentNumber):($newNumber);


    // получение вариантов вопроса
        for($i=1; $i<=$amountVariants; $i++){

            $v = "var$i";

            $variants[$i] = $_POST[$v];

        }


    // запись измененных данных (без вариантов)
        $this->query("UPDATE modx_quiz_questions SET question='$question', citation='$cite', comment='$comment', rightVariantNum='$rightAnswer' WHERE quizId='$quizId' AND quesNum='$currentNumber'");

        $test = $this->query("SELECT * FROM modx_quiz_questions WHERE quizId='$quizId' AND quesNum='$currentNumber' LIMIT 1")[0];

        $errors = '';

        if($test['question']!=$question) {
            $errors .= "Ошибка базы данных, вопрос не сохранен\n";
        }

        if($test['citation']!=$cite) {
            $errors .= "Ошибка базы данных, цитата не сохранена\n";
        }

        if($test['comment']!=$comment) {
            $errors .= "Ошибка базы данных, комментарий не сохранен\n";
        }

        if($test['rightVariantNum']!=$rightAnswer) {
            $errors .= "Ошибка базы данных, 'правильный ответ' не сохранен\n";
        }

        if($errors != ''){
            echo $errors;
            exit;
        }


    // запись вариантов с обработкой
        $questionId = $this->query("SELECT id FROM modx_quiz_questions WHERE quizId='$quizId' AND quesNum='$currentNumber' LIMIT 1")[0]['id'];

        $previousVars = $this->query("SELECT * FROM modx_quiz_variants WHERE questionId=$questionId");
        $previousVarsCount = count($previousVars);


        if($previousVarsCount==0) {
        // если в БД нет записей с этими вариантами - используем цикл с колиеством новых вариантов
        //  используем импуты ко всем вариантам

            for($i=1; $i<=$amountVariants; $i++){

                $this->query("INSERT INTO modx_quiz_variants (varNum, questionId, variant) VALUE ('$i', '$questionId', '{$variants[$i]}')");

                $testInput = $this->query("SELECT * FROM modx_quiz_variants WHERE questionId='$questionId' AND varNum='$i' LIMIT 1")[0];

                if($testInput['variant']!=$variants[$i]){
                    return "Возникла ошибка при записи в базу данных варианта \n {$variants[$i]}";
                }

            }


        }elseif($amountVariants<$previousVarsCount) {
        // если новых вариантов меньше используем цикл с колиеством существующих записей
        // если вариант с таким индексом есть - обновить данные по индексу
        // если варианта с таким индексом нет - удалить данные по индексу

            for($i=1; $i<=$previousVarsCount; $i++){

                if(isset($variants[$i])==true){

    //                $previousVars[$i-1])==true

                    $this->query("UPDATE modx_quiz_variants SET variant='{$variants[$i]}' WHERE questionId='$questionId' AND varNum='$i'");

                    $testInput = $this->query("SELECT * FROM modx_quiz_variants WHERE questionId='$questionId' AND varNum='$i' LIMIT 1")[0];

                    if($testInput['variant']!=$variants[$i]){
                        return "Возникла ошибка при записи в базу данных варианта \n {$variants[$i]}";
                    }


                }else {

                    $this->query("DELETE FROM modx_quiz_variants WHERE questionId='$questionId' AND varNum='$i'");

                    $testInput = $this->query("SELECT * FROM modx_quiz_variants WHERE questionId='$questionId' AND varNum='$i' LIMIT 1")[0];

                    if($testInput['variant']!=$variants[$i]){
                        return "Возникла ошибка при записи в базу данных варианта \n {$variants[$i]}";
                    }

                }
            }


        }else {
        // если новых вариантов больше - используем цикл с колиеством новых вариантов
        // если запись с таким индексом существует - обновить данные по индексу,
        // если запись с таким индексом нет - добавить данные

            for($i=1; $i<=$amountVariants; $i++){

                if(isset($previousVars[$i-1])==true){


                    $this->query("UPDATE modx_quiz_variants SET variant='{$variants[$i]}' WHERE questionId='$questionId' AND varNum='$i'");

                    $testInput = $this->query("SELECT * FROM modx_quiz_variants WHERE questionId='$questionId' AND varNum='$i' LIMIT 1")[0];

                    if($testInput['variant']!=$variants[$i]){
                        return "Возникла ошибка при записи в базу данных варианта \n {$variants[$i]}";
                    }

                }else {

                    $this->query("INSERT INTO modx_quiz_variants (varNum, questionId, variant) VALUE ('$i', '$questionId', '{$variants[$i]}')");

                    $testInput = $this->query("SELECT * FROM modx_quiz_variants WHERE questionId='$questionId' AND varNum='$i' LIMIT 1")[0];

                    if($testInput['variant']!=$variants[$i]){
                        return "Возникла ошибка при записи в базу данных варианта \n {$variants[$i]}";
                    }

                }
            }

        }

// Смена номера вопроса, если новый номер не является нулем
        if($newNumber!=0){

           $this->chQuestionNum($quizId, $currentNumber, $newNumber);

        }


        return "/admin.php?quiz=$quizId&question=$currentQues";

    }

// создание нового вопроса
    private function save_new_questions()
    {

        // получение данных

        $newNumber = $_POST['newNumber'];
        $currentNumber = $_POST['currentNumber'];
        $quizId = $_POST['quizId'];
        $question = $_POST['question'];
        $amountVariants = $_POST['amountVariants'];
        $rightAnswer = $_POST['rightAnswer'];
        $cite = $_POST['cite'];
        $comment = $_POST['comment'];
        $variants = [];
        $currentQues = ($newNumber==0)?($currentNumber):($newNumber);


        // получение вариантов ответа на вопрос
        for($i=1; $i<=$amountVariants; $i++){

            $v = "var$i";

            $variants[$i] = $_POST[$v];

        }


        $currentNumber = $this->question_Count($quizId) + 1;

        // запись данных в БД (только основные данные, без вариантов)
        $this->query("INSERT INTO modx_quiz_questions (question, citation, comment, rightVariantNum, quizId, quesNum) VALUES ('$question', '$cite', '$comment', '$rightAnswer', '$quizId', '$currentNumber')");

        $test = $this->query("SELECT * FROM modx_quiz_questions WHERE quizId='$quizId' AND quesNum='$currentNumber' LIMIT 1")[0];

        $errors = '';

        if($test['question']!=$question) {
            $errors .= "Ошибка базы данных, вопрос не сохранен\n";
        }

        if($test['citation']!=$cite) {
            $errors .= "Ошибка базы данных, цитата не сохранена\n";
        }

        if($test['comment']!=$comment) {
            $errors .= "Ошибка базы данных, комментарий не сохранен\n";
        }

        if($test['rightVariantNum']!=$rightAnswer) {
            $errors .= "Ошибка базы данных, 'правильный ответ' не сохранен\n";
        }

        if($errors != ''){
            echo $errors;
            exit;
        }


        // запись вариантов с обработкой

        // получение id записываемого вопроса
        $questionId = $this->query("SELECT id FROM modx_quiz_questions WHERE quizId='$quizId' AND quesNum='$currentNumber' LIMIT 1")[0]['id'];

        for($i=1; $i<=$amountVariants; $i++){

            $this->query("INSERT INTO modx_quiz_variants (varNum, questionId, variant) VALUE ('$i', '$questionId', '{$variants[$i]}')");

            $testInput = $this->query("SELECT * FROM modx_quiz_variants WHERE questionId='$questionId' AND varNum='$i' LIMIT 1")[0];

            if($testInput['variant']!=$variants[$i]){
                return "Возникла ошибка при записи в базу данных варианта \n {$variants[$i]}";
            }

        }



// Смена номера вопроса, если новый номер не является нулем
        if($newNumber!=0){

            $this->chQuestionNum($quizId, $currentNumber, $newNumber);

        }


        return "/admin.php?quiz=$quizId&question=$currentQues";
//        /admin.php?quiz=$quizId&question=$currentQues
    }

// смена номера вопроса
    private function chQuestionNum($quizId, $oldQuestionNum, $newQuestionNum)
    {

        $questions = $this->query("SELECT * FROM modx_quiz_questions WHERE quizId='$quizId'");
        $questionsCount = count($questions);
        $oldQuestionsOrder = [];
        $newQuestions = [];
        $chQuesId = '';
        $chQuesData = '';

// находим id вопроса и выбираем его данные в переменную
        foreach($questions as $ques){

            if($ques['quesNum']==$oldQuestionNum){
                $chQuesId = $ques['id'];
                $chQuesData = $ques;
            }
        }

// выравниваем порядок вопросов
        foreach($questions as $ques){

            $oldQuestionsOrder[$ques['quesNum']] = $ques;

        }


// отделяем заданный вопрос от остальных
        $otherQues = [];
        $new = 1;
        for($i=1; $i<=$questionsCount; $i++){

            if($oldQuestionsOrder[$i]['id']!=$chQuesId){

                $otherQues[$new] = $oldQuestionsOrder[$i];
                $new++;

            }

        }


        $old = 1;

        for($i=1; $i<=$questionsCount; $i++){

            if($i==$newQuestionNum){

                $newQuestions[$i] = $chQuesData;

            }else {

                $newQuestions[$i] = $otherQues[$old];
                $old++;

            }

        }


        foreach($newQuestions as $num=>$item){

            $id = $item['id'];

            $this->query("UPDATE modx_quiz_questions SET quesNum='$num' WHERE id='$id'");

        }


        $tstData = '';

        foreach ($newQuestions as $num=>$item) {

            $ques = str_replace("\n", "", $item['question']);

            $tstData .= $num .' ' .$ques ."\n";

        }

//        echo $tstData;

    }

// хлебные крошки
    public function aquiz_breadcrumbs()
    {

        $breadcrumbs = '';

        $breadcrumbs .= "<ol class='breadcrumb'>";

        switch($this->get_content_switch())
        {


            case '':

                // Главная страница, список всех викторин
                $breadcrumbs .=  "<li class='active'>Редактирование викторин</li>";
                break;


            case 'quiz':

                $quiz = $this->single_quiz_data($this->quizId);

                // Страница со всеми вопросами определенной викторины
                $breadcrumbs .=  "<li><a href='/admin.php'>Редактирование викторин</a></li>";
                $breadcrumbs .=  "<li class='active'>{$quiz['name']}</li>";
                break;


            case 'questions':

                $quiz = $this->single_quiz_data($this->quizId);
                $ques = $this->questId;

                // Редактируемый вопрос викторины
                $breadcrumbs .=  "<li><a href='/admin.php'>Редактирование викторин</a></li>";
                $breadcrumbs .=  "<li><a href='/admin.php?quiz={$quiz['id']}'>{$quiz['name']}</a></li>";
                $breadcrumbs .=  "<li class='active'>$ques</li>";

                break;


            case 'addquiz':

                // Добавление новой викторины
                $breadcrumbs .=  "<li><a href='/admin.php'>Редактирование викторин</a></li>";
                $breadcrumbs .=  "<li class='active'>новая викторина</li>";
                break;


            case 'editQuizName':

                // Редактирование имени викторины
                $breadcrumbs .=  "<li><a href='/admin.php'>Редактирование викторин</a></li>";
                $breadcrumbs .=  "<li class='active'>изменение имени викторины</li>";
                break;


            case 'newQuestion':

                $quiz = $this->single_quiz_data($this->quizId);

                // Добавление нового вопроса
                $breadcrumbs .=  "<li><a href='/admin.php'>Редактирование викторин</a></li>";
                $breadcrumbs .=  "<li><a href='/admin.php?quiz={$quiz['id']}'>{$quiz['name']}</a></li>";
                $breadcrumbs .=  "<li class='active'>новый вопрос</li>";
                break;


            default:

                $breadcrumbs .=  "Если вы видите эту надпись, значить произошла какая то ошибка, и скорее всего эта ошибка в переключателе данных страницы";


        }



        $breadcrumbs .=  "</ol>";






        return $breadcrumbs;

    }


}


$quiz = new quiz;

$quiz->check_request();