@php
$cutStr = explode('|',$table->Question);
$typeDoc = $cutStr[1];
$table->Question = $cutStr[0];
// dd($table->Question);
@endphp
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3">
            <label class="login2 pull-right pull-right-pro">ประเภทเอกสาร :
            </label>
        </div>
        <div class="col-lg-7">
            <select name="QTypeDoc" class="form-control custom-select-value" required>
                <option value="" disabled selected>-- เลือกประเภทของเอกสาร
                    --</option>
                <option value="แบบฟอร์มด้านการเงิน" @if($typeDoc=='แบบฟอร์มด้านการเงิน' ) selected @endif>
                    แบบฟอร์มด้านการเงิน</option>
                <option value="แบบฟอร์มด้านบริหารทั่วไป" @if($typeDoc=='แบบฟอร์มด้านบริหารทั่วไป' ) selected @endif>
                    แบบฟอร์มด้านบริหารทั่วไป</option>
                <option value="แบบฟอร์มด้านสวัสดิการ" @if($typeDoc=='แบบฟอร์มด้านสวัสดิการ' ) selected @endif>
                    แบบฟอร์มด้านสวัสดิการ</option>
                <option value="แบบฟอร์มด้านสินเชื่อ" @if($typeDoc=='แบบฟอร์มด้านสินเชื่อ' ) selected @endif>
                    แบบฟอร์มด้านสินเชื่อ</option>
            </select>
        </div>
    </div>
</div>
