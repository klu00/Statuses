
<!DOCTYPE html>

<html>
<head></head>
<body>
<div>
    <div>
        <h1>Statuses</h1>
    </div>
    <div>
        <h2>Post a new status : </h2>
        <form action="/statuses" method="POST">
            <label>
                <?php if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'])
                    echo "Post with ".$_SESSION['user_name']." account :";
                else
                    echo "Post with Anonymous account :";
                ?>
            </label><br/>
            <label for="message">Message:</label>
            <textarea name="message"></textarea>
            <input type="submit" value="Tweet!">
        </form>
    </div>
    <div>
        <?php if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'])
            echo "<a href='/statuses?user=".$_SESSION['user_id']."'>Go to my statuses -></a>";
        ?>
        <h2>All the statuses <small><a href="/statuses?orderBy=status_date$desc&limit=0$5">Last 5</a></small></h2>
        <ul>
            <?php foreach($parameters['array'] as $status) : ?>
                <li>
                    <h4>
                        <?= $status->getUser()->getName() ?>
                        (<?= $status->getDate()->format('Y-m-d H:i:s') ?>) :<br/>
                        <?= $status->getMessage() ?>
                        <br/>
                        <a href="/statuses/<?= $status->getId() ?>">Go -></a>
                    </h4>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div>
        <h4>
            <?php if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'])
                echo "<a href='/logout'>Disconnect</a>";
            else {
                echo "<a href='/login'>Connect to the app</a></br>";
                echo "You have no account ? <a href='/register'>Register</a>";
            }
            ?>
        </h4>
    </div>
</div>
</body>
</html>
