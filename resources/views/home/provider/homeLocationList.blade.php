@extends('auth.provider_layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            
            <div class="mb-3 row">
                <a href="{{ route('provider.locationRegister') }}" class="col-md-3 offset-md-5 btn btn-primary">Add Location</a>
            </div>
            <div class="card-header">Locations List</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">address</th>
                        <th scope="col">city</th>
                        <th scope="col">state</th>
                        <th scope="col">action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i=1;
                            foreach($locations as $location){
                        ?>                        
                      <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td><?php echo $location->name; ?></td>
                       
                        <td> <?php echo $location->address; ?></td>
                        
                        <td><?php echo $location->city; ?></td>
                        <td><?php echo $location->state; ?></td>
                        <td><a href="{{route('provider.locationEdit', ['id' => $location->id])}}">Edit</a></td>
                        <td><a href="{{route('provider.locationDelete', ['id' => $location->id])}}">Delete</a></td>
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