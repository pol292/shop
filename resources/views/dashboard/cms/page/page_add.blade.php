@extends('layout.dashboard')
@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        Add Page
    </div>
    <div class="panel-body">
        <form action="{{ url('dashboard/CMS/page') }}" method="post">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="title">Page Title:</label>
                <input type="text" name="title" id="title" class="form-control friendly-url" value="{{ old('title') }}">
            </div>
            <div class="form-group">
                <label for="url">Page Url:</label>
                <input type="text" name="url" id="url" class="form-control friendly-url-paste" value="{{ old('url')}}">
            </div>
            <div class="form-group">
                <label for="article">Article:</label>
                <textarea id="article" name="article" class="summernote">{{ old('article') }}</textarea>
            </div>
            <div class="checkbox">
                <strong>Page activation:</strong>
                <label>
                    <input type="checkbox" name="active" @if(old('active')) checked="checked" @endif>
                           Active
                </label>
            </div>

            <button class="btn btn-danger pull-left edit-page-btn">Cancel</button>
            <input class="btn btn-primary pull-right" type="submit" value="Save change">
            <div class="clearfix"></div>
        </form>
    </div>
</div>

@endsection