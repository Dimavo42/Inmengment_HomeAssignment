
<?php
   $path = __DIR__ .'/../../storage/image.png';
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Dima </title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<body>
    <?php  foreach($allUsers as $user):  ?>
        <div>
            <h2><?= $user['name'] ?></h2>
            <p><?= $user['content'] ?></p>
            <img src="<?= __DIR__ .'/../../storage/image.png' ?>" alt="User image">
        </div>
    <?php endforeach; ?>
</body>
</html>