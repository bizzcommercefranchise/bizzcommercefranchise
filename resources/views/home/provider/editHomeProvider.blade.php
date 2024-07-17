@extends('auth.layouts')

@section('content')

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Provider Update</div>
                    <div class="card-body">
                        <form action="{{route('provider.homeUpdate',['id' => $providershow->id])}}" method="post">
                            @csrf
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('provider_name') is-invalid @enderror" id="provider_name" name="provider_name" value="<?php if(!empty($providershow->name)) { echo $providershow->name; } ?>" required="">
                                    @if($errors->has('provider_name'))
                                        <span class="text-danger">{{ $errors->first('provider_name') }}</span>
                                    @endif
                                </div>
                            </div> 
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">First name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="<?php if(!empty($providershow->first_name)) { echo $providershow->first_name; } ?>" required="">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div> 
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Last Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="<?php if(!empty($providershow->last_name)) { echo $providershow->last_name; } ?>" required="">
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <?php // print_r($providershow); exit; ?>
                                <label for="location_id" class="col-md-4 col-form-label text-md-end text-start">Location</label>
                                <div class="col-md-6">
                                    <select class="form-select" aria-label="Default select example" name="location_id" id="location_id">
                                        <?php 
                                        $location = $providershow->location_id;
                                        foreach($locations as $val){
                                            ?>
                                         <option value="<?php echo $val->id; ?>" <?php if($val->id == $location){ echo 'selected'; }  ?> ><?php echo $val->name;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>                         
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                                <div class="col-md-6">
                                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="<?php if(!empty($providershow->email)) { echo $providershow->email; } ?>" required="">
                                    @if($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <!--<div class="mb-3 row">
                                <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="<?php if(!empty($providershow->password)) { echo $providershow->password; } ?>" disabled="">
                                    @if($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
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