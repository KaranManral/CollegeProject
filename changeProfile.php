<?php
    require_once 'dbConfig.php';
    session_start();
    if(!isset($_SESSION['User_Logged_In']))
        echo "<script>parent.location.href='index.php';</script>";
    $email=$_SESSION['User_Logged_In'];
?>
<html>
    <head>
        <title>Change Image</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    </head>
    <style type="text/css">
        img {
            display: block;
            max-width: 100%;
        }
        .preview {
            overflow: hidden;
            width: 172px; 
            height: 172px;
            margin: 2vw;
            border: 1px solid grey;
            border-radius: 50%;
        }
        #container{
            position: absolute;    
            left: 50%;
            top: 50%;
            min-width: 30vw;
            min-height:30vh;
            transform: translate(-50%,-50%);
            border: solid rgb(85,178,182) 0.2vw;
            border-radius: 10px;
            padding: 2vw;
        }
        #preview{
            border: solid gray 0.2vw;
            border-radius: 50%;
            max-width: 200px;
            max-height: 200px;
            min-width: 172px;
            min-height: 172px;
            margin: 2vw;
        }
        #ima{
            display: none;
        }
        #image_label{
            border-radius: 6px;
            background-color: #2ecc71;
            color: white;
            padding: 1vw;
            margin: 1vw;
            cursor: pointer;
        }
        input[type=submit]{
            border-radius: 6px;
            background-color: rgb(85,178,182);
            color: white;
            border: solid rgb(85,178,182) 0.1vw;
            padding: 0.9vw;
            margin: 1vw;
            cursor: pointer;
        }
        #url_image{
            display: none;
        }
    </style>
    <body>
        <div id="container">
            <center>
            <form method="post">
                <img src="" id="preview">
                <input type="text" name="url" id="url_image">
                <input type="file" name="image" class="image" id="ima" accept="image/*">
                <label for="ima" id="image_label">Upload</label>
                <input type="submit" value="Submit" name="submit">
            </form>
            </center>
        </div>

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Crop image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">  
                                    <!--  default image where we will set the src via jquery-->
                                    <img id="image">
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="crop">Crop</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.js"></script>
<script>

    let bs_modal = $('#modal');
    let image = document.getElementById('image');
    let cropper,reader,file;
   

    $("body").on("change", ".image", function(e) {
        let files = e.target.files;
        let done = function(url) {
            image.src = url;
            bs_modal.modal('show');
        };


        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    bs_modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 172,
            height: 172,
        });

        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            document.getElementById('preview').src=url;
            let myImage = canvas.toDataURL("image/*");
            document.getElementById('url_image').value=myImage;
            $('#modal').modal('toggle');
        });
    });
</script>
</body>
</html>
<?php
    if(isset($_POST["submit"]))
    {
        $photo=$_POST['url'];
        $contents_split = explode(',', $photo);
        $encoded = $contents_split[count($contents_split)-1];
        $decoded = "";
        for ($i=0; $i < ceil(strlen($encoded)/256); $i++) {
            $decoded = $decoded . base64_decode(substr($encoded,$i*256,256)); 
        }
        $photo=addslashes($decoded);
        $sql ="UPDATE profiles SET photo='$photo' WHERE email='$email'";        
        if(mysqli_query($conn,$sql))
            echo "<script>alert('Profile Photo updated.');location.href='profile.php';</script>";
        else
            echo "<script>alert('Profile Photo not updated.');parent.location.reload();</script>";
    }
?>

