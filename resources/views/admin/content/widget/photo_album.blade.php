<div class="form-group-inner">
    <div class="col-lg-3"></div>
    <div class="col-lg-7">
        {{-- ----------------------------------- imageuploader -------------------------------- --}}
        {{-- *************************************************************************************--}}

        {{-- Js Script --}}
        <link rel="stylesheet" href="{{ asset('admin/css/Lobibox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/notifications.css') }}">
        <script src="{{ asset('admin/js/Lobibox.js') }}"></script>
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <br>
        <div class="input-field">
            <label class="active">Photos</label>
            <div id="dropimg" class="input-images-2" style="padding-top: .5rem;padding-bottom: .5rem;"></div>
        </div>

        <input type="hidden" name="fileRemove[]" class="form-control">

        {{-- ********************************************************--}}
        {{--------------------- End imageuploader ---------------------}}
    </div>
</div>

@if ($json_dataimg == '')

    @push('scripts')
    <script src="{{ asset('admin/js/image_uploader_ws_post.js') }}"></script>
    @endpush

@else

    @push('scripts')
    {{--------------------------- Script Image uploader ----------------------------}}
    <script src="{{ asset('admin/js/image_uploader_ws_edit_post.js') }}">
    </script>
    {{------------------------- End Script Image uploader --------------------------}}
    <script>
        let preloaded = [];
        var json_dataimg = '<?php echo $json_dataimg?>';

        $.each($.parseJSON(json_dataimg),function(){

            xx = { id:this.No+'_'+this.seq , src:'{{ URL::to("/")}}/mediafiles/pic_activity/'+this.path_img }
            preloaded.push(xx);

        });

        $(document).ready(function(e){

            $('.input-images-2').imageUploader({
                preloaded: preloaded,
                imagesInputName: 'photos',
                preloadedInputName: 'old'
            });
        });
    </script>
    {{------------------------------- End Fetch Data ------------------------------------}}
    @endpush

@endif
