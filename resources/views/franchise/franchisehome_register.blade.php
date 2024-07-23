@extends('auth.franchise_layouts')

@section('content')
<?php if(empty(session()->has('username'))) { ?>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Franchise Register</div>
                    <div class="card-body">
                        <form action="{{ route('franchisehome.store') }}" method="post">
                            <input type="hidden" name="role_id" id="role_id" value="4">
                            @csrf
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Franchise Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('franchise_name') is-invalid @enderror" id="franchise_name" name="franchise_name" value="{{ old('franchise_name') }}" required="">
                                    @if ($errors->has('franchise_name'))
                                        <span class="text-danger">{{ $errors->first('franchise_name') }}</span>
                                    @endif
                                </div>
                            </div>                            
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">First Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required="">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Last Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" required="">
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Domain</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('domain_name') is-invalid @enderror" id="domain_name" name="domain_name" value="{{ old('domain_name') }}" required="">
                                    @if ($errors->has('domain_name'))
                                        <span class="text-danger">{{ $errors->first('domain_name') }}</span>
                                    @endif
                                </div>
                            </div>                          
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                                <div class="col-md-6">
                                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required="">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                                <div class="col-md-6">
                                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required="">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                                <div class="col-md-6">
                                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required="">
                                </div>
                            </div>                  
                            <div class="mb-3 row">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Register">
                            </div>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
 <?php } else { ?>
    <script>window.location = "/franchise/dashboard";</script>
<?php } ?>
@endsection