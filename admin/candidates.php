<?php 
    ob_start(); 
    
    include("../components/admin-header.php"); 

    // Handle the form submission for adding a new candidate
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_candidate'])) {
        $name = $_POST['candidate_name'];
        $email = $_POST['email'];
        $position = $_POST['position'];
        $image = $_FILES['profile'];

        // Check if the image file is uploaded successfully
        if ($image['error'] === UPLOAD_ERR_OK) {
            $image_name = $image['name'];

            $insert_sql = "INSERT INTO `candidates` (`candidate_name`, `email`, `position`, `image`) VALUES (?, ?, ?, ?)";
            $stmt_insert = $connData->prepare($insert_sql);
            $stmt_insert->execute([$name, $email, $position, $image_name]);

            header('Location: candidates.php');
            exit;
        } else {
            // Handle image upload error
            echo "Error uploading the image file.";
        }
    }

    // Handle the form submission for updating an existing candidate
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_candidate'])) {
        $name = $_POST['candidate_name'];
        $email = $_POST['email'];
        $position = $_POST['position'];
        $candidate_id = $_POST['candidate_id'];

        $update_sql = "UPDATE `candidates` SET `candidate_name` = ?, `email` = ?, `position` = ? WHERE `id` = ?";
        $stmt_update = $connData->prepare($update_sql);
        $stmt_update->execute([$name, $email, $position, $candidate_id]);

        // Redirect to the candidates page after update
        header('Location: candidates.php');
        exit;
    }

    // Handle deletion of candidate
    if (isset($_GET['delete_candidate'])) {
        $candidate_id = $_GET['delete_candidate'];

        // Prepare SQL query to delete the candidate
        $delete_sql = "DELETE FROM `candidates` WHERE `id` = ?";
        $stmt_delete = $connData->prepare($delete_sql);
        $stmt_delete->execute([$candidate_id]);

        // Redirect to the candidates page after deletion
        header('Location: candidates.php');
        exit;
    }

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
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCandidate">
            Add New Candidate
            </button>
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
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editCandidate">
                                Edit Information
                            </button>
                            <!-- Delete Candidate Button -->
                            <button type="button" class="btn btn-danger delete-btn" data-id="<?php echo($candidates['id']); ?>">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- /.container-fluid -->


<!-- add candidate Modal -->
<div class="modal fade" id="addCandidate" tabindex="-1" role="dialog" aria-labelledby="addCandidateTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCandidateTitle">Add New Candidate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="profile">Upload Profile</label>
                        <input type="file" class="form-control" id="profile" name="profile" required>
                    </div>

                    <div class="form-group">
                        <label for="candidate_name">Candidate Name</label>
                        <input type="text" class="form-control" id="candidate_name" name="candidate_name" required>
                    </div>

                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" id="position" name="position" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="add_candidate">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- edit candidate Modal -->
<div class="modal fade" id="editCandidate" tabindex="-1" role="dialog" aria-labelledby="editCandidateLabel" aria-hidden="true">
    <div class="modal-dialog d-flex align-items-center" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCandidateLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="candidate_id" value="<?php echo ($candidates['id']); ?>">

                    <div class="form-group">
                        <label for="candidate_name">Full Name</label>
                        <input type="text" class="form-control" id="candidate_name" name="candidate_name" value="<?php echo ($candidates['candidate_name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" id="position" name="position" value="<?php echo ($candidates['position']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo ($candidates['email']); ?>" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="update_candidate">Save changes</button>
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

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const candidateId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "candidates.php?delete_candidate=" + candidateId;
                }
            });
        });
    });
</script>

<?php include("../components/scripts.php"); ?>

</body>

</html>