<?php

session_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../../../../config/DbConnection.php';
require_once '../../../../models/Students_register.php';
require_once '../../../../utils/send.php';
require_once '../../../../utils/loggedin.php';

class Students_register_api extends Students_register
{
    private $Students_register;

    // Initialize connection with DB
    public function __construct()
    {
        // Connect with DB
        $dbconnection = new DbConnection();
        $db = $dbconnection->connect();

        // Create an object for recruiters table to do operations
        $this->Students_register = new Students_register($db);
    }

    // Get all data
    public function get()
    {
        // Get the recruiters from DB
        $all_data = $this->Students_register->read();

        if ($all_data) {
            $data = array();
            while ($row = $all_data->fetch(PDO::FETCH_ASSOC)) {
                array_push($data, $row);
            }
            echo json_encode($data);
            die();
        } else {
            send(400, 'error', 'no recruiters found');
            die();
        }
    }

    // Get all data of a recruiters by ID
    public function get_by_id($id)
    {
        // Get the recruiters from DB
        $this->Students_register->student_register_id = $id;
        $all_data = $this->Students_register->read_by_drive();

        if ($all_data) {
            echo json_encode($all_data);
            die();
        } else {
            send(400, 'error', 'no recruiters found');
            die();
        }
    }

    // POST a new recruiters
    public function post()
    {
        // pass the drive ID in URL
        if (!isset($_GET['drive'])) {
            send(400, 'error', 'pass a drive id');
            die();
        }

        // Clean the data
        $this->Students_register->drive_id = $_GET['drive'];
        $this->Students_register->student_id = $_SESSION['student_id'];

        // If no recruiters exists, insert and get_by_id the data
        if ($this->Students_register->post()) {
            $this->get_by_id($_GET['drive']);
        } else {
            send(400, 'error', 'student cannot be registered');
        }
    }

    public function update_by_id($DB_data, $to_update, $update_str)
    {
        if (strcmp($DB_data, $to_update) !== 0) {
            if (!$this->Students_register->update_row($update_str)) {
                // If can't update_by_id the data, throw an error message
                send(400, 'error', $update_str . ' cannot be updated');
                die();
            }
        }
    }

    // UPDATE (PUT)
    public function put()
    {
        // pass the drive ID and registration ID in URL
        if (!isset($_GET['drive'])) {
            send(400, 'error', 'pass drive/registration id');
            die();
        }

        // Clean the data
        $this->Students_register->student_register_id =   $_GET['ID'];
        $this->Students_register->drive_id = $_GET['drive'];
        $this->Students_register->student_id = $_SESSION['student_id'];

        // Get the student from DB
        $all_data = $this->Students_register->read_by_drive();

        // If student already exists, update the student that changed
        if ($all_data) {
            $this->Students_register->student_register_id = $all_data['student_register_id'];

            $this->update_by_id($all_data['student_id'], $_SESSION['student_id'], 'student_id');
            $this->update_by_id($all_data['drive_id'], $_GET['drive'], 'drive_id');

            // If updated successfully, get the data, else throw an error message 
            $this->get();
        } else {
            send(400, 'error', 'no student found');
        }
    }

    public function delete_by_id()
    {
        // pass the registration ID in URL
        if (!isset($_GET['ID'])) {
            send(400, 'error', 'pass a student registration id');
            die();
        }
        $this->Students_register->student_register_id = $_GET['ID']; // should pass the student registration id in URL

        // Check for student registration existance
        $all_data = $this->Students_register->read_row();

        if(!$all_data){
            send(400, 'error', 'no student registration found for ID: ' . $_GET['ID']);
            die();
        }

        if ($this->Students_register->delete_row()) {
            send(200, 'message', 'student registration deleted successfully');
        } else {
            send(400, 'error', 'student registration cannot be deleted');
        }
    }
}


// GET all the student registrations
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $Students_register_api = new Students_register_api();
    if (isset($_GET['drive'])) {
        $Students_register_api->get_by_id($_GET['drive']);
    } else {
        $Students_register_api->get();
    }
}

// To check if student is logged in
if(!isset($_SESSION['student_id'])){
    send(400, 'error', 'no student logged in');
    die();
}

// If a student logged in ...

// POST a new student registrations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Students_register_api = new Students_register_api();
    $Students_register_api->post();
}

// UPDATE (PUT)
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $Students_register_api = new Students_register_api();
    $Students_register_api->put();
}
