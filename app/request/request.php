<?php
    include '../connection.php';
    include '../controller/MahasiswaHandler.php';
    include '../controller/DosenHandler.php';
    include '../controller/MKSHandler.php';
    include '../controller/JenisMKSHandler.php';
    include '../controller/TermHandler.php';
    include '../controller/RuanganHandler.php';
    include '../controller/TimelineHandler.php';

    header('Content-Type: application/json');
    $response = [
        'status' => 'success',
        'data' => null,
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'GET_MAHASISWA':
                $mahasiswaList = MahasiswaHandler::getAllMahasiswa($db);
                $data = pg_fetch_all($mahasiswaList);
                $response['data'] = $data;
                break;

            case 'GET_TERM':
                $termList = TermHandler::getAllTerm($db);
                $data = pg_fetch_all($termList);
                $response['data'] = $data;
                break;

            case 'GET_DOSEN':
                $dosenList = DosenHandler::getAllDosen($db);
                $data = pg_fetch_all($dosenList);
                $response['data'] = $data;
                break;

            case 'GET_JENIS_MKS':
                $jenisMKSList = JenisMKSHandler::getAllJenisMKS($db);
                $data = pg_fetch_all($jenisMKSList);
                $response['data'] = $data;
                break;

            case 'GET_MKS':
                $skip = $_GET['skip'];
                $take = $_GET['take'];
                $sort = $_GET['sort'];
                $result = MKSHandler::getMKSwith($db, $skip, $take, $sort);
                $response['data'] = $result;
                break;

            case 'GET_RUANGAN':
                $ruanganList = RuanganHandler::getAllRuangan($db);
                $data = pg_fetch_all($ruanganList);
                $response['data'] = $data;
                break;

            case 'GET_TIMELINE':
                $timelineList = TimelineHandler::getAllTimeline($db);
                $data = pg_fetch_all($timelineList);
                $data['events'] = $data;
                $response['data'] = $data;
                break;
            default:
                // code...
                break;
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'CREATE_MKS':
                $idmks = $_POST['idmks'];
                $term = $_POST['term'];
                $npm = $_POST['npm'];
                $type = $_POST['type'];
                $title = $_POST['title'];
                $adviserList = $_POST['adviserlist'];
                $examinerList = $_POST['examinerlist'];
                $result = MKSHandler::create($db, $idmks, $term, $npm, $type, $title);
                foreach ($adviserList as $adviser) {
                    DosenHandler::addPembimbingMKS($db, $idmks, $adviser);
                }
                foreach ($examinerList as $examiner) {
                    DosenHandler::addPengujiMKS($db, $idmks, $examiner);
                }
                $response['data'] = $result;
                break;
        }
    }
    echo json_encode($response);
