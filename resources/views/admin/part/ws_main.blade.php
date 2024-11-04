@section('styles')
<!-- charts C3 CSS
		============================================ -->
{{-- <link rel="stylesheet" href="{{ asset('admin/css/c3.min.css') }}"> --}}
@endsection

<!-- income order visit user Start -->
<div class="income-order-visit-user-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="income-dashone-total income-monthly shadow-reset nt-mg-b-30">
                    <div class="income-title">
                        <div class="main-income-head">
                            <h2>จำนวนกระทู้ ทั้งหมด</h2>
                        </div>
                    </div>
                    <div class="income-dashone-pro">

                        <div class="income-rate-total">
                            <div class="price-adminpro-rate">
                                <h3><span class="counter">{{ number_format($count_board->count_board) }} </span><span>
                                        กระทู้</span></h3>
                            </div>
                        </div>
                        <div class="income-range">
                            <a href="{{ url('board') }}"><span class="income-percentange"><i class="fa fa-bolt"></i>
                                    ดูกระทู้ทั้งหมด</span></a>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="income-dashone-total orders-monthly shadow-reset nt-mg-b-30">
                    <div class="income-title">
                        <div class="main-income-head">
                            <h2>สถิติการเข้าระบบ</h2>
                            <div class="main-income-phara order-cl">
                                <p>วันนี้</p>
                            </div>
                        </div>
                    </div>
                    <div class="income-dashone-pro">

                        <div class="income-rate-total">
                            <div class="price-adminpro-rate">
                                <h3><span class="counter"> {{ number_format($count_login->count_login) }}</span></h3>
                            </div>
                            <div class="price-graph">
                                <span id="sparkline6"></span>
                            </div>
                        </div>
                        <div class="income-range order-cl">
                            <span class="income-percentange"><i class="fa fa-level-up"></i></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="income-dashone-total visitor-monthly shadow-reset nt-mg-b-30">
                    <div class="income-title">
                        <div class="main-income-head">
                            <h2>สถิติผู้เยี่ยมชม</h2>
                            <div class="main-income-phara visitor-cl">
                                <p>วันนี้</p>
                            </div>
                        </div>
                    </div>
                    <div class="income-dashone-pro">

                        <div class="income-rate-total">
                            <div class="price-adminpro-rate">
                                <h3><span class="counter">{{ number_format($count_visitDay->count_visitDay) }}</span>
                                </h3>
                            </div>
                            <div class="price-graph">
                                <span id="sparkline2"></span>
                            </div>
                        </div>
                        <div class="income-range visitor-cl">
                            <span class="income-percentange"><i class="fa fa-line-chart"></i></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="income-dashone-total user-monthly shadow-reset nt-mg-b-30">
                    <div class="income-title">
                        <div class="main-income-head">
                            <h2>สมาชิกทั้งหมด</h2>
                        </div>
                    </div>
                    <div class="income-dashone-pro">
                        <div class="income-rate-total">
                            <div class="price-adminpro-rate">
                                <h3><span class="counter">{{ number_format($count_member->count_member) }}</span></h3>
                            </div>
                            <div class="price-graph">
                                <span id="sparkline5"></span>
                            </div>
                        </div>
                        <div class="income-range low-value-cl">
                            <span class="income-percentange"><i class="fa fa-bar-chart"></i></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- income order visit user End -->

<!-- custom chart start-->
<div class="pie-bar-line-area mg-tb-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="sparkline9-list c3-b-mg-30 shadow-reset">
                    <div class="sparkline9-hd">
                        <div class="main-sparkline9-hd">
                            <h1>สถิติผู้เยี่ยมชม <span class="c3-ds-n"> (ต่อเดือน)</span></h1>
                            <div class="sparkline9-outline-icon">
                                <span class="sparkline9-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                <span class="sparkline9-collapse-close"><i class="fa fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="sparkline9-graph">
                        <div id="stocked"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sparkline10-list shadow-reset">
                    <div class="sparkline10-hd">
                        <div class="main-sparkline10-hd">
                            <h1>สถิติผู้เยี่ยมชม <span class="c3-ds-n"> (ต่อปี)</span></h1>
                            <div class="sparkline10-outline-icon">
                                <span class="sparkline10-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                <span class="sparkline10-collapse-close"><i class="fa fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="sparkline10-graph">
                        <div id="pie"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- custom chart end-->

