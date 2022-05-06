<?php

// Operations for '
// placement_recruiters
// ' is handeled here
class Recruiters
{
    private $conn;

    private $table = 'placement_recruiters';

    public $recruiter_id = 0;
    public $company = "";
    public $mail = "";
    public $address = "";

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
        $query = 'SELECT * FROM ' . $this->table . ' WHERE recruiter_id = :recruiter_id';

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->recruiter_id = htmlspecialchars(strip_tags($this->recruiter_id));

        $stmt->bindParam(':recruiter_id', $this->recruiter_id);

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
        $query = 'INSERT INTO ' . $this->table . ' SET company = :company, mail = :mail, 
        address = :address';

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->company = htmlspecialchars(strip_tags($this->company));
        $this->mail = htmlspecialchars(strip_tags($this->mail));
        $this->address = htmlspecialchars(strip_tags($this->address));

        $stmt->bindParam(':company', $this->company);
        $stmt->bindParam(':mail', $this->mail);
        $stmt->bindParam(':address', $this->address);

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
        $query = 'UPDATE ' . $this->table . ' SET ' . $to_set . ' WHERE recruiter_id = :recruiter_id';

        $stmt = $this->conn->prepare($query);

        $this->$to_update = htmlspecialchars(strip_tags($this->$to_update));
        $this->recruiter_id = htmlspecialchars(strip_tags($this->recruiter_id));

        $stmt->bindParam(':' . $to_update, $this->$to_update);
        $stmt->bindParam(':recruiter_id', $this->recruiter_id);

        // If data updated successfully, return True
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a field
    public function delete_row()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE recruiter_id = :recruiter_id';

        $stmt = $this->conn->prepare($query);

        $this->recruiter_id = htmlspecialchars(strip_tags($this->recruiter_id));

        $stmt->bindParam(':recruiter_id', $this->recruiter_id);

        // If data updated successfully, return True
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
