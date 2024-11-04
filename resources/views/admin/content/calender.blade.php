<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3">
            <label class="login2 pull-right pull-right-pro">
                กำหนดวันที่กิจกรรม :
            </label>
        </div>
        <div class="col-lg-7">
            <div class="input-group date">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="datepicker form-control" name="ReplayDate" readonly="" data-date-format="dd/mm/yyyy"
                    style="cursor: pointer;" required="">
            </div>
        </div>
    </div>
</div>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3">
            <label class="login2 pull-right pull-right-pro">
                รายละเอียด :
            </label>
        </div>
        <div class="col-lg-7">
            <textarea type="text" class="form-control" cols="80" name="QNote" rows="8">{{ $Note }}</textarea>
        </div>
    </div>
</div>


@push('scripts')
<script>
    $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language:'th',
                thaiyear: true
            });
    });
</script>
@endpush
