<?php

// Operations for '
// placement_placed_students
// ' is handeled here
class Placed_students
{
    private $conn;

    private $table = 'placement_placed_students';
    private $students_profile = 'placement_students_profile';

    public $placed_student_id = 0;
    public $student_id = "";
    public $company = "";
    public $CTC = "";

    // Connect to the DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Read all data
    public function read()
    {
        $columns = $this->table . '.placed_student_id, ' . $this->table
            . '.student_id, ' . $this->table . '.company, ' . $this->table
            . '.CTC, ' . $this->students_profile . '.first_name, '
            . $this->students_profile . '.last_name, ' . $this->students_profile . '.USN, '
            . $this->students_profile . '.register_number, ' . $this->students_profile . '.phone, '
            . $this->students_profile . '.mail, ' . $this->students_profile . '.date_of_birth, '
            . $this->students_profile . '.current_semester, ' . $this->students_profile . '.branch_of_study, '
            . $this->students_profile . '.sslc_aggregate, ' . $this->students_profile . '.12th_diploma_aggregate, '
            . $this->students_profile . '.ug_aggregate, ' . $this->students_profile . '.pg_aggregate, '
            . $this->students_profile . '.current_backlogs, ' . $this->students_profile . '.history_of_backlogs, '
            . $this->students_profile . '.detained_years, ' . $this->students_profile . '.annual_income';
        $query = 'SELECT ' . $columns . ' FROM (' . $this->table . ' INNER JOIN ' . $this->students_profile
            . ' ON ' . $this->table . '.student_id = ' . $this->students_profile . '.student_id )';

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
        $columns = $this->table . '.placed_student_id, ' . $this->table
            . '.student_id, ' . $this->table . '.company, ' . $this->table
            . '.CTC, ' . $this->students_profile . '.first_name, '
            . $this->students_profile . '.last_name, ' . $this->students_profile . '.USN, '
            . $this->students_profile . '.register_number, ' . $this->students_profile . '.phone, '
            . $this->students_profile . '.mail, ' . $this->students_profile . '.date_of_birth, '
            . $this->students_profile . '.current_semester, ' . $this->students_profile . '.branch_of_study, '
            . $this->students_profile . '.sslc_aggregate, ' . $this->students_profile . '.12th_diploma_aggregate, '
            . $this->students_profile . '.ug_aggregate, ' . $this->students_profile . '.pg_aggregate, '
            . $this->students_profile . '.current_backlogs, ' . $this->students_profile . '.history_of_backlogs, '
            . $this->students_profile . '.detained_years, ' . $this->students_profile . '.annual_income';
        $query = 'SELECT ' . $columns . ' FROM (' . $this->table . ' INNER JOIN ' . $this->students_profile
            . ' ON placed_student_id = :placed_student_id AND ' . $this->table . '.student_id = ' . $this->students_profile . '.student_id )';

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->placed_student_id = htmlspecialchars(strip_tags($this->placed_student_id));

        $stmt->bindParam(':placed_student_id', $this->placed_student_id);

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
        $query = 'INSERT INTO ' . $this->table . ' SET student_id = :student_id, company = :company, 
        CTC = :CTC';

        $stmt = $this->conn->prepare($query);

        // clean the data
        $this->student_id = htmlspecialchars(strip_tags($this->student_id));
        $this->company = htmlspecialchars(strip_tags($this->company));
        $this->CTC = htmlspecialchars(strip_tags($this->CTC));

        $stmt->bindParam(':student_id', $this->student_id);
        $stmt->bindParam(':company', $this->company);
        $stmt->bindParam(':CTC', $this->CTC);

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
        $query = 'UPDATE ' . $this->table . ' SET ' . $to_set . ' WHERE placed_student_id = :placed_student_id';

        $stmt = $this->conn->prepare($query);

        $this->$to_update = htmlspecialchars(strip_tags($this->$to_update));
        $this->placed_student_id = htmlspecialchars(strip_tags($this->placed_student_id));

        $stmt->bindParam(':' . $to_update, $this->$to_update);
        $stmt->bindParam(':placed_student_id', $this->placed_student_id);

        // If data updated successfully, return True
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a field
    public function delete_row()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE placed_student_id = :placed_student_id';

        $stmt = $this->conn->prepare($query);

        $this->placed_student_id = htmlspecialchars(strip_tags($this->placed_student_id));

        $stmt->bindParam(':placed_student_id', $this->placed_student_id);

        // If data updated successfully, return True
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
