<?php
session_start();
if($_SESSION['username']=='') {
    header("Location: index.php");
}
include('db_connection.php');
$uname=$_SESSION['username'];
$sql="SELECT * FROM projects WHERE creater='$uname'";
$result=$conn->query($sql);
$rcnt=mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
    <link type="text/css" href="styles.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
        <div class="container">
            <a href="#" class="navbar-brand">Coratia Techno</a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="true">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard.php">
                            <span class="fa fa-home fa-lg"></span> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="fileupload.php">
                            <span class="fa fa-upload fa-lg"></span> Upload
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="userview.php">
                            <span class="fa fa-database fa-lg"></span> View Data
                        </a>
                    </li>
                </ul>
                <a class="btn btn-primary" href="backend.php">
                    <span class="fa fa-arrow-right-from-bracket fa-lg"></span> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="ProjectModal" tabindex="-1" aria-labelledby="ProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ProjectModalLabel">Create a new Project.</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="backend.php" method="post">
                                <div class="row p-1">
                                    <div class="col-12">
                                        <label for="pname"><b>Project Name:</b></label>
                                    </div>
                                </div>
                                <div class="row p-1">
                                    <div class="col-12">
                                        <input type="text" id="pname" name="pname" style="width:100%;padding:5px;" autocomplete="off">
                                    </div>
                                </div>
                                <input type="text" id="creater" name="creater" value="<?php echo $_SESSION['username'];?>" hidden>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="newproj" value="Create Project">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container projects">
        <div class="row p-2">
            <div class="col-12">
                <div class="row">
                    <div class="col-4 col-md-1">
                        <button class="btn btn-secondary funbtn" data-bs-toggle="modal" data-bs-target="#ProjectModal">
                            <span class="fa-solid fa-plus"></span> Create
                        </button>
                    </div>
                    <div class="col-4 col-md-1">
                        <button type="submit" name="delete" form="viewprojects" class="btn btn-secondary funbtn">
                            <span class="fa-solid fa-trash-can"></span> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <hr style="margin-top:10px;">
        <?php
        if ($rcnt==0) {
        ?>
        <div class="row p-2" align="center">
            <div class="col-12">
                Click on the '<span class="fa-solid fa-plus"></span> Create' button to add new projects.
            </div>
        </div>
        <?php
        }
        else {
        ?>
        <div class="row p-2">
            <div class="col-12">
                <?php
                    echo "<form method='post' action='backend.php' id='viewprojects'>";
                    echo "<table class='table table-striped'><tbody>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td width='10%' style='text-align:center;'><input type='checkbox' name='choices[]' id='".$row['pid']."' value='".$row['pid']."'></td>";
                        echo "<td><a href='#' class='proj-links'>".$row['pname']."</a></td>";
                        echo "<td width='10%'><a href='backend.php?proj=".$row['pname']."' class='pdf-links'>Generate PDF</a></td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table></form>";
                ?>
            </div>
        </div>
        <?php
        }
        ?>
    </div>

</body>
</html>