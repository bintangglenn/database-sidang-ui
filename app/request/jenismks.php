<?php
    include '../connection.php';
    include '../controller/JenisMKSHandler.php';
    $jenisMKSHandler = new JenisMKSHandler($db);
    header('Content-Type: application/json');

    $response = [
        'status' => 'success',
        'data' => null
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
        switch($_GET['action']) {
            case 'get_jenismks' :
                $jenisMKSList = $jenisMKSHandler->getAllJenisMKS();
                $data = pg_fetch_all($jenisMKSList);
                $response['data'] = $data;
                break;

            case 'get_JenisMKS_with_npm' :
                if (!isset($_GET['npm'])) {
                    $response['status'] = 'failed';
                    $response['data'] = 'npm is required';
                } else {
                    $jenisMKS = $jenisMKSHandler->getJenisMKS($_GET['id']);
                    $data = pg_fetch_all($jenisMKS);
                    $response['data'] = $data;
                }
                break;
        }
    }
    echo json_encode($response);
 ?>
