@extends('auth.layouts')

@section('content')
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update</div>
                    <div class="card-body">                       
                        <form action="{{route('user.update',['id' => $usershow->user_id]) }}" method="post">
                            @csrf
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Franchise </label>
                                <div class="col-md-6">
                                    <select class="form-select" aria-label="Default select example" name="provider_id">
                                        <?php 
                                        $provider = $usershow->primary_provider_id;
                                        foreach($providers as $providerval){
                                            ?>
                                         <option value="<?php echo $providerval->id; ?>" <?php if($providerval->id == $provider){ echo 'selected'; }  ?> ><?php echo $providerval->name;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>                            
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">First Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="<?php if(!empty($usershow->first_name)) { echo $usershow->first_name; } ?>">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Last Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="<?php if(!empty($usershow->last_name)) { echo $usershow->last_name; } ?>">
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>                            
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                                <div class="col-md-6">
                                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="<?php if(!empty($usershow->email)) { echo $usershow->email; } ?>">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div> 
                            <div class="mb-3 row">
                                <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                                <div class="col-md-6">
                                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="<?php if(!empty($usershow->password)) { echo $usershow->password; } ?>"  readonly="readonly">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="">
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
