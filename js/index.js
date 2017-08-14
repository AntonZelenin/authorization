$(function() {
    $.post(
        '/scripts/checkCookie.php',
        function(data) {
            if (data == []) {
                return;
            }

            data = JSON.parse(data);
            var status = data['status'];

            if (status == 'ok') {
                var user = data['payload'];
                showUser(user);
            }
        }
    );
});

function logIn() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    if (email == '') {
        $('#email').css('border-color', 'red');
        $('#warning').text('Enter email');

        return;
    } else if (password == '') {
        $('#password').css('border-color', 'red');
        $('#warning').text('Enter password');

        return;
    }

    var remember = document.getElementById('cb-remember').checked;

    $.post(
        '/scripts/authorize.php',
        {
            email: email,
            password: password,
            remember: remember
        },
        function(data) {
            data = JSON.parse(data);
            var status = data['status'];

            if  (status == 'ok') {
                var user = data['payload'];
                showUser(user);
            } else if(status == 'blocked') {
                var seconds = data['payload'];

                $('#warning').text("You've made to many attemtps. Wait " + seconds + " seconds and try again");
            } else {
                $('#warning').text("Wrong email or password");
            }
        }
    );
}

function showUser(user) {
    var main = document.getElementById('main');

    var userId = user['id'];
    var lastVisit = user['lastVisit'];

    var tmpl = document.getElementById('info-template').content.cloneNode(true);
    tmpl.querySelector('#user-id').innerText = "Your id is " + userId;
    tmpl.querySelector('#last-visit').innerText = "Your last visit was " + lastVisit;

    main.innerHTML = '';
    main.appendChild(tmpl);
}

function logOut() {
    $.post(
        '/scripts/logOut.php',
        function() {
            window.location.href = "index.php";
        }
    );
}

$("body").on("focus", "input, textarea", function() {
    $(this).css('border-color', '#1ab188');
});

$("body").on("focusout", "input, textarea", function() {
    $(this).css('border-color', '#a0b3b0');
});
