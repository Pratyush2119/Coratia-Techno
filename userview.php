<?php
session_start();
if($_SESSION['username']=='') {
    header("Location: index.html");
}
include('db_connection.php');
$sql="SELECT * FROM sampletab";
$result=$conn->query($sql);
$rcnt=mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User View</title>
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
                        <a class="nav-link" href="dashboard.php">
                            <span class="fa fa-home fa-lg"></span> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="fileupload.php">
                            <span class="fa fa-upload fa-lg"></span> Upload
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="userview.php">
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

    <div class="container dbdata">
        <?php
        if ($rcnt <= 0) {
        ?>
        <div class="row p-2" align="center">
            <div class="col-12">
                No records are present to be shown.
            </div>
        </div>
        <?php
        }
        else {
        ?>
        <div class="row p-2" align="center">
            <div class="col-12">
                <h3>User View of MySQL Database Data</h3>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-12 rowdata">
                <?php
                    echo "<form method='post' action='pdfconv.php' id='viewform'>";
                    echo "<table class='table table-striped'>";
                    echo "<thead class='table-dark'><tr>";
                    echo "<th scope='col' style='text-align:center'>Select</th>";
                    echo "<th scope='col' style='text-align:center'>A</th>";
                    echo "<th scope='col' style='text-align:center'>B</th>";
                    echo "<th scope='col' style='text-align:center'>C</th>";
                    echo "</tr></thead><tbody>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='text-align:center'><input type='checkbox' name='choices[]' id='".$row['rid']."' value='".$row['rid']."'></td>";
                        if ($row['A']!='') {
                            echo "<td style='text-align:center'>".$row['A']."</td>";
                        }
                        else {
                            echo "<td style='text-align:center'>&#8212;</td>";
                        }
                        if ($row['B']!='') {
                            echo "<td style='text-align:center'>".$row['B']."</td>";
                        }
                        else {
                            echo "<td style='text-align:center'>&#8212;</td>";
                        }
                        if ($row['C']!='') {
                            echo "<td style='text-align:center'>".$row['C']."</td>";
                        }
                        else {
                            echo "<td style='text-align:center'>&#8212;</td>";
                        }
                        echo "</tr>";
                    }
                    echo "<tr>";
                    echo "<td colspan='2' style='text-align:center'>";
                    echo "<input type='reset' class='btn btn-primary' value='Reset'>";
                    echo "</td>";
                    echo "<td colspan='2' style='text-align:center'>";
                    echo "<input type='submit' class='btn btn-primary' value='Generate PDF' name='submit'>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</tbody></table>";
                    echo "</form>";
                ?>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</body>
</html>