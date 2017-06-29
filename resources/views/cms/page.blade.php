@extends('layout.main')
@section('content')
    @if($contents)
        @foreach($contents as $content)
            <{{$content['tag']}}>{{$content['title']}}</{{$content['tag']}}>
            <p>{!! $content['article'] !!}</p>
        @endforeach
    @else
        <p>page not found</p>
    @endif
    @if(!empty($back))
    <div class="preview" style="">
        <h2><small>This is preview mode</small></h2>
        <a href="{{$back}}" class="btn btn-primary">Back to dashboard</a>
    </div>
    @endif
@endsection