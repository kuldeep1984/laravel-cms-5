@extends('ajax')

@section('content')

            @if($values)
            @foreach ($values as $id => $value)
                <option value="{{$id}}">{{$value}}</option>
            @endforeach
            @endif
            
@endsection

