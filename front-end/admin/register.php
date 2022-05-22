

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> EDIT Admin Profile </h6>
        </div>
        <div class="card-body">
        <?php

            if(isset($_POST['edit_btn']))
            {
                $id = $_POST['edit_id'];
                
                $query = "SELECT * FROM slogin WHERE USN='$USN' ";
                $query_run = mysqli_query($connection, $query);

                foreach($query_run as $row)
                {
                    ?>

                        <form action=".php" method="POST">

                            <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">

                            <div class="form-group">
                                <label> Name </label>
                                <input type="text" name="edit_name" value="<?php echo $row['Name'] ?>" class="form-control"
                                    placeholder="Enter Name">

                                    <div class="form-group">
                                <label> User Name </label>
                                <input type="text" name="edit_username" value="<?php echo $row['USN'] ?>" class="form-control"
                                    placeholder="Enter Username">
                            </div>

                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="edit_password" value="<?php echo $row['Password'] ?>"
                                    class="form-control" placeholder="Enter Password">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="edit_email" value="<?php echo $row['Email'] ?>" class="form-control"
                                    placeholder="Enter Email">

                            <div class="form-group">
                                <label>Security Question</label>
                                <input type="text" name="edit_question" value="<?php echo $row[''] ?>" class="form-control"
                                    placeholder="Enter new Question">

                                    <div class="form-group">
                                <label>Answer</label>
                                <input type="text" name="edit_answer" value="<?php echo $row['email'] ?>" class="form-control"
                                    placeholder="Enter new answer">

                            <a href="register.php" class="btn btn-danger"> CANCEL </a>
                            <button type="submit" name="updatebtn" class="btn btn-primary"> Update </button>

                        </form>
                        <?php
                }
            }
        ?>
        </div>
    </div>
</div>

</div>