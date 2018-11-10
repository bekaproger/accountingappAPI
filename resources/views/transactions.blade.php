@extends('layouts.app')

@section('content')
    <div class = "container">
        <div class="row">
            <div class="justify-content-center">
                @foreach($transactions as $tr)
                <div class="col-md-8">
                    <h6>{{$tr->title}}  <strong>{{$tr->amount}}</strong></h6>
                </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection