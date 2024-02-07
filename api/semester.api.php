<?php
header('Content-type: application/json');
include '../db/db.php';
class Semester extends DatabaseConnection
{
    // create semester API
    public function create_semester_api($conn)
    {
        $response = [];
        if (!empty($_POST['name']) && !empty($_POST['description'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            // Check if semester exists
            $check_query = "SELECT * FROM `semesters` WHERE `name`='$name'";
            $check_result = $conn->query($check_query);
            if ($check_result && $check_result->num_rows > 0) {
                $response = ['status' => false, 'data' => 'semester name already exist'];
            } else {
                $query = "INSERT INTO `semesters`(`name`, `description`) 
                VALUES ('$name','$description')";
                $result = $conn->query($query);
                if ($result) {
                    $response = ['status' => true, 'data' => 'successfully created'];
                } else {
                    $response = ['status' => false, 'data' => $conn->error];
                }
            }
        } else {
            $response = ['status' => false, 'data' => 'missing required fields'];
        }

        echo json_encode($response);
    }

    // read all semester API

    public function read_all_semester_api($conn)
    {
        $response = [];
        $data = [];

        $query = "SELECT * FROM semesters";
        $result = $conn->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $response = ['status' => true, 'data' => $data];
        } else {
            $response = ['status' => false, 'data' => $conn->error];
        }

        echo json_encode($response);
    }

    public function readSemesters($conn)
    {
        $response = [];
        $data = [];

        $query = "SELECT * FROM semesters";
        $result = $conn->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $response = ['status' => true, 'data' => $data];
        } else {
            $response = ['status' => false, 'data' => $conn->error];
        }

        echo json_encode($response);
    }

    // read single semester API
    public function read_single_semester_api($conn)
    {
        $response = [];
        $data = [];
        if (!empty($_POST['s_id'])) {
            $s_id = $_POST['s_id'];
            $query = "SELECT * FROM semesters where s_id = '$s_id'";
            $result = $conn->query($query);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                $response = ['status' => true, 'data' => $data];
            } else {
                $response = ['status' => false, 'data' => $conn->error];
            }
        } else {
            $response = ['status' => false, 'data' => 'missing required field'];
        }
        echo json_encode($response);
    }


    public function delete_semester_api($conn)
    {
        $response = [];
        if (!empty($_POST['s_id'])) {
            $s_id = $_POST['s_id'];
            // Check if semester exists
            $check_query = "SELECT * FROM `semesters` WHERE `s_id`='$s_id'";
            $check_result = $conn->query($check_query);
            if ($check_result && $check_result->num_rows > 0) {
                $query = "DELETE FROM `semesters` WHERE  s_id = '$s_id'";
                $result = $conn->query($query);
                if ($result) {
                    $response = ['status' => true, 'data' => 'successfully deleted'];
                } else {
                    $response = ['status' => false, 'data' => $conn->error];
                }
            } else {
                $response = ['status' => false, 'data' => 'Semester does not exist'];
            }
        } else {
            $response = ['status' => false, 'data' => 'missing required field'];
        }
        echo json_encode($response);
    }

    // update semester API
    public function update_semester_api($conn)
    {
        $response = [];
        if (!empty($_POST['s_id']) && !empty($_POST['name']) && !empty($_POST['description'])) {
            $s_id = $_POST['s_id'];
            $name = $_POST['name'];
            $description = $_POST['description'];

            // Check if semester exists
            $check_query = "SELECT * FROM `semesters` WHERE `s_id`='$s_id'";
            $check_result = $conn->query($check_query);

            if ($check_result && $check_result->num_rows > 0) {
                $update_query = "UPDATE `semesters` SET `name`='$name',`description`='$description' WHERE `s_id`='$s_id'";
                $update_result = $conn->query($update_query);

                if ($update_result) {
                    $response = ['status' => true, 'data' => 'Successfully updated'];
                } else {
                    $response = ['status' => false, 'data' => $conn->error];
                }
            } else {
                $response = ['status' => false, 'data' => 'Semester does not exist'];
            }
        } else {
            $response = ['status' => false, 'data' => 'Missing required fields'];
        }
        echo json_encode($response);
    }
}
$semester = new Semester;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $semester->$action(Semester::db());
    } else {
        echo json_encode(['status' => false, 'data' => 'Action is required']);
    }
} else {
    echo json_encode(['status' => false, 'data' => 'Invalid request method']);
}
