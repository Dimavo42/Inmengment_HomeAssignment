<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Dima </title>
<meta name="viewport" content="width=device-width,initial-scale=1">

<body>
    <?php foreach ($allUsers as $user) :  ?>
        <div>
            <h2><?= $user['name'] ?></h2>
            <p><?= $user['content'] ?></p>
            <img src="<?php realpath(STORAGE_PATH . '/' . 'image.png');
             //Have to fix it not working as well ?>" width="300" height="200" alt="Image" />
        </div>
    <?php endforeach; ?>
</body>

</html>

