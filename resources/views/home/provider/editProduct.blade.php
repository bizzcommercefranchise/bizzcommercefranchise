<?php //print_r($productshow); exit; ?>
@extends('auth.layouts')

@section('content')

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Product Update</div>
                    <div class="card-body">
                        <form action="{{route('provider.homeProductUpdate',['id' => $productshow->id])}}" method="post">
                            @csrf
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('provider_name') is-invalid @enderror" id="name" name="name" value="<?php if(!empty($productshow->name)) { echo $productshow->name; } ?>" required="">
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div> 
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Cost</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('cost') is-invalid @enderror" id="cost" name="cost" value="<?php if(!empty($productshow->cost)) { echo $productshow->cost; } ?>" required="">
                                    @if ($errors->has('cost'))
                                        <span class="text-danger">{{ $errors->first('cost') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <?php //print_r($productCategoryShow); exit; ?>
                                <label for="location_id" class="col-md-4 col-form-label text-md-end text-start">Category</label>
                                <div class="col-md-6">
                                    <select class="form-select" aria-label="Default select example" name="category_id" id="category_id">
                                        <?php 
                                        $category = $productshow->product_category_id;
                                        foreach($productCategoryShow as $val){
                                            ?>
                                         <option value="<?php echo $val->id; ?>" <?php if($val->id == $category){ echo 'selected'; }  ?> ><?php echo $val->name;?></option>
                                        <?php } ?>
                                    </select>
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