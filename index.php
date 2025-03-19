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
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];


    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }
    
echo '<pre>';
print_r(getenv('https://inf653-midterm-brandon-tilley.onrender.com/'));
echo '<br>';
print_r($_SERVER);
echo '</pre>';

phpinfo();
?>
</body>
</html>