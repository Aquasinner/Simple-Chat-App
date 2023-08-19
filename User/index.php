<?php
include('../Config/config.php');
include('./data/data_model.php');

if (!isset($_SESSION['user_id']) || (trim($_SESSION['username'] == ''))) {
    header('location: ../');
}

$senderId = $_SESSION['user_id'];

$user_data = $user->userData($conn, $_SESSION['user_id']);
// $fetch_reciever = $user->allChatReciever($conn, $senderId);

?>

<!DOCTYPE html>
<html lang="en">

<?php include('Include/head.php'); ?>

<body>

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-3" style="width: 24rem; height: 35rem">
            <section class="user">
                <header class="d-flex justify-content-between align-items-center">
                    <div class="content column-gap-2 d-flex" id="profile" data-id='<?php echo $senderId; ?>'>
                        <img class="profile_img" src="..\Images\<?php echo $user_data['profile_img'] ?>" alt="profile_logo" width="50" height="50">
                        <div class="details">
                            <span><?php echo $user_data['first_name'] . ' ' . $user_data['last_name'] ?></span>
                            <p>Click Me....</p>
                        </div>
                    </div>
                    <button class="btn_log_out" id="log_out" name="log_out">Log out</button>

                </header>

                <form id="searchform" action="" method="post">
                    <div class="input-group mt-4">
                        <div class="input-group mb-3">
                            <input type="search" id="searchuser" name="search" class="form-control" placeholder="Search">
                            <span class="input-group-text hide"><button type="submit" class="btn_search"><i class="fa-solid fa fa-magnifying-glass"></i></button></span>
                        </div>
                    </div>
                </form>
            </section>
            <div id="searchResults" class="result d-flex row-gap-2 flex-column"></div>

            <div class="card-body user_list z-index-n1 p-0">
                <div class="r">
                    <script type="text/javascript">
                        $(document).ready(function() {
                            function fetchRecieverData() {
                                $.ajax({
                                    url: "reciever.php",
                                    method: "GET",
                                    dataType: "html",
                                    success: function(response) {
                                        $(".r").html(response);
                                        setTimeout(fetchRecieverData, 1000);
                                    },
                                    error: function(xhr, status, error) {
                                        console.log("Error: " + error);
                                    }
                                });
                            }

                            // Initial call to fetchRecieverData
                            fetchRecieverData();
                        });
                    </script>
                </div>




            </div>
        </div>
        <script src="../Js/script.js"></script>
        <script src="js/function.js"></script>
</body>

</html>