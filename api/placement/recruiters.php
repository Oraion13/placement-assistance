<?php

session_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../../../../config/DbConnection.php';
require_once '../../../../models/Recruiters.php';
require_once '../../../../utils/send.php';
require_once '../../../../utils/loggedin.php';

class Recruiters_api extends Recruiters
{
    private $Recruiters;

    // Initialize connection with DB
    public function __construct()
    {
        // Connect with DB
        $dbconnection = new DbConnection();
        $db = $dbconnection->connect();

        // Create an object for recruiters table to do operations
        $this->Recruiters = new Recruiters($db);
    }

    // Get all data
    public function get()
    {
        // Get the recruiters from DB
        $all_data = $this->Recruiters->read();

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
        $this->Recruiters->recruiter_id = $id;
        $all_data = $this->Recruiters->read_row();

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
        // Get input data as json
        $data = json_decode(file_get_contents("php://input"));

        // Clean the data
        $this->Recruiters->company = $data->company;
        $this->Recruiters->mail = $data->mail;
        $this->Recruiters->address = $data->address;

        // If no recruiters exists, insert and get_by_id the data
        if ($this->Recruiters->post()) {
            $this->get();
        } else {
            send(400, 'error', 'company cannot be created');
        }
    }

    public function update_by_id($DB_data, $to_update, $update_str)
    {
        if (strcmp($DB_data, $to_update) !== 0) {
            if (!$this->Recruiters->update_row($update_str)) {
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
        $this->Recruiters->recruiter_id =  $data->recruiter_id;
        $this->Recruiters->mail = $data->mail;
        $this->Recruiters->company = $data->company;
        $this->Recruiters->address = $data->address;

        // Get the recruiters from DB
        $all_data = $this->Recruiters->read_row();

        // If recruiters already exists, update the recruiters that changed
        if ($all_data) {
            $this->Recruiters->recruiter_id = $all_data['recruiter_id'];

            $this->update_by_id($all_data['mail'], $data->mail, 'mail');
            $this->update_by_id($all_data['company'], $data->company, 'company');
            $this->update_by_id($all_data['address'], $data->address, 'address');

            // If updated successfully, get the data, else throw an error message 
            $this->get();
        } else {
            send(400, 'error', 'no student found');
        }
    }

    public function delete_by_id()
    {
        if (!isset($_GET['ID'])) {
            send(400, 'error', 'pass a recruiter id');
            die();
        }
        $this->Recruiters->recruiter_id = $_GET['ID']; // should pass the recruiter id in URL

        // Check for recruiter existance
        $all_data = $this->Recruiters->read_row();

        if(!$all_data){
            send(400, 'error', 'no recruiter found for ID: ' . $_GET['ID']);
            die();
        }

        if ($this->Recruiters->delete_row()) {
            send(200, 'message', 'recruiter deleted successfully');
        } else {
            send(400, 'error', 'recruiter cannot be deleted');
        }
    }
}


// GET all the recruiters
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $Recruiters_api = new Recruiters_api();
    if (isset($_GET['ID'])) {
        $Recruiters_api->get_by_id($_GET['ID']);
    } else {
        $Recruiters_api->get();
    }
}

// To check if admin is logged in
// loggedin();

// If a admin logged in ...

// POST a new recruiters
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Recruiters_api = new Recruiters_api();
    $Recruiters_api->post();
}

// UPDATE (PUT)
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $Recruiters_api = new Recruiters_api();
    $Recruiters_api->put();
}
