<?php
    include '../connection.php';
    include '../controller/DosenHandler.php';
    $dosenHandler = new DosenHandler($db);
    header('Content-Type: application/json');
    $response = [
        'status' => 'success',
        'data' => null
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
        switch($_GET['action']) {
            case 'get_dosen' :
                $dosenList = $dosenHandler->getAllDosen();
                $data = pg_fetch_all($dosenList);
                $response['data'] = $data;
                break;
        }
    }
    echo json_encode($response);
 ?>
