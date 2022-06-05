<?php
session_start();
if($_SESSION['username']=='') {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FileUpload</title>
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
                        <a class="nav-link active" aria-current="page" href="fileupload.php">
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

    <div class="container filesec">
        <div class="row p-2">
            <div class="col-12">
                <form method="post" id="file-data" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <label for="fileupl">
                                <h5><b>Choose the file to upload to Database.</b></h5>
                            </label>
                        </div>
                    </div>
                    <hr style="width:100%;margin-top:5px;">
                    <div class="row p-2 filemsg" id="filemsg">

                    </div>
                    <div class="row p-2">
                        <div class="col-12">
                            <input type="file" id="fileupl" name="fileupl">
                        </div>
                    </div>
                    <div class="row p-2" align="center">
                        <div class="col-12">
                            <input type="submit" name="upldata" id="upldata" class="btn btn-primary" value="Upload Data">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#file-data').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url: "upload.php",
                    method:"POST",
                    data: new FormData(this),
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend: function(){
                        $('#upldata').attr('disabled', 'disabled');
                        $('#upldata').val('Uploading...');
                    },
                    success:function(data) {
                        $('#filemsg').empty().append(data);
                        $('#filemsg').show();
                        $('#file-data')[0].reset();
                        $('#upldata').attr('disabled', false);
                        $('#upldata').val('Upload Data');
                    }
                })
            });
        });
    </script>
</body>
</html>