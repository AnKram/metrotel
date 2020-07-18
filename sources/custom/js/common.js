$(document).ready(function() {
    let files;

    $('#file').on('change', function(){
        files = this.files;
    });


    // registration data processing

    $('#btn-registration').on('click', function () {
        let send_flag = true;

        let user_email = $('#email');
        let user_login = $('#login');
        let user_pass = $('#pass');

        // captcha
        let captcha = grecaptcha.getResponse();

        if (!captcha.length) {
            $('#recaptchaError').text('Заполните форму google captcha');
            send_flag = false;
        } else {
            $('#recaptchaError').text('');
        }

        let values = {
            login: user_login.val(),
            email: user_email.val(),
            pass: user_pass.val(),
        };

        for (let key in values) {
            if (!validate(values[key], key)) {
                inputError(key);
                send_flag = false;
            } else {
                inputCorrect(key);
            }
        }

        if (send_flag) {
            let data = {
                form: 'create',
                user_login: values['login'],
                user_email: values['email'],
                user_pass: values['pass'],
                captcha: captcha
            };

            sendAjaxAuthorizationFromFormsToServer(data);
        }
    });


    // login data processing

    $('#btn-in').on('click', function () {
        let send_flag = true;
        let type = 'login';

        // captcha
        let captcha = grecaptcha.getResponse();

        if (!captcha.length) {
            $('#recaptchaError').text('Заполните форму google captcha');
            send_flag = false;
        } else {
            $('#recaptchaError').text('');
        }

        let user_login = $('#login').val();
        let user_pass = $('#pass').val();

        if (validate(user_login, 'email')) {
            type = 'email';
            inputCorrect('login');
        } else if (validate(user_login, 'login')) {
            inputCorrect('login');
        } else {
            inputError('login');
            send_flag = false;
        }

        if (!validate(user_pass, 'pass')) {
            inputError('pass');
            send_flag = false;
        } else {
            inputCorrect('pass');
        }

        if (send_flag) {
            let data = {
                form: 'in',
                user_pass: user_pass,
                captcha: captcha
            };

            if (type === 'email') {
                data['user_email'] = user_login;
            } else {
                data['user_login'] = user_login;
            }

            sendAjaxAuthorizationFromFormsToServer(data);
        }
    });


    // exit from system

    $('#btn-exit').on('click', function () {
        let data = {form: 'exit'};
        sendAjaxAuthorizationFromFormsToServer(data);
    });

    // redirect to new contact page
    $('#btn-new').on('click', function () {
        window.location.replace('http://' + location.hostname + '/contacts/new');
    });

    // redirect to update page
    $('#btn-contact-to-update').on('click', function () {
        let id = $('#btn-contact-to-update').parent().attr('id');
        window.location.replace('http://' + location.hostname + '/contacts/update/' + id);
    });

    // delete contact
    $('#btn-contact-delete').on('click', function () {
        let id = $('#btn-contact-delete').parent().attr('id');

        let data = new FormData();
        data.append('action', 'delete');
        data.append('id', id);

        sendAjaxContactFromFormsToServer(data);
    });


    // create contact

    $('#btn-contact-create').on('click', function () {
        event.stopPropagation();
        event.preventDefault();

        let name = $('#name').val();
        let surname = $('#surname').val();
        let num1 = $('#num1').val();
        let num2 = $('#num2').val();
        let email = $('#email').val();

        let send_flag = true;

        if (name.length === 0) {
            inputError('name');
            send_flag = false;
        } else {
            inputCorrect('name');
        }

        if (email.length > 0 && !validate(email, 'email')) {
            inputError('email');
            send_flag = false;
        } else {
            inputCorrect('email');
        }

        if (num1.length > 0) {
            inputCorrect('num1');
        }
        if (num2.length > 0) {
            inputCorrect('num2');
        }
        if (surname.length > 0) {
            inputCorrect('surname');
        }

        if (send_flag) {
            let data = new FormData();
            data.append('action', 'create');
            data.append('name', name);
            data.append('surname', surname);
            data.append('num1', num1);
            data.append('num2', num2);
            data.append('email', email);

            if (typeof files != 'undefined' && files.length === 1) {
                data.append('file', files[0]);
            }

            sendAjaxContactFromFormsToServer(data);
        }
    });


    // update contact

    $('#btn-contact-update').on('click', function () {
        event.stopPropagation();
        event.preventDefault();

        let name = $('#name').val();
        let surname = $('#surname').val();
        let num1 = $('#num1').val();
        let num2 = $('#num2').val();
        let email = $('#email').val();
        let id = $('#btn-contact-update').parent().attr('class');

        let send_flag = true;

        if (name.length === 0) {
            inputError('name');
            send_flag = false;
        } else {
            inputCorrect('name');
        }

        if (email.length > 0 && !validate(email, 'email')) {
            inputError('email');
            send_flag = false;
        } else {
            inputCorrect('email');
        }

        if (num1.length > 0) {
            inputCorrect('num1');
        }
        if (num2.length > 0) {
            inputCorrect('num2');
        }
        if (surname.length > 0) {
            inputCorrect('surname');
        }

        if (send_flag) {
            let data = new FormData();
            data.append('action', 'update');
            data.append('id', id);
            data.append('name', name);
            data.append('surname', surname);
            data.append('num1', num1);
            data.append('num2', num2);
            data.append('email', email);

            if (typeof files != 'undefined' && files.length === 1) {
                data.append('file', files[0]);
            }

            sendAjaxContactFromFormsToServer(data);
        }
    });


    // open contact

    $('.btn-open-contact').each(function (index, value) {
        $(this).on('click', function () {
            let id = $(this).attr('id');
            window.location.replace('http://' + location.hostname + '/contacts/item/' + id);
        });
    });


    // sort with get params

    $('#btn-sort').on('click', function () {
        let sort = $('#inputSort').val();
        let sequence = $('#inputSequence').val();
        sort = '?sort=' + sort;
        sequence = '&sequence=' + sequence;
        window.location.replace('http://' + location.hostname + '/contacts' + sort + sequence);
    });


    // sort with ajax

    $('body').on('click', '#btn-sort-ajax', function () {
        let sort = $('#inputSort').val();
        let sequence = $('#inputSequence').val();

        let data = new FormData();
        data.append('sort', sort);
        data.append('sequence', sequence);

        $.ajax({
            url: '/contacts/ajax_sort',
            dataType: 'json',
            type: 'post',
            processData : false,
            contentType: false,
            data: data,
            success: function(respond){
                if((respond.result)) {
                    $('#contacts-block').html(generateList(respond.data.list, respond.data.upload_path));
                    $('#btns-block').html(genereteBtnGroup(respond.data));
                } else {
                    console.log(respond.error);
                }
            },
            error: function(jqXHR, status){
                console.log('error AJAX: ' + status, jqXHR);
            }
        });
    });
});

