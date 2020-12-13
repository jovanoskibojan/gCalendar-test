<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="assets/style.css" rel="stylesheet" type="text/css" />
    <title>Meeting scheduler</title>
</head>
<body>
    <div class="main-form">
        <form id="form">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="name">
                <p class="error-text name_error"></p>
            </div>
            <div>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" class="phone">
                <p class="error-text phone_error"></p>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="email">
                <p class="error-text email_error"></p>
            </div>
            <div>
                <label for="time_input">Time and date of the start:</label>
                <div class="time date">
                    <input type="time" id="time_input" name="time">
                    <input type="date" id="date" name="date">
                </div>
                <p class="error-text time_error date_error"></p>
            </div>
            <div>
                <label for="note">Note</label>
                <textarea id="note" name="note" rows="5"></textarea>
            </div>
            <div>
                <div id="alert" class="msg"></div>
            </div>
            <div>
                <input type="submit" id="submit">
            </div>
        </form>
    </div>
    <div id="login" class="main-form">
        <div class="content">
            <p style="margin-bottom: 40px">Click here to open the following link in your browser and paste the received code in the box below:<p>
            <input type="text" name="code" placeholder="Paste the code here"><br>
            <input type="submit" id="send_code">
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/script.js"></script>
</body>
</html>