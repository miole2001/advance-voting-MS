<?php 
    ob_start(); 
    session_start();
    include("../components/user-header.php"); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_vote'])) {
        $name = $_POST['name'];
        $candidate_name = $_POST['candidate_name'];
        $position = $_POST['position'];
        $candidate_id = $_POST['candidate_id']; // We need this to check which candidate the user is voting for.

        // Check if the user has already voted for this candidate
        $check_vote_sql = "SELECT * FROM `voting_records` WHERE `voter_name` = ? AND `candidate_name` = ? LIMIT 1";
        $stmt_check_vote = $connData->prepare($check_vote_sql);
        $stmt_check_vote->execute([$name, $candidate_name]);
        $existing_vote = $stmt_check_vote->fetch(PDO::FETCH_ASSOC);

        if ($existing_vote) {
            // If the user has already voted, redirect with an error message
            $_SESSION['vote_error'] = 'You have already voted for this candidate!';
            header('Location: candidates.php');
            exit;
        }

        // If not, insert the vote into the voting_records table
        $insert_sql = "INSERT INTO `voting_records` (`voter_name`, `candidate_name`, `candidate_position`, `date_voted`) VALUES (?, ?, ?, NOW())";
        $stmt_insert = $connData->prepare($insert_sql);
        $stmt_insert->execute([$name, $candidate_name, $position]);

        // Redirect with success message
        $_SESSION['vote_success'] = 'Your vote has been successfully recorded!';
        header('Location: candidates.php');
        exit;
    }

    // Fetch the list of candidates and user details
    $candidates_list = $connData->query("SELECT * FROM `candidates`")->fetchAll(PDO::FETCH_ASSOC);

    $select_user = $connAccounts->prepare("SELECT * FROM `user_accounts` WHERE id = ? LIMIT 1");
    $select_user->execute([$user_id]);
    $user = $select_user->fetch(PDO::FETCH_ASSOC);
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
                <div class="col-sm-3 mb-3">
                    <div class="card">
                    <img class="card-img-top" src="<?php echo "../image/profile/" . $candidates['image']; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h3 class="card-title text-uppercase text-center"><?php echo($candidates['candidate_name']); ?></h3>
                            <p class="card-text">Position: <?php echo($candidates['position']); ?></p>
                            <p class="card-text">Email: <?php echo($candidates['email']); ?></p>

                            <!-- vote Candidate Button -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vote">
                                Vote
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
    <!-- /.container-fluid -->

    <!-- vote candidate Modal -->
<div class="modal fade" id="vote" tabindex="-1" role="dialog" aria-labelledby="voteLabel" aria-hidden="true">
    <div class="modal-dialog d-flex align-items-center" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voteLabel">VOTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="candidate_id" value="<?php echo ($candidates['id']); ?>">

                    <div class="form-group">
                        <label for="name">Voter Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo ($user['name']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="candidate_name">Candidate Name</label>
                        <input type="text" class="form-control" id="candidate_name" name="candidate_name" value="<?php echo ($candidates['candidate_name']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" id="position" name="position" value="<?php echo ($candidates['position']); ?>" readonly>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="add_vote">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

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