<?php

session_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../../config/DbConnection.php';
require_once '../../models/Company_logos.php';
require_once '../../utils/send.php';
require_once '../../utils/loggedin.php';

class Company_logos_api extends Company_logos
{
    private $Company_logos;

    // Initialize connection with DB
    public function __construct()
    {
        // Connect with DB
        $dbconnection = new DbConnection();
        $db = $dbconnection->connect();

        // Create an object for logos table to do operations
        $this->Company_logos = new Company_logos($db);
    }

    // Get all data
    public function get()
    {
        // Get the logos from DB
        $all_data = $this->Company_logos->read();

        if ($all_data) {
            $data = array();
            while ($row = $all_data->fetch(PDO::FETCH_ASSOC)) {
                $row['logo'] = base64_encode($row['logo']);
                array_push($data, $row);
            }
            echo json_encode($data);
            die();
        } else {
            send(400, 'error', 'no logos found');
            die();
        }
    }

    // Get all data of a logos by ID
    public function get_by_id($id)
    {
        // Get the logos from DB
        $this->Company_logos->logo_id = $id;
        $all_data = $this->Company_logos->read_row();

        if ($all_data) {
            $all_data['logo'] = base64_encode($all_data['logo']);
            echo json_encode($all_data);
            die();
        } else {
            send(400, 'error', 'no logos found');
            die();
        }
    }

    // POST a new logos
    public function post()
    {
        // Get input data as json
        $data = json_decode(file_get_contents("php://input"));

        // Clean the data
        $this->Company_logos->logo_for = $_FILES['logo']['name'];
        $this->Company_logos->logo_type = $_FILES['logo']['logo_type'];
        $this->Company_logos->logo = file_get_contents($_FILES['logo']['tmp_name']);

        // If no logos exists, insert and get_by_id the data
        if ($this->Company_logos->post()) {
            $this->get();
        } else {
            send(400, 'error', 'logo cannot be created');
        }
    }

    public function update_by_id($DB_data, $to_update, $update_str)
    {
        if (!$this->Company_logos->update_row($update_str)) {
            // If can't update_by_id the data, throw an error message
            send(400, 'error', $update_str . ' cannot be updated');
            die();
        }
    }

    // UPDATE (PUT)
    public function put()
    {
        // Get input data as json
        $data = json_decode(file_get_contents("php://input"));

        // Clean the data
        $this->Company_logos->logo_id =  $data->logo_id;
        $this->Company_logos->logo_for =  $_FILES['logo']['name'];
        $this->Company_logos->logo_type = $_FILES['logo']['logo_type'];
        $this->Company_logos->logo = file_get_contents($_FILES['logo']['tmp_name']);

        // Get the logos from DB
        $all_data = $this->Company_logos->read_row();

        // If logos already exists, update the logos that changed
        if ($all_data) {
            $this->Company_logos->logo_id = $all_data['logo_id'];

            $this->update_by_id($all_data['logo_for'],  $_FILES['logo']['name'], 'logo_for');
            $this->update_by_id($all_data['logo_type'],  $_FILES['logo']['type'], 'logo_type');
            $this->update_by_id($all_data['logo'], file_get_contents($_FILES['logo']['tmp_name']), 'logo');

            // If updated successfully, get the data, else throw an error message 
            $this->get();
        } else {
            send(400, 'error', 'no logo found');
        }
    }

    public function delete_by_id()
    {
        if (!isset($_GET['ID'])) {
            send(400, 'error', 'pass a company logo id');
            die();
        }
        $this->Company_logos->logo_id = $_GET['ID']; // should pass the company logo id in URL

        // Check for company logo existance
        $all_data = $this->Company_logos->read_row();

        if (!$all_data) {
            send(400, 'error', 'no company logo found for ID: ' . $_GET['ID']);
            die();
        }

        if ($this->Company_logos->delete_row()) {
            send(200, 'message', 'company logo deleted successfully');
        } else {
            send(400, 'error', 'company logo cannot be deleted');
        }
    }
}


// GET all the logos
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $Company_logos_api = new Company_logos_api();
    if (isset($_GET['ID'])) {
        $Company_logos_api->get_by_id($_GET['ID']);
    } else {
        $Company_logos_api->get();
    }
}

// To check if admin is logged in
loggedin();

// If a admin logged in ...

// POST a new logos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Company_logos_api = new Company_logos_api();
    $Company_logos_api->post();
}

// UPDATE (PUT)
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $Company_logos_api = new Company_logos_api();
    $Company_logos_api->put();
}
