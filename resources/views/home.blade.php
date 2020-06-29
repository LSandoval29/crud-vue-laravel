@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3 class="h3 mb-2 font-weight-bold display-5">Administrar Productos</h3></div>

                <div class="card-body">
                   <productos />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
