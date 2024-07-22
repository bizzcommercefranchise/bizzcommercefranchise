@extends('auth.provider_layouts')

@section('content')

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Product</div>
                    <div class="card-body">
                        <form action="{{ route('provider.homeProductStore') }}" method="post">
                            @csrf                           
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required="">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Category</label>
                                <div class="col-md-6">
                                    <select class="form-select" aria-label="Default select example" name="category_id" id="category_id">
                                     <?php foreach($productcategories as $productcategory){ ?>
                                      <option value="<?php echo $productcategory->id;?>"><?php echo $productcategory->name;?></option>
                                     <?php } ?>
                                    </select>
                                </div>
                            </div>                            
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Cost</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('cost') is-invalid @enderror" id="cost" name="cost" value="{{ old('cost') }}" required="">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('cost') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add">
                            </div>
                        </form>
                    </div>
                </div>
            </div>    
        </div>

@endsection