<!-- Three Section -->
<div class="feed-mesage-project-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="sparkline11-list shadow-reset mg-tb-30">
                    <div class="sparkline11-hd">
                        <div class="main-sparkline11-hd">
                            <h1>สมาชิกเข้าสู่ระบบ (ล่าสุด)</h1>
                            <div class="sparkline11-outline-icon">
                                <span class="sparkline11-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                <span class="sparkline11-collapse-close"><i class="fa fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="sparkline11-graph dashone-comment dashtwo-comment comment-scrollbar">
                        @foreach($member_recent_regis as $member_recent_regiss)
                        <div class="daily-feed-list">
                            <h4><span class="feed-author">ทะเบียน {{ $member_recent_regiss->membership_no }}</span></h4>
                            <p class="res-ds-n-t"><b> <i class="fa fa-clock-o"></i>
                                </b>{{ convert_to_Thaidate($member_recent_regiss->visit_date) }}<b> เวลา :
                                </b>{{ $member_recent_regiss->visit_time }}</p>
                        </div>
                        <div class="clear"></div>
                        @endforeach
                        {{-- <div class="daily-feed-list">
                                            <h4><span class="feed-author">ทะเบียน 000342</span> on <span class="feed-author">Desktop</span>.</h4>
                                            <p class="res-ds-n-t">12.06.2014</p>
                                    </div>
                                    <div class="daily-feed-list">
                                            <h4><span class="feed-author">ทะเบียน 000342</span> on <span class="feed-author">Desktop</span>.</h4>
                                            <p class="res-ds-n-t">12.06.2014</p>
                                    </div>
                                    <div class="daily-feed-list">
                                            <h4><span class="feed-author">ทะเบียน 000342</span> on <span class="feed-author">Desktop</span>.</h4>
                                            <p class="res-ds-n-t">12.06.2014</p>
                                    </div>
                                    <div class="daily-feed-list">
                                            <h4><span class="feed-author">ทะเบียน 000342</span> on <span class="feed-author">Desktop</span>.</h4>
                                            <p class="res-ds-n-t">12.06.2014</p>
                                    </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sparkline9-list shadow-reset mg-tb-30">
                    <div class="sparkline9-hd">
                        <div class="main-sparkline9-hd">
                            <h1>สมาชิกลงทะเบียน (ล่าสุด)</h1>
                            <div class="sparkline9-outline-icon">
                                <span class="sparkline9-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                <span class="sparkline9-collapse-close"><i class="fa fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="sparkline9-graph dashone-comment">
                        <div class="datatable-dashv1-list custom-datatable-overright dashtwo-project-list-data">
                            <table id="table1" data-toggle="table" data-pagination="true" data-search="true"
                                data-show-columns="true" data-resizable="false" data-cookie="true" data-page-size="6"
                                data-cookie-id-table="saveId" data-show-export="true">
                                <thead>
                                    <tr>
                                        <th data-field="id">#</th>
                                        <th data-field="status">ทะเบียน</th>
                                        <th data-field="date">เวลา</th>
                                        <th data-field="name">ชื่อ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach($member_recent as $member_recents)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td><a href="#">{{ $member_recents->membership_no }} </a></td>
                                        <td>{{ $member_recents->operate_date }} </td>
                                        <td>{{ $member_recents->member_name.'  '.$member_recents->member_surname }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sparkline8-list shadow-reset mg-tb-30">
                    <div class="sparkline8-hd">
                        <div class="main-sparkline8-hd">
                            <h1>ตอบ-กลับ กระทู้ (ล่าสุด)<small><a target="_blank"
                                        href="{{ url('board') }}"><br><br><span class="income-percentange"><i
                                                class="fa fa-bolt"></i> <u> ดูกระทู้ทั้งหมด</u></span></a></small></h1>

                            <div class="sparkline8-outline-icon">
                                <span class="sparkline8-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                <span><i class="fa fa-wrench"></i></span>
                                <span class="sparkline8-collapse-close"><i class="fa fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="sparkline8-graph dashone-comment messages-scrollbar dashtwo-messages">
                        @foreach($board_recent as $board_recents)
                        <div class="comment-phara">
                            <div class="comment-adminpr">
                                <a class="dashtwo-messsage-title" href="{{ url('boardShow',[$board_recents->No]) }}"
                                    target="_blank">
                                    เรื่อง : <u>{{ $board_recents->Question }}</u>
                                </a>
                                <p class="comment-content">ความคิดเห็น <i class="fa fa-caret-right"></i>
                                    {{ $board_recents->Msg }} </p>
                            </div>
                            <div class="admin-comment-month">
                                <p class="comment-clock"><i class="fa fa-clock-o"></i>{{ $board_recents->Date }} <i
                                        class="fa fa-user"></i> : {{ $board_recents->Name }} </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- c3 JS
        ============================================ -->
<script src="{{ asset('admin/js/c3-charts/d3.min.js') }}"></script>
<script src="{{ asset('admin/js/c3-charts/c3.min.js') }}"></script>

<script type="text/javascript">
    if (typeof(myDatam) != "undefined" && typeof(myDatay) != "undefined") {
        (function ($) {
            "use strict";
                    c3.generate({
                        bindto: '#stocked',
                        data:{
                            columns: myDatam,
                            type: 'bar',
                        },
                        bar: {
                            label: {
                                format: function (value, ratio, id) {
                                    return d3.format('จำนวน ')(value);
                                }
                            }
                        }
                    });

                    c3.generate({
                        bindto: '#pie',
                        data:{
                            columns: myDatay,
                            type : 'pie',
                        },
                        pie: {
                            label: {
                                format: function (value, ratio, id) {
                                    return d3.format('จำนวน ')(value);
                                }
                            }
                        }
                    });

        })(jQuery);

    }
</script>
@endpush
<script>
    var myDatam = [
        @foreach($myDatam as $myDatams)
            {!! '["เดือน '.$myDatams->months.' ปี '.$myDatams->years.'",'.$myDatams->visit_months.'],' !!}
        @endforeach
        ];

        var myDatay = [
        @foreach($myDatay as $myDatays)
            {!! '["ปี '.($myDatays->years+543).'",'.$myDatays->visit_years.'],' !!}
        @endforeach
        ];
</script>
