@extends('auth.provider_layouts')

@section('content')

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Provider Register</div>
                    <div class="card-body">
                        <form action="{{ route('provider.homeStore') }}" method="post">
                            @csrf
                            <input type="hidden" name="franchise_id" id="franchise_id" value="0">
                            <input type="hidden" name="role_id" id="role_id" value="2">
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Provider Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required="">
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">First Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" required="">
                                    @if($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Last Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" required="">
                                    @if($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Location</label>
                                <div class="col-md-6">
                                    <select class="form-select" aria-label="Default select example" name="location_id">
                                     <?php foreach($locations as $location){ ?>
                                      <option value="<?php echo $location->id;?>"><?php echo $location->name;?></option>
                                     <?php } ?>
                                    </select>
                                </div>
                            </div>                            
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                                <div class="col-md-6">
                                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required="">
                                    @if($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                                <div class="col-md-6">
                                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required="">
                                    @if($errors->has('password'))
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

@endsection