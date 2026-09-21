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
<title>Register</title>
<style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 320px; }
    h1 { font-size: 1.4rem; margin-top: 0; }
    label { display: block; margin-top: 1rem; font-size: 0.9rem; color: #333; }
    input { width: 100%; padding: 0.5rem; margin-top: 0.25rem; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
    button { width: 100%; margin-top: 1.5rem; padding: 0.6rem; background: #2e7d32; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
    button:hover { background: #256428; }
    .error { color: #c62828; font-size: 0.85rem; margin-top: 0.25rem; min-height: 1em; }
    .success { color: #2e7d32; font-size: 0.9rem; margin-top: 1rem; text-align: center; }
    .link { margin-top: 1rem; font-size: 0.85rem; text-align: center; }
    .link a { color: #2e7d32; }
</style>
</head>
<body>

<div class="card">
    <h1>Create an Account</h1>
    <form id="registerForm" novalidate>
        <label for="email">Email</label>
        <input type="text" id="email" name="email" autocomplete="off">
        <div class="error" id="emailError"></div>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="off">
        <div class="error" id="passwordError"></div>

        <label for="confirmPassword">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" autocomplete="off">
        <div class="error" id="confirmPasswordError"></div>

        <button type="submit">Register</button>
        <div class="success" id="successMessage"></div>
    </form>
    <div class="link">Already have an account? <a href="login.php">Login here</a></div>
</div>

<script>
    const form = document.getElementById('registerForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        document.getElementById('emailError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        document.getElementById('confirmPasswordError').textContent = '';
        document.getElementById('successMessage').textContent = '';

        const email = emailInput.value.trim();
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        let hasError = false;

        if (!email) {
            document.getElementById('emailError').textContent = 'Email is required.';
            hasError = true;
        } else if (!emailPattern.test(email)) {
            document.getElementById('emailError').textContent = 'Please enter a valid email address.';
            hasError = true;
        }

        if (!password) {
            document.getElementById('passwordError').textContent = 'Password is required.';
            hasError = true;
        } else if (password.length < 6) {
            document.getElementById('passwordError').textContent = 'Password must be at least 6 characters.';
            hasError = true;
        }

        if (confirmPassword !== password) {
            document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
            hasError = true;
        }

        if (hasError) {
            return;
        }

        localStorage.setItem('registeredUser', JSON.stringify({ email: email, password: password }));

        document.getElementById('successMessage').textContent = 'Registration successful! Redirecting to login...';

        setTimeout(function () {
            window.location.href = 'login.php';
        }, 1200);
    });
</script>

</body>
</html>
