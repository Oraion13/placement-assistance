<?php

// Operations for '
// placement_students_register
// ' is handeled here
class Students_register
{
    private $conn;

    private $table = 'placement_students_register';
    private $drives = 'placement_drives';
    private $students_profile = 'placement_students_profile';

    public $student_register_id = 0;
    public $drive_id = "";
    public $student_id = "";

    // Connect to the DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Read all data
    public function read()
    {
        $columns = $this->table . '.student_register_id, ' . $this->table
            . '.drive_id, ' . $this->table . '.student_id, ' . $this->drives . '.drive_id, '
            . $this->drives . '.job_description, ' . $this->drives . '.about_company, '
            . $this->drives . '.eligibility_criteria, ' . $this->drives . '.last_date, '
            . $this->drives . '.document, ' . $this->drives . '.document_type, '
            . $this->students_profile . '.first_name, '
            . $this->students_profile . '.last_name, ' . $this->students_profile . '.USN, '
            . $this->students_profile . '.register_number, ' . $this->students_profile . '.phone, '
            . $this->students_profile . '.mail, ' . $this->students_profile . '.date_of_birth, '
            . $this->students_profile . '.current_semester, ' . $this->students_profile . '.branch_of_study, '
            . $this->students_profile . '.sslc_aggregate, ' . $this->students_profile . '.12th_diploma_aggregate, '
            . $this->students_profile . '.ug_aggregate, ' . $this->students_profile . '.pg_aggregate, '
            . $this->students_profile . '.current_backlogs, ' . $this->students_profile . '.history_of_backlogs, '
            . $this->students_profile . '.detained_years, ' . $this->students_profile . '.annual_income';
        $query = 'SELECT ' . $columns . ' FROM ((' . $this->table . ' INNER JOIN ' . $this->drives
            . ' ON ' . $this->table . '.drive_id = ' . $this->drives . '.drive_id ) INNER JOIN ' . $this->students_profile
            . ' ON ' . $this->table . '.student_id = ' . $this->students_profile . '.student_id ) ORDER BY ' . $this->table . '.drive_id';

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            // If data exists, return the data
            if ($stmt) {
                return $stmt;
            }
        }

