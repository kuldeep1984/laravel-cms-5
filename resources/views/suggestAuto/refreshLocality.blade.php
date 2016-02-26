@extends('ajax')

@section('content')

        <select name = 'locality' id = 'locality' onchange = 'localitySelect(this.value);'>
            <option value=''>Select locality</option>
          
            @if($alllocalities)
            @foreach ($alllocalities as $locality_id => $locality_name)
                <option value="{{$locality_id}}">{{$locality_name}}</option>
            @endforeach
            @endif
            
        </select>
@endsection

