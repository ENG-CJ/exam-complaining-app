<?php
include '../db/db.php';
class Subjects extends DatabaseConnection
{
    public function createSubject()
    {
        extract($_POST);
        $response = [];


        $query = "INSERT INTO `subjects`(`name`,`semester_id`, `description`) 
        VALUES ('$name','$semester','$description')";
        $result = Subjects::db()->query($query);
        if ($result) {
            $response = ['status' => true, 'message' => 'subject has been successfully created'];
        } else {
            $response = ['status' => false, 'message' => $conn->error];
        }


        echo json_encode($response);
    }
    public function readSubjects()
    {

        $response = [];
        $data = [];

        $query = "SELECT
                subjects.id,
                subjects.name as subject,
                subjects.description,
                semesters.name as semster
                FROM subjects
                JOIN semesters
                ON subjects.semester_id=semesters.s_id
";
        $result = Subjects::db()->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $response = ['status' => true, 'data' => $data];
        } else {
            $response = ['status' => false, 'data' => Subjects::db()->error];
        }

        echo json_encode($response);
    }
    public function getSingleSubjectData()
    {
        extract($_POST);
        $response = [];
        $data = [];

        $query = "SELECT * FROM subjects where id = '$id'";
        $result =
            Subjects::db()->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $response = ['status' => true, 'data' => $data];
        } else {
            $response = ['status' => false, 'message' =>  Subjects::db()->error];
        }

        echo json_encode($response);
    }
    public function readSubjectsWithIdentifier()
    {
        extract($_POST);
        $response = [];
        $data = [];

        $query = "SELECT
                subjects.id,
                subjects.name as subject,
                subjects.description,
                semesters.name as semster
                FROM subjects
                JOIN semesters
                ON subjects.semester_id=semesters.s_id where semesters.name='$value'";
        $result =
            Subjects::db()->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $response = ['status' => true, 'data' => $data];
        } else {
            $response = ['status' => false, 'message' =>  Subjects::db()->error];
        }

        echo json_encode($response);
    }

    public function deleteSubjectData()
    {
        extract($_POST);
        $response = [];
        $query = "DELETE FROM `subjects` WHERE  id = '$id'";
        $result = Subjects::db()->query($query);

        if ($result) {
            $response = ['status' => true, 'message' => 'data has been successfully deleted'];
        } else {
            $response = ['status' => false, 'message' =>  Subjects::db()->error];
        }

        echo json_encode($response);
    }
    public function updateSubjectData()
    {
        extract($_POST);
        $response = [];
        $sql = "UPDATE `subjects` SET `name`='$subject',semester_id='$semester_id',`description`='$description' WHERE `id`='$id'";
        $result = Subjects::db()->query($sql);

        if ($result) {
            $response = ['status' => true, 'message' => 'Subject Has been Successfully updated'];
        } else {
            $response = ['status' => false, 'message' => Subjects::db()->error];
        }


        echo json_encode($response);
    }
}
$Subjects = new Subjects;
$action = $_POST['action'];
if (isset($action))
    $Subjects->$action();
