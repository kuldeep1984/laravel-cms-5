@extends('ajax')

@section('content')

            @if($suburb)
            @foreach ($suburb as $suburb_id => $suburb_name)
                <option value="{{$suburb_id}}">{{$suburb_name}}</option>
            @endforeach
            @endif
            
@endsection

