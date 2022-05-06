<?php

// Operations for '
// placement_logos
// ' is handeled here
class Company_logos
{
    private $conn;

    private $table = 'placement_logos';

    public $logo_id  = 0;
    public $logo_for = "";
    public $logo_type = "";
    public $logo = "";

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
        $query = 'SELECT * FROM ' . $this->table . ' WHERE logo_id  = :logo_id ';

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->logo_id  = htmlspecialchars(strip_tags($this->logo_id));

        $stmt->bindParam(':logo_id ', $this->logo_id);

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
        $query = 'INSERT INTO ' . $this->table . ' SET logo_for = :logo_for, logo_type = :logo_type, 
        logo = :logo';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':logo_for', $this->logo_for);
        $stmt->bindParam(':logo_type', $this->logo_type);
        $stmt->bindParam(':logo', $this->logo);

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
        $query = 'UPDATE ' . $this->table . ' SET ' . $to_set . ' WHERE logo_id  = :logo_id ';

        $stmt = $this->conn->prepare($query);

        $this->$to_update = htmlspecialchars(strip_tags($this->$to_update));
        $this->logo_id  = htmlspecialchars(strip_tags($this->logo_id));

        $stmt->bindParam(':' . $to_update, $this->$to_update);
        $stmt->bindParam(':logo_id ', $this->logo_id);

        // If data updated successfully, return True
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a field
    public function delete_row()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE logo_id  = :logo_id ';

        $stmt = $this->conn->prepare($query);

        $this->logo_id  = htmlspecialchars(strip_tags($this->logo_id));

        $stmt->bindParam(':logo_id ', $this->logo_id);

        // If data updated successfully, return True
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
