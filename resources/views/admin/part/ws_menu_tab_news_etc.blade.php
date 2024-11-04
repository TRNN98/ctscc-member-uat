<div class="basic-form-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="sparkline12-list shadow-reset mg-t-30">
                    <div class="sparkline12-graph">
                        <div class="inbox-email-menu-list compose-b-mg-30 shadow-reset">
                            <ul class="nav nav-tabs text-left">
                                @foreach ($menuTab2 as $Tab2)
                                    <li>
                                        <a href="{{ url('admin/control').'?page=ws_data_list&Category='.$Tab2->category.'&type='.$Tab2->type.'&backPage'}}">
                                            - {{$Tab2->description}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
