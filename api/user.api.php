<?php
header('Content-type: application/json');
include '../db/db.php';
class User extends DatabaseConnection
{
    // create user API
    public function create_user_api($conn)
    {
        $response = [];
        if (
            !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])
            && !empty($_POST['status'])
        ) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $status = $_POST['status'];
            $password = md5($_POST['password']);
            // Check if user exists
            $check_query = "SELECT * FROM `users` WHERE `username`='$username'";
            $check_result = $conn->query($check_query);
            if ($check_result && $check_result->num_rows > 0) {
                $response = ['status' => false, 'data' => 'username already exist'];
            } else {
                $query = "INSERT INTO `users`(`username`, `email`,`password`,`status`) 
                VALUES ('$username','$email','$password','$status')";
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

    // read all user API

    public function read_all_users_api($conn)
    {
        $response = [];
        $data = [];

        $query = "SELECT * FROM users";
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

    public function readusers($conn)
    {
        $response = [];
        $data = [];

        $query = "SELECT * FROM users";
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

    // read single user API
    public function read_single_user_api($conn)
    {
        $response = [];
        $data = [];
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            $query = "SELECT * FROM users where id = '$id'";
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


    public function delete_user_api($conn)
    {
        $response = [];
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            // Check if user exists
            $check_query = "SELECT * FROM `users` WHERE `id`='$id'";
            $check_result = $conn->query($check_query);
            if ($check_result && $check_result->num_rows > 0) {
                $query = "DELETE FROM `users` WHERE  id = '$id'";
                $result = $conn->query($query);
                if ($result) {
                    $response = ['status' => true, 'data' => 'successfully deleted'];
                } else {
                    $response = ['status' => false, 'data' => $conn->error];
                }
            } else {
                $response = ['status' => false, 'data' => 'user does not exist'];
            }
        } else {
            $response = ['status' => false, 'data' => 'missing required field'];
        }
        echo json_encode($response);
    }

    // update user API
    public function update_user_api($conn)
    {
        $response = [];
        if (
            !empty($_POST['id']) && !empty($_POST['username']) && !empty($_POST['email'])
            && !empty($_POST['status'])
        ) {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $status = $_POST['status'];

            // Check if user exists
            $check_query = "SELECT * FROM `users` WHERE `id`='$id'";
            $check_result = $conn->query($check_query);

            if ($check_result && $check_result->num_rows > 0) {
                $update_query = "UPDATE `users` SET `username`='$username',`email`='$email' , `status` = '$status' WHERE `id`='$id'";
                $update_result = $conn->query($update_query);

                if ($update_result) {
                    $response = ['status' => true, 'data' => 'Successfully updated'];
                } else {
                    $response = ['status' => false, 'data' => $conn->error];
                }
            } else {
                $response = ['status' => false, 'data' => 'user does not exist'];
            }
        } else {
            $response = ['status' => false, 'data' => 'Missing required fields'];
        }
        echo json_encode($response);
    }
}
$user = new User;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $user->$action(User::db());
    } else {
        echo json_encode(['status' => false, 'data' => 'Action is required']);
    }
} else {
    echo json_encode(['status' => false, 'data' => 'Invalid request method']);
}
