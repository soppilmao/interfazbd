<?php
$host = "plop.inf.udec.cl";
$port = "5432";
$dbname = "bdi2022aj";
$user = "bdi2022aj";
$password = "bdi2022aj";
$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
$dbconn = pg_connect($connection_string);
if (!$dbconn) {
    echo "No se pudo conectar a la base de datos";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script defer src="main.js"></script>
    <title>Where to watch</title>
</head>
<body>
    <div id="search-section">
        <h1 id="title">WHERE TO WATCH</h1>
        <form action="search.php" method="GET" id="form">
            <input type="text" name="text" id="search-text">
            <select name="filter" id="search-category">
                <option value="nombre">Nombre pelicula</option>
                <option value="genero">Genero</option>
                <option value="director">Director</option>
                <option value="actor">Actor</option>
                <option value="plataforma">Plataforma</option>
            </select>
            <input type="submit" value="Consultar" id="submit">
        </form>
    </div>
</body>

</html>