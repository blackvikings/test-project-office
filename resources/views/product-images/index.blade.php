<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @toastr_css
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .dropzone {
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            border-radius: 14px;
            background: #e3e6ff;
            border: 1px dotted #4e4e4e;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12" style="margin-top: 25px;">
            <a href="{{ route('products.index') }}" class="btn btn-primary" style="float: right;">Back</a>
        </div>
        <div class="col-md-12">
            <div class="card" style="margin-top: 20px;">
                <div class="card-header">Add Images</div>
                <div class="card-body">
                    <div id="dropzone">
                        <form action="{{ route('upload.image') }}" id="uploadFilesss" class="dropzone" enctype="multipart/form-data">
                            @csrf
                            <div class="dz-message">
                                Drag 'n' Drop Files<br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @foreach($images as $image)
            <div class="col-md-4" style="margin-top: 20px;">
            <div class="card" >
                <img src="{{ asset($image->image) }}" class="card-img-top">
                <div class="card-body">
                    <form method="POST" action="{{ route('image.destroy', $image->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger delete-image">Delete Image</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Modal -->
</body>
@jquery
@toastr_js
@toastr_render
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
<script>
    $('.delete-image').click(function(e){
        e.preventDefault() // Don't post the form, unless confirmed
        if (confirm('Are you sure?')) {
            // Post the form
            $(e.target).closest('form').submit() // Post the surrounding form
        }
    });


    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(".dropzone",{
        maxFilesize: 3,  // 3 mb
        acceptedFiles: ".jpeg,.jpg,.png",
    });
    myDropzone.on("sending", function(file, xhr, formData) {
        formData.append("_token", CSRF_TOKEN);
        formData.append("product_id", {{ $id }});
    });
    myDropzone.on("success", function (file, xhr, formData){
        location.reload();
    });
</script>
</html>
