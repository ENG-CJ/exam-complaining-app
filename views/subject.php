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
                    <h2 class="pageheader-title">Subjects</h2>
                    <p>Manage Subjects Operations</p>

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
                                <button class="btn btn-primary createSubject">
                                    Add New Subject
                                </button>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <select name="" id="" class="form-control filters">
                                    <option value="">Filter By Semester</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="table table-striped table-bordered first subjectsTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Subject</th>
                                        <th>Semester Assigned</th>
                                        <th>Description</th>
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
        <div class="modal subjectsModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="semesterForm">
                            <div class="form-group id-body">
                                <label for="name" class="col-form-label">Subject</label>
                                <input id="name" name="name" type="text" class="form-control p-3 subject" placeholder="e.g Java">
                                <input id="name" name="name" type="hidden" class="form-control p-3 hidden-id" placeholder="e.g Java">
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-form-label">Semester(Which Semester)</label>
                                <select name="" id="" class="form-control semester_id">
                                    <option value="">Select</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-form-label">Description [Option]</label>
                                <textarea name="" placeholder="More Description" id="" cols="30" rows="10" class="form-control description"></textarea>
                            </div>




                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" id="closeModal">Close</button>
                                <button type="button" class="btn btn-primary save">Save</button>
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
    <script src="../js/subject.js"></script>