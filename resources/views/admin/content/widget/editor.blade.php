<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3">
            <label class="login2 pull-right pull-right-pro">
                รายละเอียด :
            </label>
        </div>
        <div class="col-lg-7">
            <div class="form-select-list">
                <textarea type="text" class="form-control" cols="80" id="QNote" name="QNote" rows="10">{!! $Note !!}</textarea>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- tinymce JS
                        ============================================ -->
    <script src="{{ asset('admin/js/tinymce/tinymce.min.js') }}"></script>
    {{-- <script src="{{ asset('admin/filemanager/plugin.min.js') }}"></script> --}}

    {{-- ----------------------- End Script Image uploader ------------------------ --}}

    <script type="text/javascript">
        var accKey = "<?php echo md5(Auth::guard('admin')->user()->password); ?>";

        // ของเก่าเป็น Responsive FileManager
        //   tinymce.init({
        //     selector: '#QNote',
        //     // skin: 'dark',
        //     // width: 600,
        //     height: 600,
        //     language: 'th_TH',
        //     plugins: [
        //       'advlist autolink link image imagetools lists codesample charmap print preview hr anchor pagebreak spellchecker',
        //       'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        //       'save table contextmenu directionality emoticons template responsivefilemanager textcolor importcss'
        //     ],
        //     // content_css: 'css/content.css',
        //     toolbar: 'insertfile undo redo | styleselect fontselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons | removeformat | responsivefilemanager |',

        //     images_upload_url: 'upload.php',

        //     // override default upload handler to simulate successful upload
        //     images_upload_handler: function (blobInfo, success, failure) {
        //         var xhr, formData;

        //         xhr = new XMLHttpRequest();
        //         xhr.withCredentials = false;
        //         xhr.open('POST', 'upload.php');

        //         xhr.onload = function() {
        //             var json;

        //             if (xhr.status != 200) {
        //                 failure('HTTP Error: ' + xhr.status);
        //                 return;
        //             }

        //             json = JSON.parse(xhr.responseText);

        //             if (!json || typeof json.location != 'string') {
        //                 failure('Invalid JSON: ' + xhr.responseText);
        //                 return;
        //             }

        //             success(json.location);
        //         };

        //         formData = new FormData();
        //         formData.append('file', blobInfo.blob(), blobInfo.filename());

        //         xhr.send(formData);
        //     },

        //    external_filemanager_path:"filemanager/",
        //    filemanager_title:"Filemanager" ,
        //    filemanager_access_key:accKey,
        //    external_plugins: { "filemanager" : "filemanager/plugin.min.js"}

        //   });
        // อันใหม่เป็น Laravel Filemanager
        var editor_config = {
            path_absolute: "/",
            lang: 'th_TH'
        }
        tinymce.init({
            selector: '#QNote',
            height: 600,
            language: 'th_TH',
            relative_urls: false,
            plugins: [
                'advlist autolink link image imagetools lists codesample charmap print preview hr anchor pagebreak spellchecker',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table contextmenu directionality emoticons template responsivefilemanager  textcolor importcss '
            ],
            toolbar: 'insertfile undo redo | styleselect fontselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons | removeformat ',
            file_picker_callback: function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document
                    .getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                cmsURL = cmsURL + '&lang=' + editor_config.lang;
                // console.log(cmsURL);
                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            },
            external_filemanager_path: "filemanager/",
            filemanager_title: "Filemanager",
            filemanager_access_key: accKey,
            external_plugins: {
                "filemanager": "filemanager/plugin.min.js"
            },
            font_formats: "Prompt='Prompt';Sarabun='Sarabun';Kanit='Kanit';Chakra Petch='Chakra Petch';IBM Plex Sans Thai='IBM Plex Sans Thai';K2D='K2D';Noto Sans Thai='Noto Sans Thai';Noto Serif Thai='Noto Serif Thai';Pridi='Pridi';Taviraj='Taviraj';",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Kanit:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100;200;300;400;500;600;700;800;900&family=Noto+Serif+Thai:wght@100;200;300;400;500;600;700;800;900&family=Pridi:wght@200;300;400;500;600;700&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Srisakdi:wght@400;700&family=Taviraj:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');"

        });
    </script>
@endpush
