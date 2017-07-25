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

        <form action="{{ url('dashboard/shop/category/'.$product['id']) }}" method="post" class="form-horizontal style-form" style="margin-bottom: 10px;">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" name="id" value="{{$product['id']}}">
            <input type="hidden" value="{{$product['image']}}" name="image" id="def-img">
            <input type="hidden" value="" name="images" id="addedImages">


            <div class="panel panel-primary">
                <div class="panel-heading">
                    Product info
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label" for="title">Category</label>
                        <div class="col-md-6 col-sm-10">
                            <select name="category" class="form-control">
                                @foreach($cats as $cat)
                                
                                <option value="{{$cat['id']}}" @if ($cat['id'] == $product['categorie_id']) selected="selected" @endif>{{$cat['title']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 hidden-sm hidden-xs img-default">
                            <img id="main_image" class="thumbnail" src="{{asset('images/up/' .$product['image'])}}" alt="{{$product['title']}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label" for="title">Product Title</label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" class="form-control friendly-url" id="title" placeholder="Product Title" name="title" value="{{ old('title')? old('title') : $product['title'] }}">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label" for="url">Product URL</label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" class="form-control friendly-url-paste" id="url" placeholder="Product URL" name="url" value="{{ old('url')? old('url') : $product['url'] }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label" for="url">Full URL</label>
                        <label class="col-md-6 col-sm-10 control-label" style="text-align: left;">
                            <span class="friendly-url-full"></span>
                        </label>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label" for="article">Article</label>
                        <div class="col-md-6 col-sm-10">
                            <textarea id="article" name="article" class="summernote">{{ old('article')?old('article') : $product['article'] }}</textarea>
                        </div>
                    </div>


                </div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    Product images
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="article">Images</label>
                        <div class="col-md-10">
                            <div class="dropzone" id="my-awesome-dropzone">
                                <div id="myDropzone"></div>
                            </div >
                        </div >
                    </div >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Uploaded Images to serve
                            <div class="btn-group btn-group-xs pull-right" role="group">
                                <a class="btn btn-default show-images-btn">
                                    <span class="fa fa-plus-circle" data-toggle="tooltip" data-placement="top" title="Show"></span>
                                </a>
                            </div>
                        </div>
                        <div class="panel-body hidden show-images">
                            <div class="uploaded-img">
                                @foreach($uploaded_images as $img)
                                <div class="col-md-3">
                                    <img class="img-rounded add-to-images" src="{{url("images/up/$img")}}" alt="{{$img}}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="panel panel-primary">
                <div class="panel-heading">
                    Sales details
                </div>
                <div class="panel-body">
                <div class="col-md-3 col-sm-6">
                    <label for="stock">Stock</label>
                    <input type="text" value="{{$product['stock']}}" name="stock" id="stock" class="form-control">
                </div>
                <div class="col-md-3 col-sm-6">
                    <label for="price">Price (In $)</label>
                    <input type="text" value="{{$product['price']}}" name="price" id="price" class="form-control calc-price">
                </div>
                <div class="col-md-3 col-sm-6">
                    <label for="sale">Discount (In %)</label>
                    <input type="text" value="{{$product['sale']}}" name="sale" id="sale" class="form-control calc-sale">
                </div>
                <div class="col-md-3 col-sm-6">
                    <div><label>Total Price</label></div>
                    <div class=" calc-total label label-primary control-label" style="text-align: left; font-size: 14px;display: block; padding: 9px;">
                        
                    </div>
                </div>
                    
                </div>
            </div>
            
            <a class="btn btn-danger pull-left edit-page-btn" href="{{url('dashboard/shop/product')}}">Cancel</a>
            <input class="btn btn-primary pull-right" type="submit" value="Save change">

            <div class="clearfix"></div>
        </form>

        <script>
            var existingFiles = {!!$images_json!!};
            var def_img = '{{$product['image']}}';
        </script>
        @endsection