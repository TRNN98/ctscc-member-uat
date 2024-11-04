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

                                        <table class="table table-hover table-bordered" style="text-align:center;"
                                            width="744">
                                            <thead>
                                                <tr
                                                    style="border-bottom: 2px solid gray; margin-bottom:5px;background: #ffbe9e;">
                                                    <td>#</td>
                                                    <td>ปี</td>
                                                    <td>สถานะ</td>
                                                    <td>แสดง</td>
                                                    <td>ไม่แสดง</td>
                                                    <td></td>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                {{-- @dd($data) --}}
                                                @foreach ($data as $i => $val)
                                                    <tr>
                                                        <form
                                                            action="{{ route('ws_approve_divinded.update', $val->account_year) }}"
                                                            method="post" name="form1">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="_method" value="PUT">
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>ปี: {{ $val->account_year }} </td>
                                                            <td
                                                                style="color:{{ $val->approve_status == 1 ? 'blue' : 'red' }};">
                                                                {{ $val->approve_status == 1 ? 'แสดงผลแล้ว' : 'ไม่แสดงผล' }}
                                                            </td>
                                                            <td><input name="newconf" type="radio" value="1"
                                                                    {{ $val->approve_status == 1 ? checked : '' }} />
                                                            </td>
                                                            <td><input name="newconf" type="radio" value="0"
                                                                    {{ $val->approve_status == 0 ? checked : '' }} />
                                                            </td>
                                                            <td><button type="submit"
                                                                    class="btn btn-md btn-danger">OK</button></td>
                                                        </form>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            {{-- ------------------------------------------- --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Basic Form End -->