// send json ajax (post) to server
function sendAjaxAuthorizationFromFormsToServer(data) {
    let json = JSON.stringify(data);
    $.ajax({
        url: '/user/form_end_point',
        dataType: 'json',
        type: 'post',
        contentType: 'application/x-www-form-urlencoded',
        data: {'data':json},
        success: function(data){
            if(String(data.result) === 'ok' && String(data.url).length > 0) {
                window.location.replace('http://' + location.hostname + data.url);
            } else if (String(data.result) === 'error'){
                grecaptcha.reset();

                if (data.errors.login === 'incorrect') {
                    inputError('login');
                }
                if (data.errors.login === 'not uniq') {
                    inputError('login');
                    $('#ifb-login').html('Такой логин уже существует');
                }
                if (data.errors.email === 'incorrect') {
                    inputError('email');
                }
                if (data.errors.email === 'not uniq') {
                    inputError('email');
                    $('#ifb-email').html('Такой email уже существует');
                }
                if (data.errors.pass === 'incorrect') {
                    inputError('pass');
                }
                if (data.errors.in === 'error') {
                    inputError('login');
                    inputError('pass');
                    $('#ifb-login').html('Неверный логин или пароль');
                    $('#ifb-pass').html('Неверный логин или пароль');
                }
                if (data.errors.captcha) {
                    $('#recaptchaError').text(data.errors.captcha);
                }
            }
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });
}

function sendAjaxContactFromFormsToServer(data) {
    $.ajax({
        url: '/contacts/contact_end_point',
        dataType: 'json',
        type: 'post',
        processData : false,
        contentType: false,
        data: data,
        success: function(data){
            if(String(data.result) === 'ok' && String(data.url).length > 0) {
                window.location.replace('http://' + location.hostname + data.url);
            } else if (String(data.result) === 'error') {
                if (data.errors.email === 'incorrect') {
                    inputError('email');
                }
                if (data.errors.name === 'incorrect') {
                    inputError('name');
                }
                if (data.errors.file) {
                    $('#fileError').text(data.errors.file);
                }
            }
        },
        error: function(jqXHR, status){
            console.log('error AJAX: ' + status, jqXHR);
        }
    });
}

function inputError(input_selector) {
    $('#' + input_selector).removeClass('is-valid');
    $('#' + input_selector).addClass('is-invalid');
}

function inputCorrect(input_selector) {
    $('#' + input_selector).removeClass('is-invalid');
    $('#' + input_selector).addClass('is-valid');
}

function validate(string, type) {
    let regs = {
        login: /^([a-z0-9]){2,20}$/i,
        email: /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
        pass: /^(?=^.{4,20}$)(?=.*\d)(?=.*[a-z])(?!.*\s).*$/i,
    };

    return regs[type].test(string);
}

function generateList(data, upload_path) {
    if(!data) {
        return '<p>Список пуст</p>';
    }

    let html = '';

    for (let i in data) {
        html += '<div class="row contact">' +
            '<div class="col-8">' +
            '<span class="name">' + data[i]['name'] + '</span>';
        if (data[i]['surname'] !== null) {
            html += '<span class="surname">' + data[i]['surname'] + '</span>';
        }
        if (data[i]['first_number'] !== null) {
            html += '<span class="surname">' + data[i]['first_number'] + '</span>';
        }
        if (data[i]['image'] !== null) {
            html += '<img src="/' + upload_path + data[i]['image'] + '" class="image" alt="ups"/>';
        }

        html += '</div>' +
            '<div class="col-4">' +
            '<button id="' + data[i]['id'] + '" type="button" class="btn btn-primary btn-open-contact">Подробнее</button>' +
            '</div>' +
            '</div>';
    }

    return html;
}

function genereteBtnGroup(data) {
    let html = '<div class="col-3">\n' +
        '<button id="btn-new" type="button" class="btn btn-primary">Новая запись</button>\n' +
        '</div>\n' +
        '<div class="col-3">\n' +
        '<select id="inputSort" class="form-control">\n';

    let selected = '';
    for (let key in data['sort']) {
        if (key === data['sort_selected']) {
            selected = 'selected';
        } else {
            selected = '';
        }

        html += '<option value="' + key + '" ' + selected + '>' + data['sort'][key] + '</option>\n';
    }

    html += '</select>\n' +
        '</div>\n' +
        '<div class="col-3">\n' +
        '<select id="inputSequence" class="form-control">\n';

    for (let key in data['sequence']) {
        if (key === data['sequence_selected']) {
            selected = 'selected';
        } else {
            selected = '';
        }

        html += '<option value="' + key + '" ' + selected + '>' + data['sequence'][key] + '</option>\n';
    }

    html += '</select>\n' +
        '</div>\n' +
        '<div class="col-3">\n' +
        '<button id="btn-sort-ajax" type="button" class="btn btn-primary">Сортировать</button>\n' +
        '</div>';

    return html;
}

function cl(a) {
    console.log(a);
}