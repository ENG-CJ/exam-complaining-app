<?php
include '../config/header.php';
include '../config/sidebar.php';
?>

<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Dashboard - Classes</h2>
                    <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Tables</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Class Data</li>
                            </ol>
                        </nav>
                    </div>
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
                                <button class="btn btn-primary" id="showModal">
                                    Add New Class
                                </button>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <input type="text" class="form-control" style="padding: 12px;" placeholder="Search Class Name">
                            </div>
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="table table-striped table-bordered first"  id="tableData">
                                <thead>
                                    
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
        <div class="modal" tabindex="-1" id="classModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="classForm">
                            <div class="form-group">
                                <input id="c_id" name="c_id" type="text" class="form-control p-3" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Name</label>
                                <input id="name" name="name" type="text" class="form-control p-3" placeholder="Enter Class Name">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="8" placeholder="Enter Class Description" 
                                class="form-control p-3">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="description">Semesters</label>
                                <select name="s_id" id="s_id"  class="form-control"
                                style="color: black;">
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeModal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
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
    <script src="../js/classes.js"></script>