<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Sign Up Confirmation</title>
</head>
<body>
    <h1>Thanks for Signing up!</h1>
    
        <p>We just need to <a href="{{ url('register/confirm/' . $user->token ) }}">confirm your email address</a> real quick!</p>
</body>
</html>
