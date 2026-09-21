<?php
// Unprotected route: logged-in users don't belong here (enforced via PHP session).
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 320px; }
    h1 { font-size: 1.4rem; margin-top: 0; }
    label { display: block; margin-top: 1rem; font-size: 0.9rem; color: #333; }
    input { width: 100%; padding: 0.5rem; margin-top: 0.25rem; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
    button { width: 100%; margin-top: 1.5rem; padding: 0.6rem; background: #1565c0; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
    button:hover { background: #0d47a1; }
    .error { color: #c62828; font-size: 0.85rem; margin-top: 0.25rem; min-height: 1em; }
    .link { margin-top: 1rem; font-size: 0.85rem; text-align: center; }
    .link a { color: #1565c0; }
</style>
</head>
<body>

<div class="card">
    <h1>Login</h1>
    <form id="loginForm" novalidate>
        <label for="email">Email</label>
        <input type="text" id="email" name="email" autocomplete="off">
        <div class="error" id="emailError"></div>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="off">
        <div class="error" id="passwordError"></div>

        <button type="submit">Login</button>
    </form>
    <div class="link">Don't have an account? <a href="register.php">Register here</a></div>
</div>

<script>
    const form = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        document.getElementById('emailError').textContent = '';
        document.getElementById('passwordError').textContent = '';

        const email = emailInput.value.trim();
        const password = passwordInput.value;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email) {
            document.getElementById('emailError').textContent = 'Email is required.';
            return;
        }

        if (!emailPattern.test(email)) {
            document.getElementById('emailError').textContent = 'Please enter a valid email address.';
            return;
        }

        const storedUser = JSON.parse(localStorage.getItem('registeredUser') || 'null');

        if (!storedUser || storedUser.email.toLowerCase() !== email.toLowerCase()) {
            document.getElementById('emailError').textContent = 'No account found with this email. Please register first.';
            return;
        }

        if (!password) {
            document.getElementById('passwordError').textContent = 'Password is required.';
            return;
        }

        if (storedUser.password !== password) {
            document.getElementById('passwordError').textContent = 'Incorrect password.';
            return;
        }

        fetch('session_login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: storedUser.email })
        })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.status === 'ok') {
                    localStorage.setItem('isLoggedIn', 'true');
                    window.location.href = 'index.php';
                } else {
                    document.getElementById('passwordError').textContent = 'Something went wrong. Please try again.';
                }
            })
            .catch(function () {
                document.getElementById('passwordError').textContent = 'Something went wrong. Please try again.';
            });
    });
</script>

</body>
</html>
