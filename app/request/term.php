<?php
    include '../connection.php';
    include '../controller/TermHandler.php';
    $termHandler = new TermHandler($db);
    header('Content-Type: application/json');
    $response = [
        'status' => 'success',
        'data' => null
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
        switch($_GET['action']) {
            case 'get_term' :
                $termList = $termHandler->getAllterm();
                $data = pg_fetch_all($termList);
                $response['data'] = $data;
                break;
        }
    }
    echo json_encode($response);
 ?>
