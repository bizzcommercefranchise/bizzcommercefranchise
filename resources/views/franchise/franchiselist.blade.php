@extends('auth.layouts')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">

                <div class="mb-3 row">
                    <a href="{{ route('franchise.register') }}" class="col-md-3 offset-md-5 btn btn-primary">Add Franchise</a>
                </div>
                <div class="card-header">Franchises</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">name</th>
                                <th scope="col">domain</th>
                                <th scope="col">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
                            foreach($franchises as $franchise){
                        ?>
                            <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td><?php echo $franchise->name; ?></td>
                                <td><?php echo $franchise->domain; ?></td>
                                <td><a href="{{ route('franchise.edit', ['id' => $franchise->id]) }}">Edit</a></td>
                                <td><a href="{{ route('franchise.delete', ['id' => $franchise->id]) }}">Delete</a></td>
                            </tr>
                            <?php
                                $i++;
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
