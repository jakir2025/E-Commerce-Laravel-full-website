<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@300;500;700&display=swap');

:root {
    --neon-pink: #ff2a6d;
    --neon-blue: #05d9e8;
    --dark-bg: #0d0221;
}

body {
    font-family: 'Rajdhani', sans-serif;
    background-color: var(--dark-bg);
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-container {
    background-color: rgba(0, 0, 0, 0.5);
    padding: 20px;
    border-radius: 8px;
    border: 2px solid var(--neon-blue);
    box-shadow: 0 0 10px var(--neon-blue), inset 0 0 10px var(--neon-blue);
    width: 300px;
}

.login-container h2 {
    text-align: center;
    color: var(--neon-pink);
    font-family: 'Orbitron', sans-serif;
    text-shadow: 0 0 5px var(--neon-pink);
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: var(--neon-blue);
    text-shadow: 0 0 5px var(--neon-blue);
}

.form-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid var(--neon-blue);
    border-radius: 4px;
    box-sizing: border-box;
    background-color: rgba(0, 0, 0, 0.3);
    color: white;
}

.form-group button {
    background-color: var(--neon-pink);
    color: black;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    font-family: 'Orbitron', sans-serif;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.form-group button:hover {
    background-color: #ff598f;
}

.error-message {
    color: var(--neon-pink);
    margin-top: 10px;
    text-align: center;
    text-shadow: 0 0 5px var(--neon-pink);
}

    </style>
    
</head>
<body>
    <div class="login-container">
        <h2>LOGIN</h2>
        <form id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
            <div id="error-message" class="error-message"></div>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>