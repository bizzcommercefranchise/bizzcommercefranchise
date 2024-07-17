@extends('auth.layouts')

@section('content')
<?php if(session()->get('username') !=""){ ?>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> <?php if(session()->get('role_id') == 1) { echo "User"; } elseif(session()->get('role_id') == 3) {
                                echo "Admin"; } elseif(session()->get('role_id') == 2) { echo "Provider"; }elseif(session()->get('role_id') == 4) { echo "Franchise"; } ?> Dashboard </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                {{ $message }}
                            </div>
                        @elseif(session()->get('role_id') == 2)
                            <a href="{{ route('providerUsersList') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Users</a>                        
                        @elseif(session()->get('role_id') == 3)
                        <!--<a href=""> <?php //echo  'admin'. '.'.url(''); ?></a>-->
                        <a href="{{ route('franchisesList') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Franchises</a>
                        <br>          
                        <!--<a href="{{ route('providersList') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Providers</a>
                        <br>
                        <a href="{{ route('usersList') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Users</a>-->
                        @elseif(session()->get('role_id') == 4)
                        <a href="{{ route('homeProvidersList') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Providers</a>
                        <br> 
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