



// количество вопросов
var quesCount = $('#quesCount').text();

// данные полученные с сервера
var responseData = '';

//// номер правильного варианта
//var rightVariantNum;
//
//// Цитата
//var citation;
//
//// Комментарий
//var comment;
//
//// Идентификатор викторины
//var quiz_id;



// Основная функция викторины
$('.variant').bind('click', quiz);
function quiz(){

// получение данных викторины

    // номер текущего вопроса
    var quesNum = $('#quesNum').text();

    // ответ выбранный пользователем
    var answer = $(this).attr('varNum');

    // индекс правильного ответа (1-Да, 2-Нет), по умолчанию 0
    var ansvIndex = 0;

    // проверка данных викторины
    //alert( "Всего вопросов: "+quesCount +"\nТекущий номер вопроса: "+quesNum +"\nНажатый номер: " + answer +"\nПравильный вариант: "+rightVariantNum +"\nЦитата: "+ citation +"\nКомментарий: "+ comment +"\nИндекс викторины: "+ quiz_id);

    // кнопки с вариантами делаем меньше и отключаем их
    var variant = $('.variant');
    variant.attr('class', 'variant btn btn-default btn-block');
    variant.attr('disabled', true);
    $(variant).unbind('click', quiz);

    // кнопку продолжения делаем не активной (на всякий случай)
    $('#nextBtn').prop('disabled', true);


    // сравниваем ответы
    if(Number(answer) == Number(rightVariantNum)){
        // если ответ правильный

        // индекс ответа устанавливается 1 (правильно)
        ansvIndex = 1;

        // делаем рамку овтета зеленым цветом
        $(this).attr('class', $(this).attr('class') + ' green_border');

        // отображается блок правильного ответа
        $('#correctAnswer').attr('class', 'visible_block');

        // в блок записывается цитата и комментарий
        $('.rCite').text(citation);
        $('.comment').text(comment);

    }else {
        // если ответ не правильный

        // индекс ответа устанавливается 2 (нерпавильно)
        ansvIndex = 2;

        // делаем рамку овтета зеленым цветом
        $(this).attr('class', $(this).attr('class') + ' red_border');

        // отображается блок неправильного ответа
        $('#incorrectAnswer').attr('class', 'visible_block');

        // в блок записывается цитата и комментарий
        $('.rCite').text(citation);
        $('.comment').text(comment);
    }

    // кнопка продолжения становится видимой
    $('#nextBtnBlock').attr('class', 'visible_block')

    // Отправляем данные на сервер
    var posting = $.post( '/', { 'quesAnswer[]': [quiz_id, quesNum, quesCount, ansvIndex]} );

    // устанавливается таймер на получение ответа с сервера
    var timeout = setTimeout(function(){

        // если в течении 5 секунд ответ с сервера не пришел, появляется блок с предупреждением
        $('#error_block').attr('class', 'visible_block')

                    }, 5000);

    // обработка данных полученных с сервера
    posting.done(function( data ) {

        // отключается таймер timeout
        clearTimeout(timeout);

        // кнопка продолжения становится активной
        $('#nextBtn').prop('disabled', false);

        // убирается блок предупреждения об ошибки со связью (неважно, был он или небыло)
        $('#error_block').attr('class', 'hidden_block');

        // присвоенные данные присваиваются глобальной переменной responseData для работы других функций
        if(data =='done'){

            responseData = 'done';

        }else{
            responseData = $.parseJSON(data);
        }
    });

}


$('#nextBtn').bind('click', nextBtn);
function nextBtn(){

    if(responseData == 'done'){
        //alert('Спасибо что прошли викорину!');
        //window.location = '/';

        //$('#variants_block').empty();
        //$('#nextBtn').prop('disabled', true);
        //$('#correctAnswer').attr('class', 'hidden_block');
        //$('#incorrectAnswer').attr('class', 'hidden_block')
        //$('#nextBtnBlock').attr('class', 'hidden_block')

        $('#quesPanel').attr('class', 'hidden');

        $('#endQuiz').attr('class', 'show')

    }

    $('#variants_block').empty();
    $('#nextBtn').prop('disabled', true);
    $('#correctAnswer').attr('class', 'hidden_block');
    $('#incorrectAnswer').attr('class', 'hidden_block')
    $('#nextBtnBlock').attr('class', 'hidden_block')

    //alert(responseData);

    $('#question').text(responseData.ques);

    $('#quesNum').text(responseData.quesNum)

    //var div = $('<div/>', {
    //
    //    text: 'variants_block',
    //
    //});

    //$('#variants_block').append("dfdsf");

    //responseData.variants.forEach(function(variant, num){
    //    $('#variants_block').append(num +' ' + variant+'<br>');
    //});

    //<div class='variant btn btn-default btn-block' varNum='{[-varNum-]}'>{[-variant-]}</div>

    $.each(responseData.variants, function(num, variant) {

        var div = $('<div/>', {

            class: 'variant btn btn-lg btn-default btn-block',
            varNum: num,
            text: variant

        });

        $(div).on('click', quiz);

        $('#variants_block').append(div);

    });

    rightVariantNum = responseData.rightVariantNum;
    citation = responseData.citation;
    comment = responseData.comment;


    //variants

    //    'rightVariantNum' => $ques['rightVariantNum'],
    //    'citation' => $ques['citation'],
    //    'comment' => $ques['comment'],
    //    'varCount' => $varCount



}

