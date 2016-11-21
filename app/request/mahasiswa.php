<?php
    include '../connection.php';
    include '../controller/MahasiswaHandler.php';
    $mahasiswaHandler = new MahasiswaHandler($db);
    header('Content-Type: application/json');
    $response = [
        'status' => 'success',
        'data' => null
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
        switch($_GET['action']) {
            case 'get_mahasiswa' :
                $mahasiswaList = $mahasiswaHandler->getAllMahasiswa();
                $data = pg_fetch_all($mahasiswaList);
                $response['data'] = $data;
                break;

            case 'get_mahasiswa_with_npm' :
                if (!isset($_GET['npm'])) {
                    $response['status'] = 'failed';
                    $response['data'] = 'npm is required';
                } else {
                    $mahasiswa = $mahasiswaHandler->getMahasiswa($_GET['npm']);
                    $data = pg_fetch_all($mahasiswa);
                    $response['data'] = $data;
                }
                break;
        }
    }
    echo json_encode($response);
 ?>
