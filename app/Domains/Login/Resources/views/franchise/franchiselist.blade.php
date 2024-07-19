@extends('admin.admin_dashboard')
@section('admin')

        <div class="container">
            <div class="row">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">id</th>
                        <th scope="col">url</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
    $j=1;
    $i=0;
    foreach($urls as $url){
          $url = explode('/',$url);
          $company = $url[5];
?>                          
                      <tr>
                        <th scope="row"><?php echo $j; ?></th>
                        <td> 
                            <a href="{{ route('admin.franchiseById', $company) }}"
                            class="btn btn-primary btn-sm"><?php echo $urls[$i]; ?></a>
                        </td>
                      </tr> 
<?php
        $i++;
        $j++;
    }
?>                       
                    </tbody>
                 </table>                
            </div>
        </div>
@endsection