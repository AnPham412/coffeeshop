@extends('layouts.admin')
@section('content')
<div class="main-content">
                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Category infomation</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="{{route('admin.index')}}">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.categories')}}">
                                                <div class="text-tiny">Categories</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">New category</div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- new-category -->
                                <div class="wg-box">
                                    <form class="form-new-product form-style-1" action="{{route('admin.category.store')}}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <fieldset class="name">
                                            <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" placeholder="Category name" name="name"
                                                tabindex="0" value="{{old('name')}}" aria-required="true" required="">
                                        </fieldset>
                                        
                                        <fieldset>
                                            <div class="body-title">Upload images <span class="tf-color-1">*</span>
                                            </div>
                                            <div class="upload-image flex-grow">
                                                <div class="item" id="imgpreview">
                                                <div id="upload-file" class="item up-load">
                                                    <label class="uploadfile" for="myFile">
                                                    <img src="" class="effect8" alt="" style="display:none">
                                                        <span class="body-text">Drop your images here or select <span
                                                                class="tf-color">click to browse</span></span>
                                                        <input type="file" id="myFile" name="image" accept="image/*">
                                                    </label>
                                                </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        @error('image') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                                        <div class="bot">
                                            <div></div>
                                            <button class="tf-button w208" type="submit">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2024 </div>
                        </div>
                    </div>
@endsection
@push('scripts')
    <script>
        $(function(){
            $("#myFile").on("change",function(e){
                const photo=$("#myFile");
                const [file]=this.files;
                if (file) {
                    $("#imgpreview img").attr('src',URL.createObjectURL(file));
                    $("#imgpreview img").show();
                }
            });
            $("input[name='name']").on("change",function(){
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });
        });
        function StringToSlug(Text) {
    return Text.toLowerCase()
        .replace(/[^\w]+/g, "")  
        .replace(/ +/g, "-");    
}
    </script>
@endpush