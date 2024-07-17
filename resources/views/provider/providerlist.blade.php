@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            
            <div class="mb-3 row">
                <a href="{{ route('provider.register') }}" class="col-md-3 offset-md-5 btn btn-primary">Add Provider</a>
            </div>
            <div class="card-header">Providers List</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
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
                        <td><?php echo $provider->franchise_id; ?></td>
                        <td><?php echo $provider->name; ?></td>
                        <td><?php echo $provider->email; ?></td>
                        <td><a href="{{route('provider.edit', ['id' => $provider->id])}}">Edit</a></td>
                        <td><a href="{{route('provider.delete', ['id' => $provider->id])}}">Delete</a></td>
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