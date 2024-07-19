@extends('admin.admin_dashboard')
@section('admin')
<html>
    <head>
<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"></script>    
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">-->
    </head>
    <body>
        <div class="container">
            <div class="row">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">price</th>
                        <th scope="col">description</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
    $i=1;
    foreach($products as $product){
?>                        
                      <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td><?php echo $product->name; ?></td>
                        <td><?php echo $product->price; ?></td>
                        <td><?php echo $product->description; ?></td>
                      </tr>
<?php
        $i++;
    }
?>                      
                    </tbody>
                 </table>                
            </div>
        </div>
    </body>
</html>
@endsection
