<?php
// Protected route: only reachable while logged in.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Home</title>
<style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 320px; text-align: center; }
    h1 { font-size: 1.4rem; margin-top: 0; }
    p { color: #555; font-size: 0.9rem; }
    button { width: 100%; margin-top: 1.5rem; padding: 0.6rem; background: #c62828; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
    button:hover { background: #a01f1f; }
</style>
</head>
<body>

<script>
    if (localStorage.getItem('isLoggedIn') !== 'true') {
        window.location.replace('login.php');
    }
</script>

<div class="card">
    <h1>Welcome!</h1>
    <p id="welcomeMessage">You are logged in.</p>
    <button id="logoutButton">Logout</button>
</div>

<script>
    const storedUser = JSON.parse(localStorage.getItem('registeredUser') || 'null');
    if (storedUser && storedUser.email) {
        document.getElementById('welcomeMessage').textContent = 'You are logged in as ' + storedUser.email;
    }

    document.getElementById('logoutButton').addEventListener('click', function () {
        localStorage.removeItem('isLoggedIn');
        window.location.href = 'login.php';
    });
</script>

</body>
</html>
