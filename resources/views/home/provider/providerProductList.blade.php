@extends('home.enduser.user_layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="mb-3 row">
                <a href="{{ route('provider.homeProductAdd') }}" class="col-md-3 offset-md-5 btn btn-primary">Add Product</a>
            </div>
            <div class="card-header">Products List</div>
            
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">cost</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i=1;
                            foreach($products as $product){
                        ?>                        
                      <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td><?php echo $product->name; ?></td>
                        <td><?php echo $product->cost; ?></td>
                        <td><a href="{{route('provider.homeProductEdit', ['id' => $product->id])}}">Edit </a>
                            <br>
                            <a href="{{route('provider.homeProductDelete', ['id' => $product->id])}}">Delete</a></td>                        
                      </tr>
                        <?php
                                $i++;
                            }
                        ?>                      
                    </tbody>
                 </table>                    
            </div>
        </div>
    </div>    
</div>

@endsection