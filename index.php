<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Form</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <script src='js/jquery-3.2.1.min.js'></script>
        <script src="js/index.js"></script>

        <div class="main" id="main">
            <span class="header">Log In</span>

            <input type="email" id="email"  placeholder="Email" />
            <input type="password" id="password" placeholder="Password" />

            <div class="remember">
                <input type="checkbox" id="cb-remember" /><label id="remember-me" >Remember me</label>
            </div>

            <div class="warning">
                <label id="warning"></label>
            </div>

            <input type="button" class="button" value="Log In" onclick="logIn()" onclick="logIn()" />
        </div>

        <template id="info-template">
            <div class="info">
                <label class="user-info" id="user-id"></label>
                <label class="user-info" id="last-visit"></label>
            </div>
            <input type="button" class="button" onclick="logOut()" value="Log out" />
        </template>
    </body>
</html>
