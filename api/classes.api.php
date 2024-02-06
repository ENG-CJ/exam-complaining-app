<?php
header('Content-type: application/json');
include '../db/db.php';
class Classes extends DatabaseConnection
{

    // create classes API
    public function create_class_api($conn)
    {
        $response = [];
        if (!empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['s_id'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $s_id = $_POST['s_id'];
            $query = "INSERT INTO `classes`(`name`, `description`,`s_id`) 
        VALUES ('$name','$description','$s_id')";
            $result = $conn->query($query);
            if ($result) {
                $response = ['status' => true, 'data' => 'successfully created'];
            } else {
                $response = ['status' => true, 'data' => $conn->error];
            }
        } else {
            $response = ['status' => true, 'data' => 'missing required fields'];
        }

        echo json_encode($response);
    }

    // read all classes API

    public function read_all_classes_api($conn)
    {
        $response = [];
        $data = [];

        $query = "SELECT * FROM classes";
        $result = $conn->query($query);

        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $data = $row;
            }
            $response = ['status' => true, 'data' => $data];
        } else {
            $response = ['status' => false, 'data' => $conn->error];
        }

        echo json_encode($response);
    }


    // read single class API
    public function read_single_class_api($conn)
    {
        $response = [];
        $data = [];
        if (!empty($_POST['c_id'])) {
            $c_id = $_POST['c_id'];
            $query = "SELECT * FROM classes where c_id = '$c_id'";
            $result = $conn->query($query);

            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $data = $row;
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


    public function delete_class_api($conn)
    {
        $response = [];
        if (!empty($_POST['c_id'])) {
            $c_id = $_POST['c_id'];
            $query = "DELETE FROM `classes` WHERE  c_id = '$c_id'";
            $result = $conn->query($query);

            if ($result) {
                $response = ['status' => true, 'data' => 'successfully deleted'];
            } else {
                $response = ['status' => false, 'data' => $conn->error];
            }
        } else {
            $response = ['status' => false, 'data' => 'missing required field'];
        }
        echo json_encode($response);
    }

    // update classes API
    public function update_class_api($conn)
    {
        $response = [];
        if (!empty($_POST['s_id']) && !empty($_POST['name']) && !empty($_POST['description']) &&
        !empty($_POST['c_id'])  ) {
            $s_id = $_POST['s_id'];
            $c_id = $_POST['c_id'];
            $name = $_POST['name'];
            $description = $_POST['description'];

            // Check if classes exists
            $check_query = "SELECT * FROM `classes` WHERE `c_id`='$c_id'";
            $check_result = $conn->query($check_query);

            if ($check_result && $check_result->num_rows > 0) {
                $update_query = "UPDATE `classes` SET `name`='$name',`description`='$description' , `s_id`='$s_id'
                WHERE `c_id` = '$c_id'";
                $update_result = $conn->query($update_query);

                if ($update_result) {
                    $response = ['status' => true, 'data' => 'Successfully updated'];
                } else {
                    $response = ['status' => false, 'data' => $conn->error];
                }
            } else {
                $response = ['status' => false, 'data' => 'classes does not exist'];
            }
        } else {
            $response = ['status' => false, 'data' => 'Missing required fields'];
        }
        echo json_encode($response);
    }
}
$classes = new Classes;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $classes->$action(Classes::db());
    } else {
        echo json_encode(['status' => false, 'data' => 'Action is required']);
    }
}else {
    echo json_encode(['status' => false, 'data' => 'Invalid request method']);
}
