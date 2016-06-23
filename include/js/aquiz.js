
// проверка на целое число
function isInt(n) {
    return n % 1 === 0;
}


// переключает видимость/невидимость викторины
$('.quiz_Visibil_Switch').bind( 'click', quiz_Visibil_Switch );
function quiz_Visibil_Switch() {

    var button = $(this);
    var quiz_item = $(button.parents()[0]).find(".tmp_main_aquiz_item")[0];
    var quiz_item_outer = $(button.parents()[0]);
    var quiz_Switch = $(quiz_item).attr("quizId");
    
	$.post("/admin.php", {quiz_Switch: quiz_Switch})
	.done(function(data) {
    	    
	    if(data == 'Ok'){
	        
            if(quiz_item_outer.attr("class") == 'outer_tmp_main_aquiz_item'){
                
                quiz_item_outer.attr("class", 'outer_tmp_main_aquiz_item_OFF');
                button.attr('class', 'quiz_Visibil_Switch btn btn-xs btn-link');
                button.html('Включить');
                
            }else {
                
                quiz_item_outer.attr("class", 'outer_tmp_main_aquiz_item');
                button.attr('class', 'quiz_Visibil_Switch btn btn-xs btn-default');
                button.html('Выключить');
            }
	        
	    } else {
	        
	        alert("Data Loaded: " + data);
	        
	    }
    	    
	});
}


// удаление викторины
$('.dell_quiz').bind( 'click', dell_quiz );
function dell_quiz(){
    
    var button = $(this);
    
// находим основной блок
    var quiz_item = $(button.parents()[0]).find(".tmp_main_aquiz_item")[0];

    var quiz_item_outer = $(button.parents()[0]);

// находим id блока
    var quiz_id = $(quiz_item).attr("quizId");

    var posting = $.post( "/admin.php", { dell_quiz: 'dell' , id: quiz_id } );

    posting.done(function( data ) {

        // alert(data);
        
        if(data == 'done'){
            $(quiz_item_outer).remove();
        }else {
            alert('Ошибка. Попробуйте обновить страницу');
        }
     
        
    });

}

// удаление вопроса викторины
$('.dell_question').bind( 'click', dell_question );
function dell_question(){

// получить данные
    var quesId = $(this).attr('quesId');

// отправить пост на сервер
    var posting = $.post( "/admin.php", { dell_ques: quesId } );

// обработка полученного ответа
    posting.done(function( data ) {

        //alert(data);

        if(data == 'done'){

            // если все успешно - обновить
            window.location.reload();
        }else {

            // если неуспешно - сообщить об этом
            alert('Ошибка. Неполучилось удалить запись');
        }

    });




}

// добавление новой викторины (обработка формы)
$("#add_quiz_form").submit(function(event) {
  
    event.preventDefault();
  
    var $form = $( this );
    var name = $form.find( '#quiz_name' ).val();
    var comment = $form.find( '#quiz_comment' ).val();
    var action = $form.attr( 'action' );
  
    var posting = $.post( action, { add_quiz: 'add' , name: name, comment: comment } );
  
    posting.done(function( data ) {

    if(data == 'nameEXIST'){
      
        $('#add_quiz_error').css('display', 'block');
      
    }else if(data == 'writeError'){
      
        alert('Ошибка записи в базу данных, попробуйте обновить страницу');
      
    } else {
      
        location.href = data;
      
    }
  });
});


// изменение имени и комментария викторины (обработка формы)
$("#edit_quiz_name_form").submit(function(event) {
  
    event.preventDefault();
  
    var $form = $( this );
    
    var id = $form.find( '#quiz_id' ).val();
    var name = $form.find( '#quiz_name' ).val();
    var comment = $form.find( '#quiz_comment' ).val();
    

    var posting = $.post( '/admin.php', { update_quiz: 'update', id: id , name: name, comment: comment } );
  
    posting.done(function( data ) {

        alert(data);

  });
});


