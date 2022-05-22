<?php

session_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../../config/DbConnection.php';
require_once '../../models/Info.php';
require_once '../../utils/send.php';
require_once '../../utils/loggedin.php';

class Departments_api extends Info
{
    private $Departments;

    // Initialize connection with DB
    public function __construct()
    {
        // Connect with DB
        $dbconnection = new DbConnection();
        $db = $dbconnection->connect();

        // Create an object for students table to do operations
        $this->Departments = new Info($db);

        $this->Departments->table = 'placement_departments';
    }

    // Get all data
    public function get()
    {
        // Get the students from DB
        $all_data = $this->Departments->read();

        if ($all_data) {
            $data = array();
            while ($row = $all_data->fetch(PDO::FETCH_ASSOC)) {
                array_push($data, $row);
            }
            echo json_encode($data);
            die();
        } else {
            send(400, 'error', 'no departments found');
            die();
        }
    }
}


// To check if admin is logged in
loggedin();

// If a admin logged in ...

// GET all the students
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $Departments_api = new Departments_api();
    $Departments_api->get();
}
