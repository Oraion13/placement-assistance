<?php

session_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../../config/DbConnection.php';
require_once '../../models/Info.php';
require_once '../../utils/send.php';
require_once '../../utils/loggedin.php';

class Students_api extends Info
{
    private $Students;

    // Initialize connection with DB
    public function __construct()
    {
        // Connect with DB
        $dbconnection = new DbConnection();
        $db = $dbconnection->connect();

        // Create an object for students table to do operations
        $this->Students = new Info($db);

        $this->Students->table = 'placement_students_profile';
    }

    // Get all data
    public function get()
    {
        // Get the students from DB
        $all_data = $this->Students->read();

        if ($all_data) {
            $data = array();
            while ($row = $all_data->fetch(PDO::FETCH_ASSOC)) {
                array_push($data, $row);
            }
            echo json_encode($data);
            die();
        } else {
            send(400, 'error', 'no students found');
            die();
        }
    }

    // Get all data
    public function get_by_dept_sem()
    {
        // Get the students from DB
        $this->Students->sem = $_GET['sem'];
        $this->Students->dept = $_GET['dept'];
        $all_data = $this->Students->read_dept_sem();

        if ($all_data) {
            $data = array();
            while ($row = $all_data->fetch(PDO::FETCH_ASSOC)) {
                array_push($data, $row);
            }
            echo json_encode($data);
            die();
        } else {
            send(400, 'error', 'no students found');
            die();
        }
    }

    // Get all data
    public function get_by_dept()
    {
        // Get the students from DB
        $this->Students->dept = $_GET['dept'];
        $all_data = $this->Students->read_dept();

        if ($all_data) {
            $data = array();
            while ($row = $all_data->fetch(PDO::FETCH_ASSOC)) {
                array_push($data, $row);
            }
            echo json_encode($data);
            die();
        } else {
            send(400, 'error', 'no students found');
            die();
        }
    }
}


// To check if admin is logged in
loggedin();

// If a admin logged in ...

// GET all the students
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $Students_api = new Students_api();
    if (isset($_GET['dept']) && isset($_GET['sem'])) {
        $Students_api->get_by_dept_sem();
    } else if (isset($_GET['dept'])) {
        $Students_api->get_by_dept();
    } else {
        $Students_api->get();
    }
}