// Редактирование вопроса викторины (обработка формы)
$('#edit_question_form').submit(function(event){

   event.preventDefault();
   
    var form = $( this ); // форма

    // собираем нужные данные
        var newNumber = $('#edit_chNumber').val(); // новый номер вопроса
        var currentNumber = Number($('#currentNumber').text()); // текущий номер вопроса
        var maxNumber = $('#maxNumber').text(); // максимальный номер вопроса
        var question = $('#question').val(); // сам вопрос
        var amountVariants = $('#variants_block').children().length; // количество всех вариантов ответа на вопрос викторины
        var rightAnswer = $('#edit_right_answer').val();
        var cite = $('#edit_cite').val();
        var comment = $('#edit_comment').val();
        var quizId = $('#edit_quizId').val();



    // проверка нового номера вопроса викторины

        // проверка на число/строка
            if(!$.isNumeric(newNumber)){

                alert(
                    "Номер вопроса\nдолжен быть целым числом,\n" +
                    "а Вы ввели '" +newNumber +"'\n"


                );

                $('#edit_chNumber').focus();

                return false;
            }

        // проверка на ноль
            if(Number(newNumber)==0){

                alert(
                    "Номер вопроса\nне может равняться нулю"


                );

                $('#edit_chNumber').focus();

                return false;
            }

        // проверка на целове/дробное
            if(!isInt(Number(newNumber))){

                alert(
                    "Номер вопроса должен быть целым числом,\n" +
                    "а Вы ввели дробное " +newNumber +"\n"

                );

                $('#edit_chNumber').focus();

                return false;
            }

        // проверка на максимальное число
            if(Number(newNumber)>Number(maxNumber)) {
                alert(
                    "Ошибка в номере вопроса \n" +
                    "Номер не может быть больше '" + maxNumber +
                    "'\n\n" +
                    "В викторине всего '" + maxNumber + "' вопросов\n" +
                    "а Вы задали вопросу '" + newNumber + "' номер.\n\n" +
                    "Исправте эту досадную ошибку"
                );

                $('#edit_chNumber').focus();

                return false;
            }



    // проверка нового номера правильного ответа вопроса викторины

        // проверка на число/строка
            if(!$.isNumeric(rightAnswer)){

                alert(
                    "'Правильный ответ'\nдолжен быть целым числом,\n" +
                    "а Вы ввели '" +rightAnswer +"'\n"


                );

                $('#edit_right_answer').focus();

                return false;
            }

        // проверка на ноль
            if(Number(rightAnswer)==0){

                alert(
                    "'Правильный ответ'\nне может равняться нулю"


                );

                $('#edit_right_answer').focus();

                return false;
            }

        // проверка на целове/дробное
            if(!isInt(Number(rightAnswer))){

                alert(
                    "'Правильный ответ' должен быть целым числом,\n" +
                    "а Вы ввели дробное " +rightAnswer +"\n"

                );

                $('#edit_right_answer').focus();

                return false;
            }

        // проверка на максимальное число
            if(Number(rightAnswer)>Number(amountVariants)) {
            alert(
                "Ошибка в 'правильном ответе' вопроса \n" +
                "'Правильный ответ' не может быть больше '" + amountVariants +
                "'\n\n" +
                "В вопросе всего '" + amountVariants + "' вариантов\n" +
                "а Вы указали '" + rightAnswer + "' вариант.\n\n" +
                "Исправте эту досадную ошибку"
            );

            $('#edit_right_answer').focus();

            return false;
        }



    // Проверка newNumber, менять номер вопроса (и всех других соответственно) или ненужно
        if(Number(newNumber)==Number(currentNumber)){

            newNumber=0;

        }


    var data = {

        edit_question_form: "edit_question_form",
        quizId: quizId,
        newNumber: newNumber,
        currentNumber: currentNumber,
        maxNumber: maxNumber,
        question: question,
        amountVariants: amountVariants,
        rightAnswer: rightAnswer,
        cite: cite,
        comment: comment

    };

    // обработка вариантов ответа (добавление их в отсылаемый запрос
    for(var ind=1; ind<=amountVariants; ind++){

        var varName = "var" + ind;
        var elementName = "input[name=" +varName+ "]";
        //var elementValue = form.find(elementName)[0].val();

        data[varName] = $(form.find(elementName)[0]).val();

    }




    // отправляем данные на сервер
    var posting = $.post( '/admin.php', data );

    // todo работаю здесь
    // todo Обрабатываем полученные с сервера данные
    posting.done(function( data ) {

        //alert(data);
        window.location = data;
    });
   

    //alert(data.comment);

});


