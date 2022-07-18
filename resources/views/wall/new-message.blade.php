@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Новое сообщение</div>
                <div class="card-body">
                    <form action="{{ route('message.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" id="text" name="text" rows="3" placeholder="Введите сообщение..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-success">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection