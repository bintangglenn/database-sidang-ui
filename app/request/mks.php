<?php
    include '../connection.php';
    include '../controller/MKSHandler.php';
    $mksHandler = new MKSHandler($db);
    header('Content-Type: application/json');
    $response = [
        'status' => 'success',
        'data' => null
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
        switch($_GET['action']) {
            case 'get_mks' :
                $mksList = $mksHandler->getAllmks();
                $data = pg_fetch_all($mksList);
                $response['data'] = $data;
                break;

            case 'get_mks_with_id' :
                if (!isset($_GET['id'])) {
                    $response['status'] = 'failed';
                    $response['data'] = 'idmks is required';
                } else {
                    $mks = $mksHandler->getMahasiswa($_GET['id']);
                    $data = pg_fetch_all($mks);
                    $response['data'] = $data;
                }
                break;

            case 'create' :

        }
    }
    echo json_encode($response);
 ?>
