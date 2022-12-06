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

$text = htmlspecialchars($_GET['id']);

$comment = htmlspecialchars($_POST['comment']);
$stars = (int)$_POST['stars'];
$nickname = htmlspecialchars($_POST['nickname']);

if (!empty($comment)) {
    $query = "INSERT into movies.reseña (id_película, nickname, estrellas, cuerpo_reseña) VALUES ('$text','$nickname','$stars','$comment');";
    pg_query($dbconn, $query);
}

$query = "SELECT * FROM movies.película AS p WHERE p.id_película = '$text'";

$result = pg_query($dbconn, $query);

if (!$result) {
    echo pg_last_error($dbconn);
    exit;
}

$data = pg_fetch_row($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie</title>
    <style>
        #comments-section {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
    </style>
</head>
<body>
    <?php
        echo "
            <p><b>nombre:</b> {$data[1]}</p>
            <p><b>descripcion:</b> {$data[2]}</p>
            <p><b>año:</b> {$data[3]}</p>
            <p><b>idioma:</b> {$data[4]}</p>
        ";
    ?>
    <form id="comments-section" method="POST">
        <label for="">Comentarios</label>
        <textarea name="comment" cols="50" rows="6"></textarea>
        <fieldset>
            <span>Estrellas:</span>
            <select name="stars">
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
        </fieldset>
        <fieldset>
            <span>Nickname: </span>
            <input type="text" name="nickname" id="">
        </fieldset>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>