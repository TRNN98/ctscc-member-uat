<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3">
            <label class="login2 pull-right pull-right-pro">
                ชื่อ-นามสกุล :
            </label>
        </div>
        <div class="col-lg-7">
            <input type="text" class="form-control" name="QTitle" value="{{ $Question }}"
                required />
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3">
            <label class="login2 pull-right pull-right-pro">
                ตำแหน่ง :
            </label>
        </div>
        <div class="col-lg-7">
            <div class="form-select-list">
                <input type="text" class="form-control" size=50 maxlength=100 id="QNote" name="QNote"
                    value="{{ $Note }}" />
            </div>
        </div>
    </div>
</div>


{{-- @push('scripts')
<script>
    function submitPersonnel()
    {
        let name = '';
        let department = '';
        let address = '';
        let tel = '';
        let email = '';

        if($('.txt1').val() != ''){
            name = $('.txt1').val();
        }else{
            name = ' - ';
        }
        if($('.txt2').val() != ''){
            department = $('.txt2').val();
        }else{
            department = ' - ';
        }
        if($('.txt3').val() != ''){
            address = $('.txt3').val();
        }else{
            address = ' - ';
        }
        if($('.txt4').val() != ''){
            tel = $('.txt4').val();
        }else{
            tel = ' - ';
        }
        if($('.txt5').val() != ''){
            email = $('.txt5').val();
        }else{
            email = ' - ';
        }

        let newTxt = name + '|' + department + '|'+ address + '|' +tel +'|'+email;

        $('#QNote2').val(newTxt);
        $('#f1').submit();
    }
</script>

@endpush --}}
