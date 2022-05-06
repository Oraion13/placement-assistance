<?php

// Operations for '
// placement_drives
// ' is handeled here
class Drives
{
    private $conn;

    private $table = 'placement_drives';

    public $drive_id = 0;
    public $job_description = "";
    public $about_company = "";
    public $eligibility_criteria = "";
    public $last_date = "";
    public $document = "";
    public $document_type = "";

    // Connect to the DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Read all data
    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table;

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            // If data exists, return the data
            if ($stmt) {
                return $stmt;
            }
        }

        return false;
    }

    // Read data by ID
    public function read_row()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE drive_id = :drive_id';

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->drive_id = htmlspecialchars(strip_tags($this->drive_id));

        $stmt->bindParam(':drive_id', $this->drive_id);

        if ($stmt->execute()) {
            // Fetch the data
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // If data exists, return the data
            if ($row) {
                return $row;
            }
        }

        return false;
    }

    // Insert data
    public function post()
    {
        $query = 'INSERT INTO ' . $this->table . ' SET job_description = :job_description, about_company = :about_company, 
        eligibility_criteria = :eligibility_criteria, last_date = :last_date, document = :document, document_type = :document_type';

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->job_description = htmlspecialchars(strip_tags($this->job_description));
        $this->about_company = htmlspecialchars(strip_tags($this->about_company));
        $this->eligibility_criteria = htmlspecialchars(strip_tags($this->eligibility_criteria));
        $this->last_date = htmlspecialchars(strip_tags($this->last_date));

        $stmt->bindParam(':job_description', $this->job_description);
        $stmt->bindParam(':about_company', $this->about_company);
        $stmt->bindParam(':eligibility_criteria', $this->eligibility_criteria);
        $stmt->bindParam(':last_date', $this->last_date);
        $stmt->bindParam(':document', $this->document);
        $stmt->bindParam(':document_type', $this->document_type);

        // If data inserted successfully, return True
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Update a field
    public function update_row($to_update)
    {
        $to_set = $to_update . ' = :' . $to_update;
        $query = 'UPDATE ' . $this->table . ' SET ' . $to_set . ' WHERE drive_id = :drive_id';

        $stmt = $this->conn->prepare($query);

        $this->$to_update = htmlspecialchars(strip_tags($this->$to_update));
        $this->drive_id = htmlspecialchars(strip_tags($this->drive_id));

        $stmt->bindParam(':' . $to_update, $this->$to_update);
        $stmt->bindParam(':drive_id', $this->drive_id);

        // If data updated successfully, return True
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a field
    public function delete_row()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE drive_id = :drive_id';

        $stmt = $this->conn->prepare($query);

        $this->drive_id = htmlspecialchars(strip_tags($this->drive_id));

        $stmt->bindParam(':drive_id', $this->drive_id);

        // If data updated successfully, return True
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