// Добавление нового вопроса викторины (обработка формы)
$('#new_question_form').submit(function(event){

    event.preventDefault();

    var form = $( this ); // форма

    // собираем нужные данные
    var newNumber = $('#edit_chNumber').val(); // новый номер вопроса
    var currentNumber = Number($('#currentNumber').text()); // текущий номер вопроса
    var maxNumber = currentNumber; // максимальный номер вопроса
    var question = $('#question').val(); // сам вопрос
    var amountVariants = $('#variants_block').children().length; // количество всех вариантов ответа на вопрос викторины
    var rightAnswer = $('#edit_right_answer').val();
    var cite = $('#edit_cite').val();
    var comment = $('#edit_comment').val();
    var quizId = $('#edit_quizId').val();



    // проверка нового номера вопроса викторины

    // проверка на число/строка
    if(!$.isNumeric(newNumber)){

        alert(
            "Номер вопроса\nдолжен быть целым числом,\n" +
            "а Вы ввели '" +newNumber +"'\n"


        );

        $('#edit_chNumber').focus();

        return false;
    }

    // проверка на ноль
    if(Number(newNumber)==0){

        alert(
            "Номер вопроса\nне может равняться нулю"


        );

        $('#edit_chNumber').focus();

        return false;
    }

    // проверка на целове/дробное
    if(!isInt(Number(newNumber))){

        alert(
            "Номер вопроса должен быть целым числом,\n" +
            "а Вы ввели дробное " +newNumber +"\n"

        );

        $('#edit_chNumber').focus();

        return false;
    }

    // проверка на максимальное число
    if(Number(newNumber)>Number(maxNumber)) {
        alert(
            "Ошибка в номере вопроса \n" +
            "Номер не может быть больше '" + maxNumber +
            "'\n\n" +
            "В викторине всего '" + maxNumber + "' вопросов\n" +
            "а Вы задали вопросу '" + newNumber + "' номер.\n\n" +
            "Исправте эту досадную ошибку"
        );

        $('#edit_chNumber').focus();

        return false;
    }



    // проверка нового номера правильного ответа вопроса викторины

    // проверка на число/строка
    if(!$.isNumeric(rightAnswer)){

        alert(
            "'Правильный ответ'\nдолжен быть целым числом,\n" +
            "а Вы ввели '" +rightAnswer +"'\n"


        );

        $('#edit_right_answer').focus();

        return false;
    }

    // проверка на ноль
    if(Number(rightAnswer)==0){

        alert(
            "'Правильный ответ'\nне может равняться нулю"


        );

        $('#edit_right_answer').focus();

        return false;
    }

    // проверка на целове/дробное
    if(!isInt(Number(rightAnswer))){

        alert(
            "'Правильный ответ' должен быть целым числом,\n" +
            "а Вы ввели дробное " +rightAnswer +"\n"

        );

        $('#edit_right_answer').focus();

        return false;
    }

    // проверка на максимальное число
    if(Number(rightAnswer)>Number(amountVariants)) {
        alert(
            "Ошибка в 'правильном ответе' вопроса \n" +
            "'Правильный ответ' не может быть больше '" + amountVariants +
            "'\n\n" +
            "В вопросе всего '" + amountVariants + "' вариантов\n" +
            "а Вы указали '" + rightAnswer + "' вариант.\n\n" +
            "Исправте эту досадную ошибку"
        );

        $('#edit_right_answer').focus();

        return false;
    }



    // Проверка newNumber, менять номер вопроса (и всех других соответственно) усли он изменен
    if(Number(newNumber)==Number(currentNumber)){

        newNumber=0;

    }


    var data = {

        new_question_form: "new_question_form",
        quizId: quizId,
        newNumber: newNumber,
        currentNumber: currentNumber,
        maxNumber: maxNumber,
        question: question,
        amountVariants: amountVariants,
        rightAnswer: rightAnswer,
        cite: cite,
        comment: comment

    };

    // обработка вариантов ответа (добавление их в отсылаемый запрос)
    for(var ind=1; ind<=amountVariants; ind++){

        var varName = "var" + ind;
        var elementName = "input[name=" +varName+ "]";
        //var elementValue = form.find(elementName)[0].val();

        data[varName] = $(form.find(elementName)[0]).val();

    }


    // отправляем данные на сервер
    var posting = $.post( '/admin.php', data );

    // обрабатываем полученный результат (переходим на форму редактирования созданного вопроса)
    posting.done(function( data ) {

        //alert(data);
        window.location = data;
    });


    //alert(data.comment);

});


// удаление итема варианта ответа на вопрос викторины
$('.dell_var_item').bind( 'click', dell_var_item );
function dell_var_item(){
    
    var button = $(this);
    var item = button.parents()[0];
    var varsBlock = $('#variants_block');
    
    $(item).remove();
    
    var varsBlockLength = varsBlock.children().length;
    
    var label = varsBlock.find('label');
    var input = varsBlock.find('input');

    var num=1;
    $(label).text(function(index, text){
    
        text = num;
        num++;
        return text;
        
    });
    
    
    num=1;
    $(label).attr("for", function(index, text){
    
        text = 'var'+num;
        num++;
        return text;
        
    });
    
    num=1;
    $(input).attr("name", function(index, text){
    
        text = 'var'+num;
        num++;
        return text;
        
    });

    $('#edit_right_answer').val('');

}


// добавление нового поля варианта ответа на вопрос викторины
$('#add_variant').bind( 'click', add_variant );
function add_variant(){
    
    var varsBlock = $('#variants_block');
    
    var varsBlockLength = varsBlock.children().length;
    
    var varNum = ++varsBlockLength;

    var div = $('<div/>', {
        
        class: 'variants_block',
        
    });
    
    var label = $('<label/>', {
       
       class: 'label_variant',
       for: 'var' +varNum,
       text: varNum,
        
    });
    
    var input = $('<input/>', {
        
        class: 'edit_variant',
        name: 'var' +varNum,
        type: 'text',
        placeholder: 'Укажите вариант ответа',
        required: '',
        
    });
    
    var span = $('<span/>', {
       
       class: 'dell_var_item btn btn-xs btn-danger',
       text: 'удалить',
        
    });
    
    $(span).on('click', dell_var_item);

    div.append(label);
    div.append(input);
    div.append(span);
    varsBlock.append(div);
    

}





