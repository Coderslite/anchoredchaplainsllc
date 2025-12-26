<?php include "includes/header.php";?>
<div class="content-page">
          <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    <h1>Books</h1>
                    <a href="new_book.php" class="btn btn-primary">New Book</a>
                    <table class="table">
                    <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                            ?>
                        <thead>
                            <th>S/N</th>
                            <th>Title</th>
                            <th>File</th>
                            <th>Created At</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php 
                            include "php/db_config.php";
                            $query = mysqli_query($con, "SELECT * FROM books");
                            $count =0;
                            while($row = mysqli_fetch_assoc($query)){
                                $count++;
                                ?>
                          
                            <tr>
                                <td><?php echo $count ?></td>
                                <td><?php echo $row['title'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['createdAt'] ?></td>
                                <td>
                                    <a href="php/delete_book.php?id=<?php echo $row['id'];?>" class="btn btn-danger text-white">Delete</a>
                                </td>
                            </tr>
                            <?php
                              }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
</div>
<?php include "includes/footer.php";?>