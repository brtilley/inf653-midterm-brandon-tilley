<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brandon Tilley - INF653 - Midterm Project</title>
</head>
<body>
    <h1>Brandon Tilley - INF653 - Midterm Project</h1>
    <?php
echo '<pre>';
print_r(getenv('SITE_URL'));
echo '<br>';
print_r($_SERVER);
echo '</pre>';

phpinfo();
?>
</body>
</html>