@extends('auth.layouts')

@section('content')

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Location Update</div>
                    <div class="card-body">
                        <form action="{{route('provider.locationUpdate',['id' => $locations->id])}}" method="post">
                            @csrf
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="<?php if(!empty($locations->name)) { echo $locations->name; } ?>" required="">
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div> 
                            <div class="mb-3 row">
                                <label for="address" class="col-md-4 col-form-label text-md-end text-start">Address</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="<?php if(!empty($locations->address)) { echo $locations->address; } ?>" required="">
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="city" class="col-md-4 col-form-label text-md-end text-start">City</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="<?php if(!empty($locations->city)) { echo $locations->city; } ?>" required="">
                                    @if ($errors->has('city'))
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="state" class="col-md-4 col-form-label text-md-end text-start">State</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="<?php if(!empty($locations->state)) { echo $locations->state; } ?>" required="">
                                    @if ($errors->has('state'))
                                        <span class="text-danger">{{ $errors->first('state') }}</span>
                                    @endif
                                </div>
                            </div> 
                            <div class="mb-3 row">
                                <label for="country" class="col-md-4 col-form-label text-md-end text-start">Country</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="<?php if(!empty($locations->country)) { echo $locations->country; } ?>" required="">
                                    @if ($errors->has('country'))
                                        <span class="text-danger">{{ $errors->first('country') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="postal_code" class="col-md-4 col-form-label text-md-end text-start">Postal Code</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" value="<?php if(!empty($locations->postal_code)) { echo $locations->postal_code; } ?>" required="">
                                    @if ($errors->has('postal_code'))
                                        <span class="text-danger">{{ $errors->first('postal_code') }}</span>
                                    @endif
                                </div>
                            </div>              
                            <div class="mb-3 row">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update">
                            </div>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
@endsection