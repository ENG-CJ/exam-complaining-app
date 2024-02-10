
<?php
include_once "../db/db.php";

class Students extends DatabaseConnection
{

    public function createStudent()
    {
        extract($_POST);
        $filename = $_FILES['profile']['name'];
        $extractedExtension = explode(".", $filename);
        $actualExtension = end($extractedExtension);
        $temFolder = $_FILES['profile']['tmp_name'];
        $actualFileName = rand() . "." . $actualExtension;
        $uploadedPath = "../uploads/" . $actualFileName;

        $isUploaded = Students::uploadProfilePhoto($temFolder, $uploadedPath);
        if (!$isUploaded)
            return;
        Students::insertStudentInDatabase($actualFileName);
    }


    private static function insertStudentInDatabase($photo)
    {
        extract($_POST);
        $response = array();

        $sql = "INSERT INTO students VALUES('$id','$name','$gender','$mobile','$address','$semester','$class','$photo','$password')";
        $result = Students::db()->query($sql);
        if ($result)
            $response = array("status" => true, "message" => "Student With Name $name Has been created");
        else
            $response = array("status" => false, "message" => Students::db()->error);

        echo json_encode($response);
    }
    private static function uploadProfilePhoto($temp, $actualPath): bool
    {
        $isUploaded = false;
        if (move_uploaded_file($temp, $actualPath))
            $isUploaded = true;

        return $isUploaded;
    }

    public function readStudents()
    {
        $response = [];
        $data = [];

        $query = "SELECT 
        id,
                    students.name as studentName,
                    gender,
                    mobile,
                    address,
                    semester.name as semester,
                    semester.s_id,
                    classes.name as class,
                    classes.c_id,
                    students.image,
                    students.password
                    FROM `students`
                    JOIN semester
                    ON students.semester_id=semester.s_id
                    JOIN classes
                    ON students.class_id=classes.c_id";
        $result = Students::db()->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $response = ['status' => true, 'data' => $data];
        } else {
            $response = ['status' => false, 'data' => Students::db()->error];
        }

        echo json_encode($response);
    }


    public function readStudentsWithIdentifier()
    {
        extract($_POST);
        $response = [];
        $data = [];

        $query = "SELECT 
        id,
                    students.name as studentName,
                    gender,
                    mobile,
                    address,
                    semester.name as semester,
                    semester.s_id,
                    classes.name as class,
                    classes.c_id,
                    students.image,
                    students.password
                    FROM `students`
                    JOIN semester
                    ON students.semester_id=semester.s_id
                    JOIN classes
                    ON students.class_id=classes.c_id
                    where id='$value' or students.name='$value'
                    ";
        $result = Students::db()->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $response = ['status' => true, 'data' => $data];
        } else {
            $response = ['status' => false, 'data' => Students::db()->error];
        }

        echo json_encode($response);
    }
    public function deleteStudent()
    {
        $response = [];
        extract($_POST);

        $query = "DELETE FROM students where id='$id'";
        $result = Students::db()->query($query);

        if ($result)
            $response = ['status' => true, 'message' => "Data Has been successfully removed"];
        else
            $response = ['status' => false, 'data' => Students::db()->error];


        echo json_encode($response);
    }
    public function updateStudentPassword()
    {
        $response = [];
        extract($_POST);

        $query = "UPDATE students set Password='$password' where id='$id'";
        $result = Students::db()->query($query);

        if ($result)
            $response = ['status' => true, 'message' => "Student Password has been updated"];
        else
            $response = ['status' => false, 'data' => Students::db()->error];


        echo json_encode($response);
    }

    public function fetchStudentPassword()
    {
        $response = [];
        extract($_POST);

        $query = "SELECT id,password from students where id='$id'";
        $result = Students::db()->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            $response = ['status' => true, "id" => $row['id'], 'password' => $row['password']];
        } else
            $response = ['status' => false, 'data' => Students::db()->error];


        echo json_encode($response);
    }
    public function getSingleStudentData()
    {
        $response = [];
        $data = [];
        extract($_POST);

        $query = "SELECT * from students where id='$id'";
        $result = Students::db()->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc())
                $data[] = $row;
            $response = ['status' => true, 'data' => $data];
        } else
            $response = ['status' => false, 'data' => Students::db()->error];


        echo json_encode($response);
    }


    public function generateFourDigitPassword()
    {
        extract($_POST);

        $randomNumber = rand($min, $max);
        $paddedNumber = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
        $response = array("password" => $paddedNumber);
        echo json_encode($response);
    }


    // update student data 
    public function updateStudentData()
    {
        $response = [];
        extract($_POST);

        if ($isSelectedProfile == "true") {
            $filename = $_FILES['profile']['name'];
            $extractedExtension = explode(".", $filename);
            $actualExtension = end($extractedExtension);
            $temFolder = $_FILES['profile']['tmp_name'];
            $actualFileName = rand() . "." . $actualExtension;
            $uploadedPath = "../uploads/" . $actualFileName;

            $isUploaded = Students::uploadProfilePhoto($temFolder, $uploadedPath);
            // if the upload file fails
            if (!$isUploaded)
                return;
            $isUpdated = Students::updateStudentWithNewProfile($actualFileName);
            if ($isUpdated)
                $response = array("status" => true, "message" => "student has been updated");
            else
                $response = array("status" => true, "message" => "there is an error");
        } else {
            $query = "UPDATE students set name='$name', gender='$gender', mobile='$mobile', address='$address' ,semester_id='$semester', class_id='$class' where id='$id'";
            $result = Students::db()->query($query);
            if ($result)
                $response = ['status' => true, 'message' => "Student data has been updated"];
            else
                $response = ['status' => false, 'data' => Students::db()->error];
        }




        echo json_encode($response);
    }

    private static function updateStudentWithNewProfile($newPhoto): bool
    {
        extract($_POST);
        $hasUpdated = false;
        $query = "UPDATE students set name='$name', gender='$gender', mobile='$mobile', address='$address', semester_id='$semester', class_id='$class', image='$newPhoto' where id='$id'";
        $result = Students::db()->query($query);

        if ($result)
            $hasUpdated = true;
        return $hasUpdated;
    }

    public function Login()
    {
        extract($_POST);
        $response = [];
        $data = [];

        $query = "SELECT 
        id,
                    students.name as studentName,
                    gender,
                    mobile,
                    address,
                    semester.name as semester,
                    semester.s_id,
                    classes.name as className,
                    classes.c_id,
                    students.image,
                    students.password
                    FROM `students`
                    JOIN semester
                    ON students.semester_id=semester.s_id
                    JOIN classes
                    ON students.class_id=classes.c_id where students.id='$id' and students.password='$password'";
        $result = Students::db()->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $response = ['status' => true, 'data' => $data];
        } else {
            $response = ['status' => false, 'data' => Students::db()->error];
        }

        echo json_encode($response);
    }
}



$action = $_POST['action'];
$student = new Students;
if (isset($action))
    $student->$action();



?>