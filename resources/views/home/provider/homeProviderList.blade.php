@extends('auth.provider_layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            
            <div class="mb-3 row">
                <a href="{{ route('provider.homeRegister') }}" class="col-md-3 offset-md-5 btn btn-primary">Add Provider</a>
            </div>
            <div class="card-header">Providers List</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">provider</th>
                        <th scope="col">franchise</th>
                        <th scope="col">name</th>
                        <th scope="col">email</th>
                        <th scope="col">action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i=1;
                            foreach($providers as $provider){
                        ?>                        
                      <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td><?php echo $provider->name; ?></td>
                       
                        <td> <?php foreach($franchises as $franchise) { 
                                    if($franchise->id == $provider->franchise_id){
                                        echo  $franchise = $franchise->name;
                                      } else {
                                          $franchise = null;
                                      } 
                                    } ?></td>
                        
                        <td><?php echo $provider->name; ?></td>
                        <td><?php echo $provider->email; ?></td>
                        <td><a href="{{route('provider.homeEdit', ['id' => $provider->id])}}">Edit</a></td>
                        <td><a href="{{route('provider.homeDelete', ['id' => $provider->id])}}">Delete</a></td>
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