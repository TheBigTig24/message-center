<!DOCTYPE html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="../styles/register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@700&family=Schoolbell&display=swap" rel="stylesheet">
    <script src="../scripts/register.js"></script>
    <script src="https://kit.fontawesome.com/8284d2aa07.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="full-container">
        <div id="login-container">
            <h1 class="outfit-bold">Register</h1>
            <form>
                <div class="input-container">
                    <label for="email" class="schoolbell-regular">Email</label>
                    <input type="text" id="email-input" name="email" required>
                </div>
                <div class="input-container">
                    <label for="username" class="schoolbell-regular">Username</label>
                    <input type="text" id="username-input" name="username" required>
                </div>
                <div class="input-container">
                    <label for="password" class="schoolbell-regular">Password</label>
                    <input type="text" id="password-input" name="password" required>
                </div>
                <div class="input-container">
                    <label for="confirm-password" class="schoolbell-regular">Confirm Password</label>
                    <input type="text" id="confirm-password-input" name="confirm-password" required>
                </div>
                <input type="submit" id="form-submit" class="schoolbell-regular" value="Send"></input>
            </form>
            <p>
                <a href="login.php" class="schoolbell-regular">Already have an account? Sign in</a>
            </p>
        </div>
    </div>
</body>