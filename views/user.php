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

    .update_info {
        background-color: #0E0C28;
        color: white !important;
        margin: 5px;
    }

    .saveBtn {
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
                    <h2 class="pageheader-title">Users</h2>
                    <p>Manage User Operations</p>

                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- basic table  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row gap-5 mb-3">
                            <!-- Row with two columns -->
                            <div class="col-6">
                                <button class="btn btnShowModal" id="showModal">
                                    Add New user
                                </button>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" style="padding: 12px;" placeholder="Enter username">
                            </div>
                        </div>
                        <div class="table-responsive mt-2">
                            <div class="table-responsive-sm">
                                <table class="table table-striped table-bordered first" id="tableData">
                                    <thead>
                                        <!-- Table header content -->
                                    </thead>
                                    <tbody>
                                        <!-- Table body content -->
                                    </tbody>
                                </table>
                            </div>
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
        <div class="modal" tabindex="-1" id="userModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="userForm">
                            <div class="form-group">
                                <input id="id" name="id" type="number" class="form-control p-3" readonly>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-form-label">Username</label>
                                <input id="username" name="username" type="text" class="form-control p-3" placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email</label>
                                <input id="email" name="email" type="email" class="form-control p-3" placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Password</label>
                                <input id="password" name="password" type="password" class="form-control p-3" placeholder="Enter Password">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" style="color: black;">
                                    <option value="">-- select status --</option>
                                    <option value="active">active</option>
                                    <option value="inactive">inactive</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="closeModal">Close</button>
                                <button type="submit" class="btn saveBtn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php
    include '../config/footer.php';
    ?>
    <script src="../js/user.js"></script>