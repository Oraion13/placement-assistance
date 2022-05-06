<?php

session_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../../../../config/DbConnection.php';
require_once '../../../../models/Placed_students.php';
require_once '../../../../utils/send.php';
require_once '../../../../utils/loggedin.php';

class Placed_students_api extends Placed_students
{
    private $Placed_students;

    // Initialize connection with DB
    public function __construct()
    {
        // Connect with DB
        $dbconnection = new DbConnection();
        $db = $dbconnection->connect();

        // Create an object for placed students table to do operations
        $this->Placed_students = new Placed_students($db);
    }

    // Get all data
    public function get()
    {
        // Get the placed students from DB
        $all_data = $this->Placed_students->read();

        if ($all_data) {
            $data = array();
            while ($row = $all_data->fetch(PDO::FETCH_ASSOC)) {
                array_push($data, $row);
            }
            echo json_encode($data);
            die();
        } else {
            send(400, 'error', 'no placed students found');
            die();
        }
    }

    // Get all data of a placed students by ID
    public function get_by_id($id)
    {
        // Get the placed students from DB
        $this->Placed_students->placed_student_id = $id;
        $all_data = $this->Placed_students->read_row();

        if ($all_data) {
            echo json_encode($all_data);
            die();
        } else {
            send(400, 'error', 'no placed students found');
            die();
        }
    }

    // POST a new placed students
    public function post()
    {
        // Get input data as json
        $data = json_decode(file_get_contents("php://input"));

        // Clean the data
        $this->Placed_students->student_id = $data->student_id;
        $this->Placed_students->company = $data->company;
        $this->Placed_students->CTC = $data->CTC;

        // Get the placed students from DB
        $all_data = $this->Placed_students->read_row();

        // If no placed students exists
        if (!$all_data) {
            // If no placed students exists, insert and get_by_id the data
            if ($this->Placed_students->post()) {
                $this->get();
            } else {
                send(400, 'error', 'student cannot be created');
            }
        } else {
            send(400, 'error', 'student already exists');
        }
    }

    public function update_by_id($DB_data, $to_update, $update_str)
    {
        if (strcmp($DB_data, $to_update) !== 0) {
            if (!$this->Placed_students->update_row($update_str)) {
                // If can't update_by_id the data, throw an error message
                send(400, 'error', $update_str . ' cannot be updated');
                die();
            }
        }
    }

    // UPDATE (PUT)
    public function put()
    {
        // Get input data as json
        $data = json_decode(file_get_contents("php://input"));

        // Clean the data
        $this->Placed_students->placed_student_id =  $data->placed_student_id;
        $this->Placed_students->company = $data->company;
        $this->Placed_students->student_id = $data->student_id;
        $this->Placed_students->CTC = $data->CTC;

        // Get the placed students from DB
        $all_data = $this->Placed_students->read_row();

        // If placed students already exists, update the placed students that changed
        if ($all_data) {
            $this->Placed_students->user_info_id = $all_data['user_info_id'];

            $this->update_by_id($all_data['company'], $data->company, 'company');
            $this->update_by_id($all_data['student_id'], $data->student_id, 'student_id');
            $this->update_by_id($all_data['CTC'], $data->CTC, 'CTC');

            // If updated successfully, get the data, else throw an error message 
            $this->get();
        } else {
            send(400, 'error', 'no student found');
        }
    }

    public function delete_by_id()
    {
        if (!isset($_GET['ID'])) {
            send(400, 'error', 'pass a student id');
            die();
        }
        $this->Placed_students->placed_student_id = $_GET['ID']; // should pass the student id in URL

        // Check for student existance
        $all_data = $this->Placed_students->read_row();

        if(!$all_data){
            send(400, 'error', 'no student found for ID: ' . $_GET['ID']);
            die();
        }

        if ($this->Placed_students->delete_row()) {
            send(200, 'message', 'student deleted successfully');
        } else {
            send(400, 'error', 'student cannot be deleted');
        }
    }
}


// GET all the placed students
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $Placed_students_api = new Placed_students_api();
    if (isset($_GET['ID'])) {
        $Placed_students_api->get_by_id($_GET['ID']);
    } else {
        $Placed_students_api->get();
    }
}

// To check if admin is logged in
loggedin();

// If a admin logged in ...

// POST a new placed students
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Placed_students_api = new Placed_students_api();
    $Placed_students_api->post();
}

// UPDATE (PUT)
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $Placed_students_api = new Placed_students_api();
    $Placed_students_api->put();
}
