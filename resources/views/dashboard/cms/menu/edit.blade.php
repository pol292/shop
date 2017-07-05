@extends('layout.dashboard')
@section('content')

<div class="row cf nestable-lists">

    <div class="dd col-md-6" id="nestable">
        <h2>Current Menu</h2>
        <ol class="dd-list @if(empty($menu)) dd-empty @endif">
            @foreach($menu as $item)
            <li class="dd-item" data-id="{{$item['id']}}" data-page-id="{{$item['pages']['id']}}">
                <div class="dd-handle">{{$item['pages']['title']}}</div>
                @if(!empty($item['sub_menu']))
                <ol class="dd-list">
                @foreach($item['sub_menu'] as $sub_page)
                    <li class="dd-item" data-id="{{$sub_page['id']}}" data-page-id="{{$sub_page['pages']['id']}}">
                        <div class="dd-handle">{{$sub_page['pages']['title']}}</div>
                    </li>
                @endforeach
                </ol>
                @endif
            </li>
            @endforeach
        </ol>
    </div>

    <div class="dd col-md-6" id="nestable2">
        <h2>Pages list</h2>
        <ol class="dd-list">
            @if(empty($pages))
            <li class="list-group-item list-group-item-warning">
                No Pages
            </li>

            @else
            <input type="text" class="search-page form-control" placeholder="Search page...">
            @foreach($pages as $p)
            <li class="dd-item" data-id='' data-page-id="{{$p['id']}}">
                <div class="dd-handle">{{$p['title']}}</div>
            </li>
            @endforeach
            @endif
        </ol>
    </div>

</div>
@endsection