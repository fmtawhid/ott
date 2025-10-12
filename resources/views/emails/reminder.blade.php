<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Movie or TV Show Reminder</title>
</head>
<body>
    <p>Hello {{ $user->first_name }} {{$user->last_name}},</p>

    <p>A new movie or TV show you saved is releasing soon! It's just {{ setting('upcoming') }} days away. Mark your calendar and get ready for some great entertainment!
    </p>
    
    <p>Thank you,</p>
</body>
</html>