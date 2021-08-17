<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @toastr_css
</head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12" style="margin-top: 25px;">
                    <a href="{{ route('products.create') }}" class="btn btn-primary" style="float: right;">Add Product</a>
                    <button type="button" class="btn btn-danger delete_all">Delete</button>
                </div>
                <div class="card" style="margin-top: 20px;">
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Sku</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <th><input type="checkbox" class="sub_chk" data-id="{{$product->id}}"></th>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td><img src="{{ asset($product->image) }}" width="100" alt=""></td>
                                            <td style="display: flex;">
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Product">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                &nbsp;
                                                &nbsp;
                                                <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                    <button type="submit" class="btn btn-danger delete-product" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Product">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                                &nbsp;
                                                &nbsp;
                                                <a href="{{ route('add-images', $product->id) }}" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Products">
                                                    <i class="fas fa-images"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    $('.delete-product').click(function(e){
        e.preventDefault() // Don't post the form, unless confirmed
        if (confirm('Are you sure?')) {
            // Post the form
            $(e.target).closest('form').submit() // Post the surrounding form
        }
    });

    $('.delete_all').on('click', function(e) {
        var allVals = [];
        $(".sub_chk:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });
        if(allVals.length <=0)
        {
            alert("Please select row.");
        }  else {
            var check = confirm("Are you sure you want to delete this row?");
            if(check === true){
                var join_selected_values = allVals.join(",");
                $.ajax({
                    url: '{{ route('delete.multiple') }}',
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: 'ids='+join_selected_values,
                    success: function (data) {
                        if (data['success']) {
                            $(".sub_chk:checked").each(function() {
                                $(this).parents("tr").remove();
                            });
                            alert(data['success']);
                        } else if (data['error']) {
                            alert(data['error']);
                        } else {
                            alert('Whoops Something went wrong!!');
                        }
                    },
                    error: function (data) {
                        alert(data.responseText);
                    }
                });
                $.each(allVals, function( index, value ) {
                    $('table tr').filter("[data-row-id='" + value + "']").remove();
                });
            }
        }
    });
</script>
</html>
