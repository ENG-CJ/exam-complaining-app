<?php
header('Content-type: application/json');
include '../db/db.php';
class Complain extends DatabaseConnection
{
    // create complain API
    public function create_complain_api($conn)
    {
        // extract($_POST);
        $response = [];
        if (
            !empty($_POST['subjects']) && !empty($_POST['std_id']) && !empty($_POST['description'])
            && !empty($_POST['status'])
        ) {
            $subjects = $_POST['subjects'];
            $std_id = $_POST['std_id'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $query = "INSERT INTO `complains`(`subjects`, `std_id`,`description`,`status`) 
            VALUES ('$subjects','$std_id','$description','$status')";
            $result = $conn->query($query);
            if ($result) {
                $response = ['status' => true, 'data' => 'successfully created'];
            } else {
                $response = ['status' => false, 'data' => $conn->error];
            }
        } else {
            $response = ['status' => false, 'data' => 'missing required fields'];
        }

        echo json_encode($response);
    }

    // read all complain API
    public function read_all_complains_api($conn)
    {
        $response = [];
        $data = [];

        $query = "SELECT * FROM `complains`";
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

    public function readcomplains($conn)
    {
        $response = [];
        $data = [];

        $query = "SELECT * FROM `complains`";
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

    // read single complain API
    public function read_single_complain_api($conn)
    {
        $response = [];
        $data = [];
        if (!empty($_POST['com_id'])) {
            $com_id = $_POST['com_id'];
            $query = "SELECT * FROM `complains` where `com_id` = '$com_id'";
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


    public function delete_complain_api($conn)
    {
        $response = [];
        if (!empty($_POST['com_id'])) {
            $com_id = $_POST['com_id'];
            // Check if complain exists
            $check_query = "SELECT * FROM `complains` WHERE `com_id`='$com_id'";
            $check_result = $conn->query($check_query);
            if ($check_result && $check_result->num_rows > 0) {
                $query = "DELETE FROM `complains` WHERE  `com_id` = '$com_id'";
                $result = $conn->query($query);
                if ($result) {
                    $response = ['status' => true, 'data' => 'successfully deleted'];
                } else {
                    $response = ['status' => false, 'data' => $conn->error];
                }
            } else {
                $response = ['status' => false, 'data' => 'complain does not exist'];
            }
        } else {
            $response = ['status' => false, 'data' => 'missing required field'];
        }
        echo json_encode($response);
    }

    // update complain API
    public function update_complain_api($conn)
    {
        $response = [];
        if (
            !empty($_POST['subjects']) && !empty($_POST['std_id']) && !empty($_POST['description'])
            && !empty($_POST['status'])
        ) {
            $com_id = $_POST['com_id'];
            $subjects = $_POST['subjects'];
            $std_id = $_POST['std_id'];
            $description = $_POST['description'];
            $status = $_POST['status'];

            // Check if complain exists
            $check_query = "SELECT * FROM `complains` WHERE `com_id`='$com_id'";
            $check_result = $conn->query($check_query);

            if ($check_result && $check_result->num_rows > 0) {
                $update_query = "UPDATE `complains` SET `subjects`='$subjects',`std_id`='$std_id' , 
                `description` = '$description' , `status` = '$status' WHERE `com_id`='$com_id'";
                $update_result = $conn->query($update_query);

                if ($update_result) {
                    $response = ['status' => true, 'data' => 'Successfully updated'];
                } else {
                    $response = ['status' => false, 'data' => $conn->error];
                }
            } else {
                $response = ['status' => false, 'data' => 'complain does not exist'];
            }
        } else {
            $response = ['status' => false, 'data' => 'Missing required fields'];
        }
        echo json_encode($response);
    }

    // update complain status  API
    public function update_complain_status_api($conn)
    {
        $response = [];
        if (
            !empty($_POST['com_id']) && !empty($_POST['status'])
        ) {
            $com_id = $_POST['com_id'];
            $status = $_POST['status'];

            // Check if complain exists
            $check_query = "SELECT * FROM `complains` WHERE `com_id`='$com_id'";
            $check_result = $conn->query($check_query);

            if ($check_result && $check_result->num_rows > 0) {
                $update_query = "UPDATE `complains` SET   `status` = '$status' WHERE `com_id`='$com_id'";
                $update_result = $conn->query($update_query);

                if ($update_result) {
                    $response = ['status' => true, 'data' => 'Successfully updated'];
                } else {
                    $response = ['status' => false, 'data' => $conn->error];
                }
            } else {
                $response = ['status' => false, 'data' => 'complain does not exist'];
            }
        } else {
            $response = ['status' => false, 'data' => 'Missing required fields'];
        }
        echo json_encode($response);
    }
}
$complain = new Complain;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $complain->$action(Complain::db());
    } else {
        echo json_encode(['status' => false, 'data' => 'Action is required']);
    }
} else {
    echo json_encode(['status' => false, 'data' => 'Invalid request method']);
}
