@extends('auth.layouts')

@section('content')
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Franchise Edit</div>
                    <div class="card-body">                       
                        <form action="{{route('franchise.update',['id' => $franchiseshow->id])}}" method="post">
                            <input type="hidden" name="role_id" id="role_id" value="4">
                            @csrf
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Franchise Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('franchise_name') is-invalid @enderror" id="franchise_name" name="franchise_name" value="<?php if(!empty($franchiseshow->name)) { echo $franchiseshow->name; } ?>" required="">
                                    @if ($errors->has('franchise_name'))
                                        <span class="text-danger">{{ $errors->first('franchise_name') }}</span>
                                    @endif
                                </div>
                            </div>                            
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="<?php if(!empty($franchiseshow->first_name)) { echo $franchiseshow->first_name; } ?>" required="">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Last Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="<?php if(!empty($franchiseshow->last_name)) { echo $franchiseshow->last_name; } ?>" required="">
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>                  
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Domain</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('domain_name') is-invalid @enderror" id="domain_name" name="domain_name" value="<?php if(!empty($franchiseshow->domain)) { echo $franchiseshow->domain; } ?>" required="">
                                    @if ($errors->has('domain_name'))
                                        <span class="text-danger">{{ $errors->first('domain_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                                <div class="col-md-6">
                                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="<?php if(!empty($franchiseshow->username)) { echo $franchiseshow->username; } ?>" required="">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <!--<div class="mb-3 row">
                                <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                                <div class="col-md-6">
                                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="<?php if(!empty($franchiseshow->password)) { echo $franchiseshow->password; } ?>">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                                <div class="col-md-6">
                                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>-->                          
                            <div class="mb-3 row">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update">
                            </div>
                        </form>
                    </div>
                </div>
            </div>    
        </div>

@endsection
