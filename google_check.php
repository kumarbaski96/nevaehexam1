<!DOCTYPE html>
<html>
<head>
    <title>Google reCAPTCHA Example</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <form action="verify_recaptcha.php" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
        </div>
        
        <!-- reCAPTCHA widget -->
        <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div>
        
        <button type="submit" class="btn btn-success">Login</button>
    </form>
</body>
</html>
