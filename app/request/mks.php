<?php
    include '../connection.php';
    include '../controller/MKSHandler.php';
    $mksHandler = new MKSHandler($db);
    //header('Content-Type: application/json');
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

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
            echo json_encode($_POST);
                $term = $_POST['term'];
                $npm = $_POST['npm'];
                $type = $_POST['type'];
                $title = $_POST['title'];
                $adviserList = $_POST['adviserList'];
                $examinerList = $_POST['examinerList'];

                $result = $mksHandler->create($term, $npm, $type, $title, $adivserList, $examinerList);
                $response['data'] = pg_num_rows($result);
                break;
        }
    }
    echo json_encode($response);
 ?>
