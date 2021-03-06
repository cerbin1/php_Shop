<?php
/** @var mysqli $mysqli */
$mysqli = include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add') {
        $type = $_POST['type'];

        $statement = $mysqli->prepare('INSERT INTO types (name) VALUES (?)');
        $statement->bind_param('s', $type);

        if ($statement->execute()) {
            http_response_code(201);
        } else {
            throw new mysqli_sql_exception("Couldn't execute sql statement! HTTP response code: 500");
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] === 'get') {
        $result = $mysqli->query('SELECT * FROM types');
        $array = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }

        echo json_encode(['types' => $array]);
    }
}

$mysqli->close();
