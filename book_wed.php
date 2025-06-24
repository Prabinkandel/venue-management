<?php 
    include("header.php");

    $id = $_GET['id'];    
    include('Database/connect.php');

    if (isset($_POST['submit'])) {
        // Get selected wedding details
        $list = mysqli_query($conn, "SELECT * FROM wedding WHERE id = $id");

        while ($q = mysqli_fetch_row($list)) {
            $id = $q[0];
            $image = $q[1];
            $name = $q[2];
            $price = $q[3];
        }

        // Clear previous temporary data
        mysqli_query($conn, "TRUNCATE TABLE temp");

        // ✅ FIXED THIS LINE: Removed * from DELETE
        mysqli_query($conn, "DELETE FROM booking");

        // Insert into temp table
        $qr1 = mysqli_query($conn, "INSERT INTO temp VALUES('$id', '$image', '$name', $price)");

        if ($qr1) {
            echo "<script>window.location.assign('cart.php');</script>";    
        } else {
            echo "<script>alert('Not added to cart');</script>";    
        }
    }
?>

<?php
    // Again fetching data for display
    $id = $_GET['id'];
    $list = mysqli_query($conn, "SELECT * FROM wedding WHERE id = $id");                

    while ($q = mysqli_fetch_row($list)) {
?>

<!-- modal -->
<div role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">    
                <a href="gallery.php">BACK TO WEDDING</a>                    
            </div> 
            <form method="post">
                <div class="modal-body">
                    <img src="images/<?php echo $q[1]; ?>" alt="img" height="300" width="545"> 
                    <p>
                        <br/>Name: <?php echo $q[2]; ?><br/>
                        Price: <?php echo $q[3]; ?><br/>
                        <input type='submit' name='submit' value='BOOK NOW' class='btn my'/>
                    </p>
                </div> 
            </form>
        </div>
    </div>
</div>
<br/><br/><br/>

<?php 
    } // close the while loop
    include("footer.php"); 
?>
