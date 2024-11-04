<table id="tb_ws_constant" width="744" border="0" style="font-family:Tahoma, Geneva, sans-serif; font-size:12px">
    <form action="{{ route('ws_constant.update',[1]) }}" method="POST" name="form1">
        @csrf
        @method('PATCH')
        <tr>
            <td colspan="2"><strong>
                    <h2>Constant Configuration</h2>
                </strong></td>
        </tr>
        <tr>
            <td width="186"><strong>
                    <label>ชื่อสหกรณ์</label>
                    :</strong></td>
            <td class="form-group-inner" width="258"><input class="form-control" name="tf_cname" type="text"
                    id="textfield" value="{{ $dataconstant->coop_name }}" size="40"></td>
        </tr>
        <tr>
            <td><strong>วิธีการล็อกอิน :</strong></td>
            <td class="form-group-inner"><input class="form-control" name="tf_login_method" type="text" id="textfield"
                    value="{{ $dataconstant->identified_type }}" size="40" /></td>
        </tr>
        <tr>
            <td><strong>ช่องเปลี่ยนรหัสผ่าน :</strong></td>
            <td class="form-select-list">
                <select class="form-control custom-select-value" name="lm_chpass" id="lm_chpass">
                    <option value="0" <?php if($dataconstant->change_pwd_box == 0)echo "selected='selected'"; ?>>Show
                    </option>
                    <option value="1" <?php if($dataconstant->change_pwd_box == 1)echo "selected='selected'"; ?>>Hide
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td><strong>ข้อมูลผู้รับผลประโยชน์ :</strong></td>
            <td class="form-select-list"><select class="form-control custom-select-value" name="lm_gain" id="lm_gain">
                    <option value="0" <?php if($dataconstant->mem_gain_detail == 0)echo "selected='selected'"; ?>>Show
                    </option>
                    <option value="1" <?php if($dataconstant->mem_gain_detail == 1)echo "selected='selected'"; ?>>Hide
                    </option>
                </select></td>
        </tr>
        <tr>
            <td><strong>ข้อมูลปันผลเฉลี่ยคืน :</strong></td>
            <td class="form-select-list"><select class="form-control custom-select-value" name="lm_divid" id="lm_divid">
                    <option value="0" <?php if($dataconstant->mem_receive_dividend == 0)echo "selected='selected'"; ?>>
                        Show</option>
                    <option value="1" <?php if($dataconstant->mem_receive_dividend == 1)echo "selected='selected'"; ?>>
                        Hide</option>
                </select></td>
        </tr>
        <tr>
            <td><strong>ระบบจัดการข้อมูล :</strong></td>
            <td class="form-select-list"><select class="form-control custom-select-value" name="lm_data" id="lm_data">
                    <option value="0" <?php if($dataconstant->mem_receive_dividend == 0)echo "selected='selected'"; ?>>
                        Show</option>
                    <option value="1" <?php if($dataconstant->mem_receive_dividend == 1)echo "selected='selected'"; ?>>
                        Hide</option>
                </select></td>
        </tr>
        <tr>
            <td><strong>Web Member soft launch :</strong></td>
            <td class="form-group-inner">
                <div>
                    <label for="">เปิดใช้งาน</label>
                    <input name="member_maintenance" value="0" type="radio"
                        @if ($dataconstant->member_maintenance == '0') checked @endif />
                    &nbsp;
                    <label for="">ปิดใช้งาน</label>
                    &nbsp;
                    <input name="member_maintenance" value="1" type="radio"
                        @if ($dataconstant->member_maintenance == '1') checked @endif />
                </div>

            </td>
        </tr>
        <tr>
            <td><strong>followme soft launch :</strong></td>
            <td class="form-group-inner">
                <div>
                    <label for="">เปิดใช้งาน</label>
                    <input name="www_followme_softlaunch" value="1" type="radio"
                        @if ($dataconstant->www_followme_softlaunch == '1') checked @endif />
                    &nbsp;
                    <label for="">ปิดใช้งาน</label>
                    &nbsp;
                    <input name="www_followme_softlaunch" value="0" type="radio"
                        @if ($dataconstant->www_followme_softlaunch == '0') checked @endif />
                </div>

            </td>
        </tr>
        <tr>
            <td><strong>Promoney soft launch :</strong></td>
            <td class="form-group-inner">
                <div>
                    <label for="">เปิดใช้งาน</label>
                    <input name="www_promoney_softlaunch" value="1" type="radio"
                        @if ($dataconstant->www_promoney_softlaunch == '1') checked @endif />
                    &nbsp;
                    <label for="">ปิดใช้งาน</label>
                    &nbsp;
                    <input name="www_promoney_softlaunch" value="0" type="radio"
                        @if ($dataconstant->www_promoney_softlaunch == '0') checked @endif />
                </div>

            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center"><strong>soft launch ใช้สำหรับ Module ของ Promoney ที่ขึ้น
                    Productionไปแล้วแต่จะกรองเลือกว่าจะให้เลขสมาชิกรายไหนเข้าใช้งานในการทดสอบได้บ้าง</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" class="btn" name="bt_change" id="bt_change" value="Change" /></td>
        </tr>
    </form>
</table>

<style>
    #tb_ws_constant tr td {
        padding: 15px;
    }

    tr>td>strong {
        font-size: 16px;
    }

    #bt_change {
        background: linear-gradient(to bottom, #ff9966 0%, #d75151 100%);
        color: #fff;
    }
</style>
