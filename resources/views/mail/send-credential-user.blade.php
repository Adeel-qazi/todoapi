<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Credentials</title>
</head>
<body>
    <p>Hello {{ $user['name'] }},</p>
    
    <p>Your account has been created with the following credentials:</p>
    
    <p><strong>Email:</strong> {{ $user['email'] }}</p>
    <p><strong>Password:</strong> {{ ($password) ? $password : '' }}</p>
    
    <p>Please login using these credentials.</p>
    
    <p>Thank you,</p>
    <p>The Admin</p>
    
</body>
</html>
