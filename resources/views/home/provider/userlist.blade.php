@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            
            <div class="mb-3 row">
                <a href="{{ route('homeProviderUser.register') }}" class="col-md-3 offset-md-5 btn btn-primary">Add User</a>
            </div>
            <div class="card-header">Users List</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">first name</th>
                        <th scope="col">last name</th>
                        <th scope="col">email</th>
                        <th scope="col">action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i=1;
                            foreach($users as $user){
                        ?>                        
                      <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td><?php echo $user->first_name; ?></td>
                        <td><?php echo $user->last_name; ?></td>
                        <td><?php echo $user->useremail; ?></td>
                        <td><a href="{{route('homeProiverUser.edit', ['id' => $user->id])}}">Edit</a></td>
                        <td><a href="{{route('homeProiverUser.delete', ['id' => $user->id])}}">Delete</a></td>
                        <!--<td><a href="{{route('user.delete', ['id' => $user->id])}}">Delete</a></td>-->
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