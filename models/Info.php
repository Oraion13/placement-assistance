<?php

// Operations for 'placement_admin' is handeled here
class Info
{
    private $conn;
    public $table = '';

    public $id_name = '';
    public $id;
    public $sem = 0;
    public $dept = 0;


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
        $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->id_name . '  = :' . $this->id_name;

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->id  = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':' . $this->id_name, $this->id);

        if ($stmt->execute()) {

            // If data exists, return the data
            if ($stmt) {
                return $stmt;
            }
        }

        return false;
    }

    // Read data by dept
    public function read_dept()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE department_id = :department_id';

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->dept  = htmlspecialchars(strip_tags($this->dept));

        $stmt->bindParam(':department_id', $this->dept);

        if ($stmt->execute()) {

            // If data exists, return the data
            if ($stmt) {
                return $stmt;
            }
        }

        return false;
    }

    // Read data by dept and sem
    public function read_dept_sem()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE department_id = :department_id AND current_semester = :current_semester';

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->dept  = htmlspecialchars(strip_tags($this->dept));
        $this->sem  = htmlspecialchars(strip_tags($this->sem));

        $stmt->bindParam(':department_id', $this->dept);
        $stmt->bindParam(':current_semester', $this->sem);

        if ($stmt->execute()) {
            // Fetch the data

            // If data exists, return the data
            if ($stmt) {
                return $stmt;
            }
        }

        return false;
    }
}
