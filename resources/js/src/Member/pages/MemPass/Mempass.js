import React, {useEffect,useState} from 'react'
import { useDispatch } from "react-redux";
import useForm from 'react-hook-form';
import { NotificationManager } from 'react-notifications';
import VisibilityIcon from '@material-ui/icons/Visibility';
import VisibilityOffIcon from '@material-ui/icons/VisibilityOff';

import { userActions } from '../../actions';

const Mempass = () => {

    const dispatch = useDispatch();

    const { register, handleSubmit } = useForm();

    const [showPassword, setShowPassword] = useState(false);
    const [showRePassword, setShowRePassword] = useState(false);

    const togglePasswordVisibility = () => {
        setShowPassword(!showPassword);
    };

    const toggleRePasswordVisibility = () => {
        setShowRePassword(!showRePassword);
    };

    const onSubmit = async (data, e) => {
        e.preventDefault();
        if (data.old_password == "" || data.old_password == null) {
            NotificationManager.error("กรุณากรอก รหัสผ่านเดิม", 'Error', 5000);
        }else if (data.new_password == "" || data.new_password == null) {
            NotificationManager.error("กรุณากรอก รหัสผ่านใหม่", 'Error', 5000);
        }else if (data.confirmpass == "" || data.confirmpass == null) {
            NotificationManager.error("กรุณากรอก ยืนยันรหัสผ่านใหม่", 'Error', 5000);
        }else if (data.new_password != data.confirmpass) {
            NotificationManager.error("กรุณากรอก ยืนยันรหัสผ่านใหม่ ให้ตรงกัน", 'Error', 5000);
        }else{

            await dispatch(userActions.change_pass(data.new_password, data.old_password));
            e.target.reset();
        }
    }


    const [passwordChecks, setPasswordChecks] = useState({
        hasUppercase: false,
        hasLowercase: false,
        hasNumber: false,
        hasSpecialChar: false,
        isValidLength: false,
      });

    const dokeyup = (e) => {
        const password = e.target.value;
        
        const newChecks = {
          hasUppercase: /[A-Z]/.test(password),
          hasLowercase: /[a-z]/.test(password),
          hasNumber: /[0-9]/.test(password),
          hasSpecialChar: /[!@#$%^&*(),.?":{}|<>_+=]/.test(password),
          isValidLength: password.length >= 8 && password.length <= 15,
        };
      
        setPasswordChecks(newChecks);
      
        const isValidPassword = Object.values(newChecks).every(Boolean);
        document.getElementById("confirmpass").disabled = !isValidPassword;
      };

    return (
        <div className="container">
            <form method="post" id="changepass" name="changepass" onSubmit={handleSubmit(onSubmit)}>
                <div className="row">
                    <div className="col-md-6 col-md-offset-2 ">
                        <div className="form-group">
                            <label htmlFor="old_password" id="texttitle"><i className="fa fa-key fa-fw f-s16" />&nbsp;รหัสผ่านเดิม</label>
                            <input type="password" className="form-control input-md" name="old_password" id="old_password" placeholder="รหัสผ่านเดิม" ref={register} required />
                        </div>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-6 col-md-offset-2">
                        <div className="form-group">
                            <label htmlFor="new_password" id="texttitle"><i className="fa fa-lock fa-fw f-s16" />&nbsp;รหัสผ่านใหม่</label>
                            <div className="password-input-wrapper" style={{ position: 'relative' }}>
                            <input type={showPassword ? 'text' : 'password'} className="form-control input-md" name="new_password" id="new_password" placeholder="รหัสผ่านใหม่" maxLength={15} onChange={dokeyup} ref={register} required />
                            <span
                                onClick={togglePasswordVisibility}
                                style={{
                                    position: 'absolute',
                                    right: '10px',
                                    top: '50%',
                                    transform: 'translateY(-50%)',
                                    cursor: 'pointer',
                                    }}
                                >
                                    {showPassword ? <VisibilityIcon /> : <VisibilityOffIcon />}
                            </span>
                            </div>
                            <span id="helpBlock" className="help-block hh">
                                                กรุณากรอกรหัสผ่านที่ประกอบด้วย
                                            <br />
                                            {passwordChecks.hasSpecialChar ? (
                                                <span style={{ color: "#50C878" }}>✓ อักขระพิเศษ ( @, #, &, $)</span>
                                            ) : (
                                                "- อักขระพิเศษ (@, #, &, $)"
                                            )}
                                            <br />
                                            {passwordChecks.hasUppercase ? (
                                                <span style={{ color: "#50C878" }}>✓ ตัวอักษรพิมพ์ใหญ่ (A-Z)</span>
                                            ) : (
                                                "- ตัวอักษรพิมพ์ใหญ่ (A-Z)"
                                            )}
                                            <br />
                                            {passwordChecks.hasLowercase ? (
                                                <span style={{ color: "#50C878" }}>✓ ตัวอักษรพิมพ์เล็ก (a-z)</span>
                                            ) : (
                                                "- ตัวอักษรพิมพ์เล็ก (a-z)"
                                            )}
                                            <br />
                                            {passwordChecks.hasNumber ? (
                                                <span style={{ color: "#50C878" }}>✓ ตัวเลข (0-9)</span>
                                            ) : (
                                                "- ตัวเลข (0-9)"
                                            )}
                                            <br />
                                            {passwordChecks.isValidLength ? (
                                                <span style={{ color: "#50C878" }}>✓ ความยาวอย่างน้อย 8 ตัวอักษร</span>
                                            ) : (
                                                "- ความยาวอย่างน้อย 8 ตัวอักษร"
                                            )}
                                        </span>
                        </div>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-6 col-md-offset-2">
                        <div className="form-group" style={{marginTop: 10}}>
                            <label htmlFor="confirmpass" id="texttitle"><i className="fa fa-unlock-alt fa-fw f-s16" />&nbsp;ยืนยันรหัสผ่านใหม่</label>
                            <div className="password-input-wrapper" style={{ position: 'relative' }}>
                            <input type={showPassword ? 'text' : 'password'} className="form-control input-md" name="confirmpass" id="confirmpass" placeholder="ยืนยันรหัสผ่านใหม่" ref={register} required disabled/>
                            <span
                                onClick={toggleRePasswordVisibility}
                                style={{
                                    position: 'absolute',
                                    right: '10px',
                                    top: '50%',
                                    transform: 'translateY(-50%)',
                                    cursor: 'pointer',
                                }}
                                >
                                    {showRePassword ? <VisibilityIcon /> : <VisibilityOffIcon />}
                            </span>
                            </div>
                            <span id="helpBlock" className="help-block f-s16">กรอกเหมือนกับรหัสผ่าน</span>
                        </div>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-6 col-md-offset-2">
                        <div className="form-group" style={{marginTop: 10}}>
                            <button type="submit" className="btn btn-danger f-s16" name="chadminpass">เปลี่ยนรหัสผ่าน</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    )
}

export default Mempass
