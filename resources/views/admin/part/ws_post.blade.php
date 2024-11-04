<div class="basic-form-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="sparkline12-list shadow-reset mg-t-30">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            {{-- ------------Main form---------------------- --}}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="all-form-element-inner align-content-center">
                                        <form action="{{ route('ws_post.store') }}" method="post"
                                            enctype="multipart/form-data" name="form1">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="type" value="{{ Request::get('type') }}">
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <label class="login2 pull-right pull-right-pro">เลือกหมวด :
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="form-select-list">
                                                            <select name="lm_ucf_category" id="lm_ucf_category"
                                                                class="form-control custom-select-value" name="account"
                                                                required>
                                                                <option value="">เลือกหมวด</option>
                                                                @foreach($description as $descriptions)
                                                                <option value="{{ $descriptions->category }}"
                                                                    @if($descriptions->category == $selected)
                                                                    {{
                                                                   "selected='selected'"
                                                                }}
                                                                    @endif
                                                                    >{{ $descriptions->description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @switch($category->content_type)
                                                @case('download_doc')
                                                    @include('admin.content.download_doc', ['table' => ''])
                                                    @include('admin.content.widget.topic', ['topic' => '', 'Question' => ''])
                                                    @include('admin.content.widget.byname', ['Name' => ''])
                                                    @break

                                                @case('link_url')
                                                    @include('admin.content.widget.topic', ['topic' => 'ชื่อลิ้งค์ :', 'Question' => ''])
                                                    @include('admin.content.link_url', ['Note' => ''])
                                                    @include('admin.content.widget.byname', ['Name' => ''])
                                                    @break

                                                @case('calender')
                                                    @include('admin.content.widget.topic', ['topic' => '', 'Question' => ''])
                                                    @include('admin.content.calender', ['Note' => '', 'ReplayDate' => ''])
                                                    @include('admin.content.widget.byname', ['Name' => ''])
                                                    @break

                                                @case('photo')
                                                        @include('admin.content.widget.topic', ['topic' => '', 'Question' => ''])
                                                        @include('admin.content.widget.editor', ['Note' => ''])
                                                        @include('admin.content.widget.byname', ['Name' => ''])
                                                        @include('admin.content.widget.file_upload', ['ndata' => ''])
                                                        @include('admin.content.widget.pic_upload', ['nphoto' => ''])
                                                        @include('admin.content.widget.photo_album', ['json_dataimg' => ''])
                                                    @break

                                                @case('signature')
                                                        @include('admin.content.signature', ['table' => ''])
                                                        @include('admin.content.widget.byname', ['Name' => ''])
                                                        @include('admin.content.widget.pic_upload', ['nphoto' => ''])
                                                    @break

                                                @case('video')
                                                        @include('admin.content.widget.topic', ['topic' => '', 'Question' => ''])
                                                        @include('admin.content.video', ['nmedia' => '' ])
                                                        @include('admin.content.widget.byname', ['Name' => ''])
                                                    @break

                                                @case('personnel')
                                                        @include('admin.content.personnel', ['Question' => '' , 'Note' => '' ])
                                                        @include('admin.content.widget.byname', ['Name' => ''])
                                                        @include('admin.content.widget.pic_upload', ['nphoto' => ''])
                                                    @break

                                                @case('content')
                                                        @include('admin.content.widget.topic', ['topic' => '', 'Question' => ''])
                                                        @include('admin.content.widget.editor', ['Note' => ''])
                                                        @include('admin.content.widget.byname', ['Name' => ''])
                                                    @break

                                                @default
                                                    @include('admin.content.widget.topic', ['topic' => '', 'Question' => ''])
                                                    @include('admin.content.widget.editor', ['Note' => ''])
                                                    @include('admin.content.widget.byname', ['Name' => ''])
                                                    @include('admin.content.widget.file_upload', ['ndata' => ''])
                                                    @include('admin.content.widget.pic_upload', ['nphoto' => ''])

                                            @endswitch

                                            <div class="form-group-inner">
                                                <div class="login-btn-inner">
                                                    <div class="row">
                                                        <div class="col-lg-3"></div>
                                                        <div class="col-lg-7">
                                                            <div class="login-horizental cancel-wp pull-left">
                                                                <button class="btn btn-white"
                                                                    type="reset">Reset</button>
                                                                <button class="btn btn-sm btn-primary login-submit-cs"
                                                                    type="submit" name="Submit" id="Submit"
                                                                    value="Submit">Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- ---------------------------------------------}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Basic Form End -->
