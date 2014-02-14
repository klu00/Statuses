 
<!DOCTYPE html>

<html>
<head></head>
<body>
<div>
	<div>
    	<h1>Status</h1>
   	</div>
   	<div>
        <a href="/statuses">Go back to statuses list</a>
 	 	<?php
   			$status = $parameters['status'] ?>
    		<h4>
            	<?= $status->getUser() ?>
                <?= date_format($status->getDate(), 'd/m/Y g:i A')?>
            </h4>
            <p><?= $status->getMessage() ?></p>
            <form action="/statuses/<?= $status->getId() ?>" method="POST">
   				<input type="hidden" name="_method" value="DELETE">
			    <input type="submit" value="Delete">
			</form>
     </div>
 </div>
 </body>
 </html>

