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
        <form>
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name">
                <p class="error-text">This field is required</p>
            </div>
            <div>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone">
                <p class="error-text">Make sure you have entered correct phone format</p>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                <p class="error-text">Make sure you have entered correct email address</p>
            </div>
            <div>
                <label for="time">Time and date of the start:</label>
                <input type="time" id="time" name="time">
                <input type="date" id="date" name="date">
                <p class="error-text">This field is required</p>
            </div>
            <div>
                <label for="note">Note</label>
                <textarea id="note" name="note" rows="5"></textarea>
            </div>
            <div>
                <div class="msg"></div>
            </div>
            <div>
                <input type="submit" id="submit">
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/script.js"></script>
</body>
</html>