<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"></script>    
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
<!--                    {{ __("You're logged in!") }}-->
                    <nav class="sidebar">
                        <div class="sidebar-body">
                            <ul class="nav">
                              <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#forms" role="button" aria-expanded="false" aria-controls="forms">
                                  <i class="link-icon" data-feather="inbox"></i>
                                  <span class="link-title">Welcome to Dashboard</span>
                                  <i class="link-arrow" data-feather="chevron-down"></i>
                                </a>
                              </li>
                            </ul>
                          </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
