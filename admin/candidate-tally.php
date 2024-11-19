<?php 
    include("../components/admin-header.php"); 

    $candidates_list = $connData->query("SELECT * FROM `candidates`")->fetchAll(PDO::FETCH_ASSOC);

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

        <div class="row">
            <?php foreach ($candidates_list as $candidates): ?>
                <?php 
                    // Count votes for this specific candidate
                    $candidate_name = $candidates['candidate_name'];
                    $count_votes_sql = "SELECT COUNT(*) as vote_count FROM `voting_records` WHERE `candidate_name` = ?";
                    $stmt_count_votes = $connData->prepare($count_votes_sql);
                    $stmt_count_votes->execute([$candidate_name]);
                    $vote_count = $stmt_count_votes->fetch(PDO::FETCH_ASSOC)['vote_count'];
                ?>
                <div class="col-sm-3 mb-3">
                    <div class="card">
                        <img class="card-img-top" src="<?php echo "../image/profile/" . $candidates['image']; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h3 class="card-title text-uppercase text-center"><?php echo($candidates['candidate_name']); ?></h3>
                            <p class="card-text">Position: <?php echo($candidates['position']); ?></p>
                            <p class="card-text">Email: <?php echo($candidates['email']); ?></p>
                            <!-- Display the vote count for this candidate -->
                            <p class="card-text">Total Votes: <?php echo $vote_count; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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