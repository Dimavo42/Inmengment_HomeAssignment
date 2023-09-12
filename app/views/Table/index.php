<!DOCTYPE html>
<html>

<head>
    <title>Dima</title>
</head>

<body>
    <table border="1">
        <thead>
            <tr>
                <th>תאריך</th>
                <th>שעה</th>
                <th>כמות הפוסטים לאותה שעה</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tableResult as $post) : ?>
                <tr>
                    <td><?= $post['month'] ?></td>
                    <td><?= $post['time'] ?></td>
                    <td><?= $post['count'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>