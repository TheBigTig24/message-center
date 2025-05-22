<!DOCTYPE html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../styles/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@700&family=Schoolbell&display=swap" rel="stylesheet">
    <script src="../scripts/login.js"></script>
    <script src="https://kit.fontawesome.com/8284d2aa07.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="full-container">
        <div id="login-container">
            <h1 class="outfit-bold">Sign In</h1>
            <form>
                <div class="input-container">
                    <label for="username" class="schoolbell-regular">Username</label>
                    <input type="text" id="username-input" name="username" required>
                </div>
                <div class="input-container">
                    <label for="password" class="schoolbell-regular">Password</label>
                    <input type="text" id="password-input" name="password" required>
                </div>
                <input type="submit" id="form-submit" class="schoolbell-regular" value="Send"></input>
            </form>
        </div>
    </div>
</body>