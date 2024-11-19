<?php 
    include("../components/admin-header.php"); 

    // Fetch all votes using PDO
    $all_votes = $connData->query("SELECT * FROM `voting_records`")->fetchAll(PDO::FETCH_ASSOC);

    // Fetch the number of candidates
    $query = "SELECT COUNT(*) AS candidate_count FROM `candidates`";
    $run_query = $connData->prepare($query);
    $run_query->execute();
    $candidate_count = $run_query->fetch(PDO::FETCH_ASSOC)['candidate_count'];


    // Fetch the number of users
    $query = "SELECT COUNT(*) AS user_count FROM `user_accounts`";
    $run_query = $connAccounts->prepare($query);
    $run_query->execute();
    $user_count = $run_query->fetch(PDO::FETCH_ASSOC)['user_count'];


    // Fetch the number of votes
    $query = "SELECT COUNT(*) AS vote_count FROM `voting_records`";
    $run_query = $connData->prepare($query);
    $run_query->execute();
    $vote_count = $run_query->fetch(PDO::FETCH_ASSOC)['vote_count'];
?>

<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <?php include("../components/topbar.php"); ?>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Candidates Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Candidates
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $candidate_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-fw fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Voters Card (Example, you can update it as needed) -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Voters
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $user_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-fw fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Votes Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Votes
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            <?php echo $vote_count; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-fw fa-chart-bar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- DataTable for Vote History -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Vote History</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Voter Name</th>
                                <th>Candidate</th>
                                <th>Position</th>
                                <th>Date Voted</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Voter Name</th>
                                <th>Candidate</th>
                                <th>Position</th>
                                <th>Date Voted</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                $count = 1;
                                foreach ($all_votes as $votes):
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo ($votes['voter_name']); ?></td>
                                    <td><?php echo ($votes['candidate_name']); ?></td>
                                    <td><?php echo ($votes['candidate_position']); ?></td>
                                    <td><?php echo ($votes['date_voted']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<?php include("../components/footer.php"); ?>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php include("../components/scripts.php"); ?>

</body>

</html>
