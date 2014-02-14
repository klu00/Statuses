<!DOCTYPE html>

<html>
<head></head>
<body>
    <a href="/">Go back to statuses list -></a>
    <h1>Connect to the app</h1>
    <form method="post" action="/login">
        <label for="user">Username</label>
        <input type="text" name="user">
        <br/>
        <label for="password">Password</label>
        <input type="text" name="password">
        <br/>
        <input type="submit" value="Login !">
        <h4>You have no account ? <a href="/register">Register !</a></h4>
    </form>
</body>
</html>
