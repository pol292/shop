                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             @extends('layout.dashboard')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Edit Product
        <div class="btn-group btn-group-xs pull-right" role="group">
            <button class="btn btn-danger" data-toggle="modal" data-target="#delete" data-redirect="true" data-route="{{'dashboard/shop/category/' . $product['id'] }}" data-msg="Did you want to delete ({{$product['title']}}) category" ><span class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></span></button>
        </div>
    </div>
    <div class="panel-body">
        <div id="stepBar">

            <h3>Bootstrap Wizard</h3>

            <hr>

            <form action="{{ url('dashboard/shop/category/'.$product['id']) }}" method="post" style="margin-bottom: 10px;">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <input type="hidden" value="{{$product['image']}}" name="image" id="def-img">
                <input type="hidden" value="" name="addedImages" id="addedImages">
                <input type="hidden" value="" name="removedImages" id="removedImages">
                
                <div class="navbar">
                    <div class="navbar-inner">
                        <ul class="nav nav-pills">
                            <li class="active"><a href="#step1" data-toggle="tab" data-step="1">Edit View</a></li>
                            <li><a href="#step2" data-toggle="tab" data-step="2">Edit Images</a></li>
                            <li><a href="#step3" data-toggle="tab" data-step="3">Step 3</a></li>
                            <li><a href="#step4" data-toggle="tab" data-step="4">Step 4</a></li>
                            <li><a href="#step5" data-toggle="tab" data-step="5">Step 5</a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">

                    <div class="tab-pane fade" id="step1">

                        <div class="well"> 

                            <input type="hidden" name="id" value="{{$product['id']}}">

                            <div class="form-group">
                                <label for="title">Category Title:</label>
                                <input type="text" class="form-control friendly-url" id="title" placeholder="Category Title" name="title" value="{{ old('title')? old('title') : $product['title'] }}">
                            </div>
                            <div class="form-group">
                                <label for="url">Category URL:</label>
                                <input type="text" class="form-control friendly-url-paste" id="url" placeholder="Category URL" name="url" value="{{ old('url')? old('url') : $product['url'] }}">
                            </div>


                            <div class="form-group">
                                <label for="article">Article:</label>
                                <textarea id="article" name="article" class="summernote">{{ old('article')?old('article') : $product['article'] }}</textarea>
                            </div>

                        </div>
                        <a class="btn btn-danger pull-left edit-page-btn" href="{{url('dashboard/shop/category')}}">Cancel</a>
                        <input class="btn btn-primary pull-right" type="submit" value="Save change">
                    </div>


                    <div class="tab-pane fade in active" id="step2">
                        <div class="well"> 
                            <div class="dropzone" id="my-awesome-dropzone">
                                <div id="myDropzone"></div>
                            </div >

                        </div>
                        <a class="btn btn-default btn-lg next pull-right" href="#">Continue</a>

                    </div>
                    <div class="tab-pane fade" id="step3">
                        <div class="well"> <h2>Step 3</h2> Add another step here..</div>
                        <a class="btn btn-default btn-lg next pull-right" href="#">Continue</a>
                    </div>
                    <div class="tab-pane fade" id="step4">
                        <div class="well"> <h2>Step 4</h2> Add another almost done step here..</div>
                        <a class="btn btn-default btn-lg next pull-right" href="#">Continue</a>
                    </div>
                    <div class="tab-pane fade" id="step5">
                        <div class="well"> <h2>Step 5</h2> You're Done!</div>
                        <a class="btn btn-success first" href="#">Start over</a>
                    </div>
                </div>
        </div>

        <!--            <a class="btn btn-danger pull-left edit-page-btn" href="{{url('dashboard/shop/category')}}">Cancel</a>
                    <input class="btn btn-primary pull-right" type="submit" value="Save change">-->
        <div class="clearfix"></div>
        </form>

    </div>
</div>
<script>
    var existingFiles = {!!$images_json!!};
            var def_img = '{{ $product['image'] }}';
</script>
@endsection