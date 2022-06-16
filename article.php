<?php
session_start();
if($_SESSION['username']=='') {
    header("Location: index.html");
}
include('db_connection.php');
$uname=$_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if(isset($_GET['proj'])) {
            echo "Project - ".$_GET['proj'];
        } else {
            echo "New Project";
        }
        ?>
    </title>
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

    <div class="container article-sec">

        <?php
        if(isset($_GET['proj'])) {
            $proj=$_GET['proj'];
            $sql="SELECT * FROM projects WHERE pname='$proj'";
            $result=$conn->query($sql);
            $row=$result->fetch_assoc();
            $data=json_decode($row['data'],true);
        ?>

        <div class="row">
            <form method="post" action="backend.php?uname=<?php echo $uname; ?>">
                <div class="row" align="center">
                    <div class="col-12">
                        <h4>View/ Edit the Article</h4>
                    </div>
                </div>
                <div class="col-12" id="article">
                    <?php
                    $count=1;
                    foreach ($data as $k=>$v) {
                        if($k == 'title' || $k == 'subtitle') {
                    ?>
                    
                    <div class="row p-2">
                        <div class="col-12 col-md-2 text-md-center">
                            <label for="<?php echo $k?>"><?php echo ucfirst($k); ?>:</label>
                        </div>
                        <div class="col-12 col-md-10">
                            <input type="text" name="<?php echo $k?>" id="<?php echo $k?>" style="width:100%;padding:5px;" value="<?php echo $v; ?>" autocomplete="off">
                        </div>
                    </div>
                    
                    <?php
                        }
                        else if (str_contains($k,'headingid')) {
                            if($count>1) {
                    ?>
                    </div></div></div>

                    <?php
                            }
                    ?>
                    <div class="row p-1 border-top">
                        <div class="col-12">
                            <div class="row p-1">
                                <div class="col-4 col-md-2 text-md-center">
                                    <label for="<?php echo $k; ?>">Heading Id:</label>
                                </div>
                                <div class="col-2 col-md-10">
                                    <input type="text" name="<?php echo $k; ?>" style="padding:5px;" id="<?php echo $k; ?>" value="<?php echo $v; ?>" autocomplete="off">
                                </div>
                            </div>
                    
                    <?php
                    $count = $count+1;
                        }
                        else if(str_contains($k,'heading')) {
                    ?>

                    <div class="row p-1">
                        <div class="col-12 col-md-2 text-md-center">
                            <label for="<?php echo $k; ?>">Heading Title:</label>
                        </div>
                        <div class="col-12 col-md-10">
                            <input type="text" name="<?php echo $k; ?>" id="<?php echo $k; ?>" style="width:100%;padding:5px;" value="<?php echo $v; ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="row p-1" id="content<?php echo $count;$count=$count+1;?>">
                        <div class="col-12 col-md-2 text-md-center">
                            <label>Content:</label>
                        </div>
                    
                    <?php
                        }
                        else if(str_contains($k,'sec')) {
                            if (substr($k,-1) != '1') {
                    ?>

                        <div class="col-12 col-md-10 offset-md-2">
                            <textarea name="<?php echo $k; ?>" id="<?php echo $k; ?>" style="width:100%;padding:5px;" rows="4"><?php echo $v; ?></textarea>
                        </div>
                    
                    <?php
                            }
                            else {
                    ?>
                        <div class="col-12 col-md-10">
                            <textarea name="<?php echo $k; ?>" id="<?php echo $k; ?>" style="width:100%;padding:5px;" rows="4"><?php echo $v; ?></textarea>
                        </div>
                    <?php
                        }
                    }
                    }
                    ?>
                    <div class="row p-2">
                        <div class="col-4 col-md-1 offset-md-11">
                            <input type="submit" class="btn btn-primary" name="saveArticle" value="Save">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <?php
        } else {
        ?>
        <div class="row" align="center">
            <div class="col-12">
                <h4>Create A New Article.</h4>
            </div>
        </div>
        <div class="row">
            <form method="post" action="backend.php?uname=<?php echo $uname; ?>" enctype="multipart/form-data">
                <div class="col-12" id="article">
                    <div class="row p-2">
                        <div class="col-12 col-md-2 text-md-center">
                            <label for="title">Title:</label>
                        </div>
                        <div class="col-12 col-md-10">
                            <input type="text" name="title" id="title" style="width:100%;padding:5px;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-12 col-md-2 text-md-center">
                            <label for="subtitle">Sub Title:</label>
                        </div>
                        <div class="col-12 col-md-10">
                            <input type="text" name="subtitle" id="subtitle" style="width:100%;padding:5px;" autocomplete="off">
                        </div>
                    </div>
                    <div class="row p-1 border-top">
                        <div class="col-12">
                            <div class="row p-1">
                                <div class="col-4 col-md-2 text-md-center">
                                    <label for="headingid1">Heading Id:</label>
                                </div>
                                <div class="col-2 col-md-10">
                                    <input type="text" name="headingid1" style="padding:5px;" id="headingid1" autocomplete="off">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-12 col-md-2 text-md-center">
                                    <label for="heading1">Heading Title:</label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="text" name="heading1" id="heading1" style="width:100%;padding:5px;" autocomplete="off">
                                </div>
                            </div>
                            <div class="row p-1" id="content1">
                                <div class="col-12 col-md-2 text-md-center">
                                    <label>Content:</label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <textarea name="sec1para1" id="sec1para1" style="width:100%;padding:5px;" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="row p-1 border-bottom">
                                <div class="col-5 col-md-2 offset-md-2">
                                    <button type="button" class="btn btn-dark btn-sm" onclick="addpara('1')">
                                        <span class="fa-solid fa-paragraph"></span> Add Paragraph
                                    </button>
                                </div>
                                <div class="col-5 col-md-2">
                                    <button type="button" class="btn btn-dark btn-sm" onclick="addimg('1')">
                                        <span class="fa-solid fa-image"></span> Add Image
                                    </button>
                                </div>
                                <div class="col-12 col-md-2 mt-1 mt-md-0">
                                    <button type="button" class="btn btn-dark btn-sm" onclick="addfile('1')">
                                        <span class="fa-solid fa-file"></span> Add File
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="text" name="list" id="list" style="width:100%;" value="title;subtitle;headingid1;heading1;sec1para1;" hidden>
        </div>
        <div class="row p-2">
            <div class="col-5 col-md-2" align="center">
                <button type="button" class="btn btn-secondary" id="addsec" onclick="addSection()">
                    Add Section
                </button>
            </div>
            <div class="col-4 col-md-1">
                <input type="submit" class="btn btn-primary" name="saveArticle" value="Save">
            </div>
            </form>
        </div>
        <?php
        }
        ?>
    </div>

    <script type="text/javascript">
        var count=1;
        var para=2;
        var imgcc=1;
        var filecc=1;
        function addSection() {
            count=count+1;
            var section="<div class='row p-1 border-top'><div class='col-12'><div class='row p-1'><div class='col-4 col-md-2 text-md-center'><label for='headingid"+count+"'>Heading Id:</label></div><div class='col-2 col-md-10'><input type='text' name='headingid"+count+"' style='padding:5px;' id='headingid"+count+"' autocomplete='off'></div></div><div class='row p-1'><div class='col-12 col-md-2 text-md-center'><label for='heading"+count+"'>Heading Title:</label></div><div class='col-12 col-md-10'><input type='text' name='heading"+count+"' id='heading"+count+"' style='width:100%;padding:5px;' autocomplete='off'></div></div><div class='row p-1' id='content"+count+"'><div class='col-12 col-md-2 text-md-center'><label>Content:</label></div><div class='col-12 col-md-10'><textarea name='sec"+count+"para1' id='sec"+count+"para1' style='width:100%;padding:5px;' rows='4'></textarea></div></div><div class='row p-1 border-bottom'><div class='col-5 col-md-2 offset-md-2'><button type='button' class='btn btn-dark btn-sm' onclick='addpara("+count+")'><span class='fa-solid fa-paragraph'></span> Add Paragraph</button></div><div class='col-5 col-md-2'><button type='button' class='btn btn-dark btn-sm' onclick='addimg("+count+")'><span class='fa-solid fa-image'></span> Add Image</button></div><div class='col-12 col-md-2 mt-1 mt-md-0'><button type='button' class='btn btn-dark btn-sm' onclick='addfile("+count+")'><span class='fa-solid fa-file'></span> Add File</button></div></div></div></div>";
            $('#article').append(section);
            document.getElementById("list").value += "headingid"+count+";heading"+count+";sec"+count+"para1;";
            para=2;
            imgcc=1;
            filecc=1;
        }

        function addpara(id) {
            var paragraph="<div class='col-12 col-md-10 offset-md-2'><textarea name='sec"+id+"para"+para+"' id='para"+para+"' style='width:100%;padding:5px;' rows='4'></textarea></div>";
            $('#content'+id).append(paragraph);
            document.getElementById("list").value += "sec"+id+"para"+para+";";
            para = para + 1;
        }

        function addimg(id) {
            var imgsec="<div class='col-12 col-md-10 offset-md-2 mb-2'>Image: <input type='file' name='sec"+id+"img"+imgcc+"' id='img"+imgcc+"' accept='image/*'></div>";
            $('#content'+id).append(imgsec);
            document.getElementById("list").value += "sec"+id+"img"+imgcc+";";
            imgcc = imgcc + 1;
        }

        function addfile(id) {
            var filesec="<div class='col-12 col-md-10 offset-md-2 mb-2'>File: <input type='file' name='sec"+id+"file"+filecc+"' id='file"+filecc+"'></div>";
            $('#content'+id).append(filesec);
            document.getElementById("list").value += "sec"+id+"file"+filecc+";";
            filecc = filecc + 1;
        }
    </script>
</body>
</html>