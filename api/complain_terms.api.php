<?php
header('Content-type: application/json');
include '../db/db.php';
class ComplainTerms extends DatabaseConnection
{
    // create complain_terms API
    public function create_complain_terms_api($conn)
    {
        $response = [];
        if (
            !empty($_POST['subject_length']) && !empty($_POST['start_date']) && !empty($_POST['expire_date'])
            && !empty($_POST['description'])
        ) {
            $subject_length = $_POST['subject_length'];
            $start_date = $_POST['start_date'];
            $expire_date = $_POST['expire_date'];
            $description = $_POST['description'];
            $query = "INSERT INTO `complain_terms`(`subject_length`, `start_date`,`expire_date`,`description`) 
            VALUES ('$subject_length','$start_date','$expire_date','$description')";
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

    // read all complain_terms API
    public function read_all_complain_terms_api($conn)
    {
        $response = [];
        $data = [];

        $query = "SELECT * FROM complain_terms";
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

    public function readcomplain_terms($conn)
    {
        $response = [];
        $data = [];

        $query = "SELECT * FROM complain_terms";
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

    // read single complain_terms API
    public function read_single_complain_terms_api($conn)
    {
        $response = [];
        $data = [];
        if (!empty($_POST['term_id'])) {
            $term_id = $_POST['term_id'];
            $query = "SELECT * FROM complain_terms where term_id = '$term_id'";
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


    public function delete_complain_terms_api($conn)
    {
        $response = [];
        if (!empty($_POST['term_id'])) {
            $term_id = $_POST['term_id'];
            // Check if complain_terms exists
            $check_query = "SELECT * FROM `complain_terms` WHERE `term_id`='$term_id'";
            $check_result = $conn->query($check_query);
            if ($check_result && $check_result->num_rows > 0) {
                $query = "DELETE FROM `complain_terms` WHERE  term_id = '$term_id'";
                $result = $conn->query($query);
                if ($result) {
                    $response = ['status' => true, 'data' => 'successfully deleted'];
                } else {
                    $response = ['status' => false, 'data' => $conn->error];
                }
            } else {
                $response = ['status' => false, 'data' => 'complain_terms does not exist'];
            }
        } else {
            $response = ['status' => false, 'data' => 'missing required field'];
        }
        echo json_encode($response);
    }

    // update complain_terms API
    public function update_complain_terms_api($conn)
    {
        $response = [];
        if (
            !empty($_POST['term_id']) && !empty($_POST['subject_length']) && !empty($_POST['start_date']) && !empty($_POST['expire_date'])
            && !empty($_POST['description'])
        ) {
            $term_id = $_POST['term_id'];
            $subject_length = $_POST['subject_length'];
            $start_date = $_POST['start_date'];
            $expire_date = $_POST['expire_date'];
            $description = $_POST['description'];

            // Check if complain_terms exists
            $check_query = "SELECT * FROM `complain_terms` WHERE `term_id`='$term_id'";
            $check_result = $conn->query($check_query);

            if ($check_result && $check_result->num_rows > 0) {
                $update_query = "UPDATE `complain_terms` SET `subject_length`='$subject_length',`start_date`='$start_date' , 
                `expire_date` = '$expire_date' , `description` = '$description' WHERE `term_id`='$term_id'";
                $update_result = $conn->query($update_query);

                if ($update_result) {
                    $response = ['status' => true, 'data' => 'Successfully updated'];
                } else {
                    $response = ['status' => false, 'data' => $conn->error];
                }
            } else {
                $response = ['status' => false, 'data' => 'complain_terms does not exist'];
            }
        } else {
            $response = ['status' => false, 'data' => 'Missing required fields'];
        }
        echo json_encode($response);
    }
}
$complain_terms = new ComplainTerms;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $complain_terms->$action(ComplainTerms::db());
    } else {
        echo json_encode(['status' => false, 'data' => 'Action is required']);
    }
} else {
    echo json_encode(['status' => false, 'data' => 'Invalid request method']);
}
