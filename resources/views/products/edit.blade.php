<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('fontawesome-free/css/fontawesome.css') }}">
    @toastr_css
    <style>
        .has-invalid{
            color: red;
            border-color: red;
        }
    </style>
</head>
<body>
<div class="container-xxl">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('products.index') }}" class="btn btn-primary" style="margin-top: 20px; float: right;">Back</a>
        </div>
        <div class="col-md-12">
            <div class="card" style="margin-top: 20px;">
                <div class="card-header">
                    Add Product
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-3">
                                <label>Name</label>
                                <input type="text" class="form-control @error('name') has-invalid @enderror" value="{{ $product->name }}" name="name">
                                @error('name') <span style="color: red;" >{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3">
                                <label>Sku</label>
                                <input type="text" class="form-control @error('sku') has-invalid @enderror" name="sku" value="{{ $product->sku }}">
                                @error('sku') <span style="color: red;" >{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3" >
                                <label>Price</label>
                                <input type="number" class="form-control @error('price') has-invalid @enderror" name="price" value="{{ $product->price }}">
                                @error('price') <span style="color: red;" >{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3" >
                                <label>Quantity</label>
                                <input type="number" class="form-control @error('quantity') has-invalid @enderror" name="quantity" value="{{ $product->qty }}">
                                @error('quantity') <span style="color: red;" >{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 20px;">
                                <label>Description</label>
                                <textarea class="form-control @error('description') has-invalid @enderror" name="description">{{ $product->description }}</textarea>
                                @error('description') <span style="color: red;" >{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4" style="margin-top: 20px;">
                                <label>Image</label>
                                <input name="image" class="form-control" accept="image/*" type='file'  id="imgInp" />
                                <br>
                                @error('image') <span style="color: red;" >{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <br>
                                <br>
                                <img id="blah" src="{{ asset($product->image) }}" alt="your image"  style="width: 200px;"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" style="margin-top: 20px;">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
</body>
@jquery
@toastr_js
@toastr_render
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
</script>
</html>
