@extends('ajax')

@section('content')

            @if($values)
            <option value="">Project Type</option>
            @foreach ($values as $id => $value)
                <option value="{{$id}}">{{$value}}</option>
            @endforeach
            @endif
            
@endsection

