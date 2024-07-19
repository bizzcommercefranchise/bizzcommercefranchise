@extends('auth.layouts')

@section('content')

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form action="{{ route('provider.store') }}" method="post">
                            @csrf
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Franchise</label>
                                <div class="col-md-6">
                                    <select class="form-select" aria-label="Default select example" name="franchise_id">
                                     <?php foreach($franchises as $franchise){ ?>
                                      <option value="<?php echo $franchise->id;?>"><?php echo $franchise->name;?></option>
                                     <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>                            
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                                <div class="col-md-6">
                                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
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