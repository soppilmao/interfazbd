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

$text = htmlspecialchars($_GET['text']);
$filter = htmlspecialchars($_GET['filter']);

//echo json_encode(array(0 => $text, 1 => $filter));
$query;

if ($filter == "nombre") {
    $query = "SELECT * FROM movies.película AS p WHERE p.nombre_película = '$text'";
} elseif ($filter == "genero") {
    $query = "SELECT * FROM movies.película AS p, movies.pertenece AS pa, movies.género AS g WHERE g.nombre_género = '$text' AND p.id_película = pa.id_película AND pa.nombre_género = g.nombre_género";
} elseif ($filter == "director") {
    $query = "SELECT * FROM movies.película AS p, movies.dirige AS di, movies.director AS d WHERE d.nombre_director = '$text' AND p.id_película = di.id_película AND di.id_director = d.id_director";
} elseif ($filter == "actor") {
    $query = "SELECT * FROM movies.película AS p, movies.participa AS pa, movies.actor AS a WHERE a.nombre_actor = '$text' AND p.id_película = pa.id_película AND pa.id_actor = a.id_actor";
} elseif ($filter == "plataforma") {
    $query = "SELECT * FROM movies.película AS p, movies.contiene AS co, movies.servicio_de_streaming AS ss WHERE ss.nombre_servicio = '$text' AND  co.nombre_servicio = ss.nombre_servicio AND co.id_película = p.id_película";
}

$result = pg_query($dbconn, $query);

if (!$result) {
    echo pg_last_error($dbconn);
    exit;
}

$data = pg_fetch_all($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <style>
        .search-result {
            display: block;
        }
    </style>
</head>
<body>
    <?php
        echo "<h1>$filter: $text</h1>";
        echo "<br>";
    ?>
    <form action="movie.php" method="GET" id="form">
        <?php
            foreach($data as $movie) {
                $nombre = $movie["nombre_película"];
                $id = $movie["id_película"];
                echo "<button class='search-result' type='submit' name='id' value='$id'> $nombre </button>";
            }
        ?>
    </form>
</body>
</html>