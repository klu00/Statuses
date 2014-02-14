
<!DOCTYPE html>

<html>
<head></head>
<body>
<div>
    <?php if (isset($_SESSION['is_authenticated'])) echo "<h5>Connected with pseudonyme ".$_SESSION['user_name']."</h5>"?>
    <div>
        <h1>Statuses</h1>
    </div>
    <div>
        <h2>Post a new status : </h2>
        <form action="/statuses" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username">

            <label for="message">Message:</label>
            <textarea name="message"></textarea>

            <input type="submit" value="Tweet!">
        </form>
    </div>
    <div>
        <a href="/statuses?userName=toto">Go to my statuses -></a>
        <h2>All the statuses</h2>
        <ul>
            <?php foreach($parameters['array'] as $status) : ?>
                <li>
                    <h4>
                        <?= $status->getUser() ?>   
                        (<?= $status->getDate()->format('Y-m-d H:i:s') ?>) :
                        <?= $status->getMessage() ?>
                        <a href="/statuses/<?= $status->getId() ?>">Go -></a>
                    </h4>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div>
        <h4>You have no account ? <a href="/register">Register</a>
            <?php if(!isset($_SESSION['is_authenticated']))
                    echo "<a href='/login'>Connect to the app</a>";
                   else
                       echo "<a href='/logout'>Disconnect to the app</a>";
            ?></h4>
    </div>
</div>
</body>
</html>
