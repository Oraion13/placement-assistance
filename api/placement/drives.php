<?php

session_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../../config/DbConnection.php';
require_once '../../models/Drives.php';
require_once '../../utils/send.php';
require_once '../../utils/loggedin.php';

class Drives_api extends Drives
{
    private $Drive;

    public function __construct()
    {
        // Connect with DB
        $dbconnection = new DbConnection();
        $db = $dbconnection->connect();

        // Create an object for drives table to do operations
        $this->Drive = new Drives($db);
    }
    // Get all data
    public function get()
    {
        // Get the drive from DB
        $all_data = $this->Drive->read();

        if ($all_data) {
            $data = array();
            while ($row = $all_data->fetch(PDO::FETCH_ASSOC)) {
                $row['document'] = base64_encode($row['document']);
                array_push($data, $row);
            }
            echo json_encode($data);
            die();
        } else {
            send(400, 'error', 'no drives found');
            die();
        }
    }

    // Get all data of a drive by ID
    public function get_by_id($id)
    {
        // Get the drive from DB
        $this->Drive->timetable_id = $id;
        $all_data = $this->Drive->read_row();

        if ($all_data) {
            $all_data['document'] = base64_encode($all_data['document']);
            echo json_encode($all_data);
            die();
        } else {
            send(400, 'error', 'no drives found');
            die();
        }
    }

    // POST a new drive
    public function post()
    {
        // Get input data as json
        $data = json_decode(file_get_contents("php://input"));

        if($_FILES['document']['size'] >= 1572864){
            send(400, "error", "file size must be less than 1.5MB");
            die();
        }
        // Clean the data
        $this->Drive->job_description = $_POST['job_description'];
        $this->Drive->about_company = $_POST['about_company'];
        $this->Drive->eligibility_criteria = $_POST['eligibility_criteria'];

        // $last_date = date('Y-m-01', strtotime($_POST['last_date']));
        $this->Drive->last_date = $_POST['last_date'];

        $this->Drive->document = file_get_contents($_FILES['document']['tmp_name']);
        $this->Drive->document_type = $_FILES['document']['type'];

        // Get the drive from DB
        $all_data = $this->Drive->read_row();

        // If no drive exists
        if (!$all_data) {
            // If no drive exists, insert and get_by_id the data
            if ($this->Drive->post()) {
                // $row = $this->Drive->read_row();
                $this->get();
            } else {
                send(400, 'error', 'drive cannot be created');
            }
        } else {
            send(400, 'error', 'drive already exists');
        }
    }

    // UPDATE existing drive
    public function update_by_id($to_update, $update_str)
    {
            if (!$this->Drive->update_row($update_str)) {
                // If can't update_by_id the data, throw an error message
                send(400, 'error', $update_str . ' cannot be updated');
                die();
            }
    }

    // UPDATE (PUT) a existing user's info
    public function put()
    {
        // Get input data as json
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($_GET['ID'])) {
            send(400, 'error', 'pass a drive id');
            die();
        }

        // Clean the data
        $this->Drive->drive_id = $_GET['ID']; // should pass the drive id in URL
        $this->Drive->job_description = $_POST['job_description'];
        $this->Drive->about_company = $_POST['about_company'];
        $this->Drive->eligibility_criteria = $_POST['eligibility_criteria'];
        $this->Drive->last_date = $_POST['last_date'];
        $this->Drive->document = file_get_contents($_FILES['document']['tmp_name']);
        $this->Drive->document_type = $_FILES['document']['type'];

        // Get the drive from DB
        $all_data = $this->Drive->read_row();

        // If drive already exists, update the drive that changed
        if ($all_data) {
            $this->update_by_id($_POST['about_company'], 'about_company');
            $this->update_by_id($_POST['job_description'], 'job_description');
            $this->update_by_id($_POST['eligibility_criteria'], 'eligibility_criteria');
            $this->update_by_id($_POST['last_date'], 'last_date');
            $this->update_by_id(file_get_contents($_FILES['document']['tmp_name']), 'document');
            $this->update_by_id($_FILES['document']['type'], 'document_type');

            // If updated successfully, get_by_id the data, else throw an error message 
            $this->get_by_id($_GET['ID']);
        } else {
            send(400, 'error', 'no drive found for ID: ' . $_GET['ID']);
        }
    }

    public function delete_by_id()
    {
        if (!isset($_GET['ID'])) {
            send(400, 'error', 'pass a drive id');
            die();
        }
        $this->Drive->drive_id = $_GET['ID']; // should pass the drive id in URL

        // Check for drive existance
        $all_data = $this->Drive->read_row();

        if(!$all_data){
            send(400, 'error', 'no drive found for ID: ' . $_GET['ID']);
            die();
        }

        if ($this->Drive->delete_row()) {
            send(200, 'message', 'drive deleted successfully');
        } else {
            send(400, 'error', 'drive cannot be deleted');
        }
    }
}


// GET all the drive
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $Drives_api = new Drives_api();
    if (isset($_GET['ID'])) {
        $Drives_api->get_by_id($_GET['ID']);
    } else {
        $Drives_api->get();
    }
}

// DELETE a existing drive
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $Drives_api = new Drives_api();
    $Drives_api->delete_by_id();
}

// To check if admin is logged in
loggedin();

// If a admin logged in ...

// POST a new drive
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Drives_api = new Drives_api();
    $Drives_api->post();
}

// UPDATE (PUT) a existing drive
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $Drives_api = new Drives_api();
    $Drives_api->put();
}
