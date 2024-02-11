<?php
include '../config/header.php';
include '../config/sidebar.php';
?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #0E0C28;
        color: white !important;
    }

    tbody tr:hover {
        background-color: #f5f5f5;
    }

    .btnShowModal {
        background-color: #0E0C28;
        color: white !important;
    }

    .editStudent, .updatePassword , .saveBtn,  .createStudent {
        background-color: #0E0C28;
        color: white !important;
        margin: 5px;
    }
    .saveBtn{
        background-color: #0E0C28;
        color: white !important;
    }

    @media screen and (max-width: 768px) {

        .table-responsive-sm {
            overflow-x: auto;
        }

        .table-responsive-sm thead {
            display: none;
        }

        .table-responsive-sm tbody tr {
            display: block;
            margin-bottom: 1rem;
        }

        .table-responsive-sm tbody tr td {
            display: block;
            text-align: right;
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
        }

        .table-responsive-sm tbody tr td:before {
            content: attr(data-label);
            float: left;
            text-transform: uppercase;
            font-weight: bold;
        }
    }
</style>
<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Students</h2>
                    <p>Manage Student Operations</p>

                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- basic table  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row gap-5">
                            <!-- Row with two columns -->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <button class="btn createStudent">
                                    Create Student
                                </button>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <input type="text" class="form-control search" style="padding: 12px;" placeholder="Enter StudentID  Or Name">
                            </div>
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="table table-striped table-bordered first studentsTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Semester</th>
                                        <th>Class</th>
                                        <th>Privacy</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end basic table  -->
            <!-- ============================================================== -->

        </div>
        <!-- Button trigger modal -->
        <!-- Modal -->
        <div class="modal studentsModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="semesterForm">
                            <div class="form-group id-body">
                                <label for="name" class="col-form-label">ID</label>
                                <input id="name" name="name" type="text" class="form-control p-3 id" placeholder="example: C120001">
                                <span class="text-danger">* An Id Must be prefix With "C" Character And The Rest Must Be Digits</span>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-form-label">FullName</label>
                                <input id="name" name="name" type="text" class="form-control p-3 name" placeholder="Enter Student's FullName">
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Gender</label>
                                <select name="" id="" class="form-control gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-form-label">Mobile</label>
                                <input id="name" name="name" type="text" class="form-control p-3 mobile" placeholder="61xxxxxxxxx">
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Address</label>
                                <input id="name" name="name" type="text" class="form-control p-3 address" placeholder="e.g Hodan">
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Semester</label>
                                <select name="" id="" class="form-control semester">
                                    <option value="">Select</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Class</label>
                                <select name="" id="" class="form-control class">
                                    <option value="">Select</option>

                                </select>
                            </div>

                            <div class="form-group password-body">
                                <label for="name" class="col-form-label">Password</label>
                                <input id="name" name="name" type="text" class="form-control p-3 password" placeholder="4 Digit Number">
                                <button class="btn btn primary generate">Auto Generate</button>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Profile Photo</label>
                                <input type="file" class="form-control p-3 profile" placeholder="Enter Student's FullName">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" id="closeModal">Close</button>
                                <button type="button" class="btn save saveBtn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- image modal -->
        <div class="modal imageModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="img-body"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- password modal -->
        <div class="modal passwordModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Password</label>
                            <input id="name" name="name" type="text" class="form-control mb-2 p-3 newPassword" placeholder="4 Digit Number">
                            <input id="name" name="name" type="hidden" class="form-control mb-2 p-3 hidden-id" placeholder="4 Digit Number">
                            <button class="btn btn primary generate">Auto Generate</button>
                            <button class="btn btn-primary updatePassword">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php
    include '../config/footer.php';
    ?>
    <script src="../js/student.js"></script>