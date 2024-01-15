<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Approval</title>
</head>
<body>
    <p>Hello {{ $client['name'] }},</p>
    
    <p>Your account has been {{ ($client['email_verified'] == 1) ? 'approved' : 'disapproved' }}</p>
    
    <p>Thank you,</p>
    <p>Regards, Admin</p>
</body>
</html>
