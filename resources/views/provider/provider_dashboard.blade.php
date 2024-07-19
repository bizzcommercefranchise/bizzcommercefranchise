@extends('auth.layouts')

@section('content')
<?php if(session()->get('username') !=""){ ?>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> <?php if(session()->get('role_id') == 1) { echo "User"; } elseif(session()->get('role_id') == 3) {
                                echo "Admin"; } elseif(session()->get('role_id') == 2) { echo "Provider"; } ?> Dashboard </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                {{ $message }}
                            </div>
                        @elseif(session()->get('role_id') == 2)
                            <div>
                                   <div class="container">
                                        <div class="row">
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
                                                        foreach($providerProducts as $product){
                                                    ?>                        
                                                      <tr>
                                                        <th scope="row"><?php echo $i; ?></th>
                                                        <td><?php echo $product->name; ?></td>
                                                        <td><?php echo $product->cost; ?></td>
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
                        @elseif(session()->get('role_id') == 3)
                        <!--<a href=""> <?php //echo  'admin'. '.'.url(''); ?></a>-->
                        <a href="{{ route('franchisesList') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Franchises</a>
                        <a href="{{ route('usersList') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Users</a>
                        @else
                            <div class="alert alert-success">
                                You are logged in!
                            </div>       
                        @endif                
                    </div>
                </div>
            </div>    
        </div>
<?php } ?>        
@endsection