 
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
            	<?= $status->getUser()->getName() ?>
                <?= date_format($status->getDate(), 'd/m/Y g:i A')?>
            </h4>
            <p><?= $status->getMessage() ?></p>

            <?php if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated']
                && $_SESSION['user_id'] === $status->getUser()->getId()) {
                echo "<form action='/statuses/".$status->getId()."' method='POST'>";
                echo "	<input type='hidden' name='_method' value='DELETE'>";
                echo "  <input type='hidden' name='_method' value='DELETE'>";
                echo "  <input type='submit' value='Delete'>";
                echo "</form>";
            }?>
     </div>
 </div>
 </body>
 </html>

