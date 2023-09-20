<?php
$error_message = urldecode(filter_input(INPUT_GET,'error'));
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <p>An error has occured: <?php print $error_message; ?><p>
    </body>
</html>