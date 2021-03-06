                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             @extends('layout.dashboard')
@section('content')

<table class="table">
    <tr>
        <th class="text-center">Active</th>
        <th>Title</th>
        <th>URL</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    <tr>
        <td class="text-center"><span class="fa fa-{{ $page_content['active']? 'check text-success' : 'times text-danger' }}"</td>
        <td>{{$page_content['title']}}</td>
        <td>{{$page_content['url']}}</td>
        <td>{{$page_content['created_at']}}</td>
        <td>{{$page_content['updated_at']}}</td>
    </tr>
</table>

<div class="panel panel-primary">
    <div class="panel-heading">Edit content</div>
    <div class="panel-body">
        <div class="dd-item dd3-item">
            <div class="dd3-content">
                {{$page_content['title']}} <small class="header">( <span>Header 1</span> )</small>
                <div class="btn-group btn-group-xs pull-right" role="group">
                    <a href="{{url('dashboard/CMS/page/'.$page_content['url'])}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>
                    <a href="#" class="btn btn-xs edit-content btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><span class="fa fa-edit"></span></a>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#delete" data-redirect="true" data-route="{{'dashboard/CMS/page/' . $page_content['id'] }}" data-msg="Did you want to delete ({{$page_content['title']}}) page" ><span class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></span></button>
                </div>
            </div>
            <form class="page-article" action="{{ url('dashboard/CMS/page/'.$page_content['id']) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}


                <input type="hidden" name="id" value="{{$page_content['id']}}">
                <input type="hidden" name="edited" value="true">

                <div class="form-group">
                    <label for="title">Page Title:</label>
                    <input type="text" name="title" id="title" class="form-control friendly-url" value="{{ old('title')?old('title') : $page_content['title']  }}">
                </div>
                <div class="form-group">
                    <label for="url">Page Url:</label>
                    <input type="text" name="url" id="url" class="form-control friendly-url-paste" value="{{ old('url')?old('url') : $page_content['url']}}">
                </div>
                <div class="form-group">
                    <label for="article">Article:</label>
                    <textarea id="article" name="article" class="summernote">{{ old('article')?old('article') : $page_content['article'] }}</textarea>
                </div>
                <div class="checkbox">
                    <strong>Page activation:</strong>
                    <label>
                        <input type="checkbox" name="active" @if(old('active') || $page_content['active'] ) checked="checked" @endif>
                               Active
                    </label>
                </div>

                <input type="button" class="btn btn-danger pull-left edit-page-btn" value="Cancel">
                <input class="btn btn-primary pull-right" type="submit" value="Save change">
                <div class="clearfix"></div>
            </form>
            <div id="drag_content" style="padding-left: 30px; " class="dd"></div>

        </div>
        <hr>
        <form action="{{ url('dashboard/CMS/content/add') }}" method="post">
            <h2 class="text-center"><small>Add new content</small></h2>
            {{ csrf_field() }}
 
            <input type="hidden" name="id" value="{{$page_content['id']}}">

            <div class="form-group">
                <label for="content-title">Page Title:</label>
                <input type="text" name="content-title" id="content-title" class="form-control" value="{{ old('content-title')}}">
            </div>
            <div class="form-group">
                <label for="content-article">Article:</label>
                <textarea id="new-content-article" name="content-article" class="summernote">{{ old('content-article') }}</textarea>
            </div>

            <a href="{{url('dashboard/CMS/page')}}" class="btn btn-default pull-left">Back</a>
            <input class="btn btn-primary pull-right" type="submit" value="Save change">
            <div class="clearfix"></div>
        </form>

    </div>
</div>



<script>
    var page_data = [];
            page_data[0] = {!! $page_json !!}
    ;
</script>
@endsection