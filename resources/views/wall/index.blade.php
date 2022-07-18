@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Стена</div>
                <div class="card-body">
                    @isset($messages)
                        @foreach($messages as $message)
                            @include('wall.message')
                        @endforeach
                            <div class="d-flex justify-content-center">
                                {{ $messages->links() }}
                            </div>
                    @endisset
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection