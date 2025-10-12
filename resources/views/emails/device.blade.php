<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Device Login Alert</title>
</head>
<body>
    <p>Hello {{ $user->first_name }} {{$user->last_name}},</p>

    <p>We detected a login to your account from a new device. If this wasn't you, please reset your password immediately.
    </p>
    
    <p>Thank you,</p>
</body>
</html>