        return false;
    }

    // Read by ID
    public function read_row()
    {
        $columns = $this->table . '.student_register_id, ' . $this->table
        . '.drive_id, ' . $this->table . '.student_id, ' . $this->drives . '.drive_id, '
        . $this->drives . '.job_description, ' . $this->drives . '.about_company, '
        . $this->drives . '.eligibility_criteria, ' . $this->drives . '.last_date, '
        . $this->drives . '.document, ' . $this->drives . '.document_type, '
        . $this->students_profile . '.first_name, '
        . $this->students_profile . '.last_name, ' . $this->students_profile . '.USN, '
        . $this->students_profile . '.register_number, ' . $this->students_profile . '.phone, '
        . $this->students_profile . '.mail, ' . $this->students_profile . '.date_of_birth, '
        . $this->students_profile . '.current_semester, ' . $this->students_profile . '.branch_of_study, '
        . $this->students_profile . '.sslc_aggregate, ' . $this->students_profile . '.12th_diploma_aggregate, '
        . $this->students_profile . '.ug_aggregate, ' . $this->students_profile . '.pg_aggregate, '
        . $this->students_profile . '.current_backlogs, ' . $this->students_profile . '.history_of_backlogs, '
        . $this->students_profile . '.detained_years, ' . $this->students_profile . '.annual_income';
    $query = 'SELECT ' . $columns . ' FROM ((' . $this->table . ' INNER JOIN ' . $this->drives
        . ' ON student_register_id = :student_register_id AND ' . $this->table . '.drive_id = ' . $this->drives . '.drive_id ) INNER JOIN ' . $this->students_profile
        . ' ON ' . $this->table . '.student_id = ' . $this->students_profile . '.student_id ) ORDER BY ' . $this->table . '.drive_id';

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->student_register_id = htmlspecialchars(strip_tags($this->student_register_id));

        $stmt->bindParam(':student_register_id', $this->student_register_id);

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


    // Read data by drives
    public function read_by_drive()
    {
        $columns = $this->table . '.student_register_id, ' . $this->table
        . '.drive_id, ' . $this->table . '.student_id, ' . $this->drives . '.drive_id, '
        . $this->drives . '.job_description, ' . $this->drives . '.about_company, '
        . $this->drives . '.eligibility_criteria, ' . $this->drives . '.last_date, '
        . $this->drives . '.document, ' . $this->drives . '.document_type, '
        . $this->students_profile . '.first_name, '
        . $this->students_profile . '.last_name, ' . $this->students_profile . '.USN, '
        . $this->students_profile . '.register_number, ' . $this->students_profile . '.phone, '
        . $this->students_profile . '.mail, ' . $this->students_profile . '.date_of_birth, '
        . $this->students_profile . '.current_semester, ' . $this->students_profile . '.branch_of_study, '
        . $this->students_profile . '.sslc_aggregate, ' . $this->students_profile . '.12th_diploma_aggregate, '
        . $this->students_profile . '.ug_aggregate, ' . $this->students_profile . '.pg_aggregate, '
        . $this->students_profile . '.current_backlogs, ' . $this->students_profile . '.history_of_backlogs, '
        . $this->students_profile . '.detained_years, ' . $this->students_profile . '.annual_income';
    $query = 'SELECT ' . $columns . ' FROM ((' . $this->table . ' INNER JOIN ' . $this->drives
        . ' ON drive_id = :drive_id AND ' . $this->table . '.drive_id = ' . $this->drives . '.drive_id ) INNER JOIN ' . $this->students_profile
        . ' ON ' . $this->table . '.student_id = ' . $this->students_profile . '.student_id ) ORDER BY ' . $this->table . '.drive_id';

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

    // Read data by drives
    public function read_by_student()
    {
        $columns = $this->table . '.student_register_id, ' . $this->table
        . '.drive_id, ' . $this->table . '.student_id, ' . $this->drives . '.drive_id, '
        . $this->drives . '.job_description, ' . $this->drives . '.about_company, '
        . $this->drives . '.eligibility_criteria, ' . $this->drives . '.last_date, '
        . $this->drives . '.document, ' . $this->drives . '.document_type, '
        . $this->students_profile . '.first_name, '
        . $this->students_profile . '.last_name, ' . $this->students_profile . '.USN, '
        . $this->students_profile . '.register_number, ' . $this->students_profile . '.phone, '
        . $this->students_profile . '.mail, ' . $this->students_profile . '.date_of_birth, '
        . $this->students_profile . '.current_semester, ' . $this->students_profile . '.branch_of_study, '
        . $this->students_profile . '.sslc_aggregate, ' . $this->students_profile . '.12th_diploma_aggregate, '
        . $this->students_profile . '.ug_aggregate, ' . $this->students_profile . '.pg_aggregate, '
        . $this->students_profile . '.current_backlogs, ' . $this->students_profile . '.history_of_backlogs, '
        . $this->students_profile . '.detained_years, ' . $this->students_profile . '.annual_income';
    $query = 'SELECT ' . $columns . ' FROM ((' . $this->table . ' INNER JOIN ' . $this->students_profile
        . ' ON student_id = :student_id AND ' . $this->table . '.student_id = ' . $this->students_profile . '.student_id ) INNER JOIN ' . $this->drives
        . ' ON ' . $this->table . '.drive_id = ' . $this->drives . '.drive_id ) ORDER BY ' . $this->table . '.drive_id';

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->student_id = htmlspecialchars(strip_tags($this->student_id));

        $stmt->bindParam(':student_id', $this->student_id);

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
        $query = 'INSERT INTO ' . $this->table . ' SET drive_id = :drive_id, student_id = :student_id';

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->drive_id = htmlspecialchars(strip_tags($this->drive_id));
        $this->student_id = htmlspecialchars(strip_tags($this->student_id));

        $stmt->bindParam(':drive_id', $this->drive_id);
        $stmt->bindParam(':student_id', $this->student_id);

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
        $query = 'UPDATE ' . $this->table . ' SET ' . $to_set . ' WHERE student_register_id = :student_register_id';

        $stmt = $this->conn->prepare($query);

        $this->$to_update = htmlspecialchars(strip_tags($this->$to_update));
        $this->student_register_id = htmlspecialchars(strip_tags($this->student_register_id));

        $stmt->bindParam(':' . $to_update, $this->$to_update);
        $stmt->bindParam(':student_register_id', $this->student_register_id);

        // If data updated successfully, return True
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a field
    public function delete_row()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE student_register_id = :student_register_id';

        $stmt = $this->conn->prepare($query);

        $this->student_register_id = htmlspecialchars(strip_tags($this->student_register_id));

        $stmt->bindParam(':student_register_id', $this->student_register_id);

        // If data updated successfully, return True
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
