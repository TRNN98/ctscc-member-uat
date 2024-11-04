import React, { useEffect, Fragment, useState, useRef } from "react";
import { Link, useHistory } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import useForm from "react-hook-form";
import { NotificationManager } from "react-notifications";
import LoadingOverlay from "react-loading-overlay";
import ReCAPTCHA from "react-google-recaptcha";
import Inputmask from "inputmask";
import VisibilityIcon from '@material-ui/icons/Visibility';
import VisibilityOffIcon from '@material-ui/icons/VisibilityOff';

import {
    useStyle,
    useScript,
    Wordcount,
    isInputNumber
} from "../../../helpers";
import { MemRegisActions, MemForgetActions } from "../../actions";

const Memregis = () => {
    useScript("member/coop/dist/jquery-2.1.3.min.js");
    useStyle("member/coop/bootstrap-3.3.7-dist/css/bootstrap.css");
    useStyle("member/coop/bootstrap-3.3.7-dist/css/bootstrap-theme.css");
    useScript("member/coop/bootstrap-3.3.7-dist/js/bootstrap.js");
    useStyle("member/coop/dist/css/bootstrap-datepicker.css");
    useScript("member/coop/dist/js/bootstrap-datepicker-custom.js");
    useScript("member/coop/dist/locales/bootstrap-datepicker.th.min.js");

    useStyle("member/coop/librarys/member_detail/page.css");
    useScript("member/coop/librarys/member_detail/page.js");

    // useScript('member/coop/librarys/member_detail/page.js');
    useScript("admin/js/input-mask/jasny-bootstrap.min.js");

    useStyle("https://fonts.googleapis.com/css?family=Kanit&subset=thai");
    useStyle("member/coop/librarys/font-awesome/css/font-awesome.min.css");
    useStyle("member/coop/librarys/css/mem.css");

    useScript("https://www.google.com/recaptcha/api.js");

    const dispatch = useDispatch();
    const state = useSelector(state => state);
    const history = useHistory();

    const { register, handleSubmit, watch, errors, reset } = useForm();

    if (state.authentication.loggedIn) {
        setTimeout(history.push("/status"), 100);
    }

    const [title, setTitle] = useState({
        title: "",
        detail: ""
    });
    const [recap, setRecap] = useState(false);

    const reCap = useRef(null);

    const [showPassword, setShowPassword] = useState(false);
    const [showRePassword, setShowRePassword] = useState(false);

    const togglePasswordVisibility = () => {
        setShowPassword(!showPassword);
    };

    const toggleRePasswordVisibility = () => {
        setShowRePassword(!showRePassword);
    };

    useEffect(() => {
        if (history.location.pathname == "/register") {
            window.scrollTo(0, 0);
            setTitle({
                title: "ลงทะเบียน",
                detail: "สมัครสมาชิก  (register)"
            });
            reset();
        } else {
            window.scrollTo(0, 0);
            setTitle({
                title: "ระบบตรวจสอบข้อมูลสมาชิก",
                detail: "ลืมรหัสผ่าน  (Reset Password)"
            });
            reset();
        }

        Inputmask().mask(document.querySelectorAll("input"));
    }, [history.location.pathname]);

    if (errors.membership_no) {
        NotificationManager.error("กรุณากรอก ทะเบียนสมาชิก", "Error", 5000);
    } else if (errors.id_card) {
        NotificationManager.error("กรุณากรอก เลขที่บัตรประชาชน", "Error", 5000);
    } else if (errors.member_name) {
        NotificationManager.error("กรุณากรอก ชื่อ", "Error", 5000);
    } else if (errors.member_surname) {
        NotificationManager.error("กรุณากรอก นามสกุล", "Error", 5000);
    } else if (errors.date_of_birth) {
        NotificationManager.error("กรุณากรอก วัน/เดือน/ปี เกิด", "Error", 5000);
    } else if (errors.password) {
        NotificationManager.error("กรุณากรอก รหัสผ่าน", "Error", 5000);
    } else if (errors.repassword) {
        NotificationManager.error("กรุณากรอก ยืนยันรหัสผ่าน", "Error", 5000);
    }

    const onSubmit = (data, e) => {
        e.preventDefault();
        // if (!recap) {
        //     NotificationManager.error(
        //         "กรุณาติ๊ก ยืนยันว่าคุณไม่ใช่บอท",
        //         "Error",
        //         5000
        //     );
        // } else {

        if (data.password != data.repassword) {
            NotificationManager.error(
                "กรุณากรอก ยืนยันรหัสผ่าน ให้ตรงกัน",
                "Error",
                5000
            );
        } else {
            if (history.location.pathname == "/register") {
                dispatch(
                    MemRegisActions.feedDataPost("api/member/auth/register", {
                        membership_no: data.membership_no,
                        id_card: safeRE(data.id_card),
                        member_name: data.member_name,
                        member_surname: data.member_surname,
                        date_of_birth: coverDate(data.date_of_birth),
                        password: data.password
                    })
                ).then(res => setInterval(history.push("/logon"), 100));
            } else {
                dispatch(
                    MemForgetActions.feedDataPost("api/member/auth/forget", {
                        membership_no: data.membership_no,
                        id_card: safeRE(data.id_card),
                        member_name: data.member_name,
                        member_surname: data.member_surname,
                        date_of_birth: coverDate(data.date_of_birth),
                        password: data.password
                    })
                ).then(res => setInterval(history.push("/logon"), 100));
            }
        }

        // }
    };

    const makeaction = value => {
        setRecap(true);
    };

    const safeRE = string => {
        var str = string.split("-");
        return str.join("");
    };

    const coverDate = d => {
        var date = d.split("/");
        var res = date[2] - 543 + "-" + date[1] + "-" + date[0];
        return res;
    };

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
        document.getElementById("repassword").disabled = !isValidPassword;
      };
      

      const specialCharsDisplay = "!@#$%^&*(),.?\":{}|<>_+="

    

    return (
        <LoadingOverlay
            active={state.MemRegis.fetching || state.MemForget.fetching}
            spinner
            text="Loading ..."
        >
            <style
                dangerouslySetInnerHTML={{
                    __html:
                        "\n  .hh{\n    color: #00a6ff;\n    font-size: 16px;\n  }\n"
                }}
            />
            <div className="container">
                <div className="row justify-content-center" style={{ paddingTop: '15px' }}>
                    <div className="col-md-12 f-Kanit">
                        <div className="card">
                            <div className="card-body">
                                <div className="row">
                                    <div
                                        className="col-md-2"
                                        align="right"
                                    ></div>
                                    <div className="col-md-2" align="right">
                                        <img
                                            style={{
                                                width: "120px"
                                            }}
                                            src="info/assets/index/logo.jpg"
                                            itemProp="image"
                                        />
                                    </div>
                                    <div className="col-md-8">
                                        <h1
                                            className="card-title"
                                            style={{ fontSize: "29px" }}
                                        >
                                            <b>สหกรณ์ออมทรัพย์ครูชุมพร จำกัด</b>
                                            <br />
                                            <small>
                                                Chumphon Teacher's Saving and
                                                Credit Cooperative Ltd.
                                            </small>
                                        </h1>
                                    </div>
                                </div>
                                <h3 className="card-subtitle mb-2 text-muted text-center">
                                    <i className="glyphicon glyphicon-folder-open"></i>
                                    &nbsp;
                                    {title.title != "" && title.title}
                                    <br />
                                    <small>
                                        {title.detail != "" && title.detail}
                                    </small>
                                </h3>
                                <hr />
                                <form onSubmit={handleSubmit(onSubmit)}>
                                    <div className="col-md-6 col-md-offset-3">
                                        <div className="form-group">
                                            <label
                                                htmlFor="member_id"
                                                className="f-s20"
                                            >
                                                เลขที่สมาชิก
                                            </label>
                                            <input
                                                type="text"
                                                className="form-control input-lg"
                                                name="membership_no"
                                                id="membership_no"
                                                placeholder="เลขที่สมาชิก"
                                                maxLength={5}
                                                onKeyPress={e =>
                                                    isInputNumber(e)
                                                }
                                                onBlur={Wordcount}
                                                ref={register({
                                                    required: true
                                                })}
                                            />
                                            <span
                                                id="helpBlock"
                                                className="help-block hh"
                                            >
                                                กรุณากรอกหมายเลขสมาชิกให้ครบ 5
                                                หลัก เช่น 01234
                                            </span>
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-md-offset-3">
                                        <div className="form-group">
                                            <label
                                                htmlFor="mem_idcard"
                                                className="f-s20"
                                            >
                                                เลขที่บัตรประชาชน
                                            </label>
                                            <input
                                                type="text"
                                                className="form-control input-lg"
                                                name="id_card"
                                                data-mask="9-9999-99999-99-9"
                                                data-inputmask="'mask': '9-9999-99999-99-9'"
                                                placeholder="เลขที่บัตรประชาชน"
                                                ref={register({
                                                    required: true
                                                })}
                                            />
                                            <span
                                                id="helpBlock"
                                                className="help-block hh"
                                            >
                                                กรอกเลขที่บัตรประชาชน&nbsp;13&nbsp;หลักติดกันไม่ต้องมีเครื่องหมาย&nbsp;-&nbsp;เช่น&nbsp;1011011011010
                                            </span>
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-md-offset-3">
                                        <div className="form-group">
                                            <label
                                                htmlFor="name"
                                                className="f-s20"
                                            >
                                                ชื่อ
                                            </label>
                                            <input
                                                type="text"
                                                className="form-control input-lg"
                                                name="member_name"
                                                placeholder="ชื่อ"
                                                ref={register({
                                                    required: true
                                                })}
                                            />
                                            <span
                                                id="helpBlock"
                                                className="help-block hh"
                                            >
                                                กรอกชื่อไม่ต้องเติมคำนำหน้า
                                            </span>
                                        </div>
                                    </div>
                                    <div className="col-md-6 col-md-offset-3">
                                        <div className="form-group">
                                            <label
                                                htmlFor="surname"
                                                className="f-s20"
                                            >
                                                นามสกุล
                                            </label>
                                            <input
                                                type="text"
                                                className="form-control input-lg"
                                                name="member_surname"
                                                placeholder="นามสกุล"
                                                ref={register({
                                                    required: true
                                                })}
                                            />
                                            <span
                                                id="helpBlock"
                                                className="help-block hh"
                                            >
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </span>
                                        </div>
                                    </div>
                                    {/* <div class="form-group">
                                        <label for="shareMonthly" class="f-s20">ค่าหุ้น</label>
                                        <input type="text" class="form-control input-lg" name="shareMonthly" id="shareMonthly" placeholder="ค่าหุ้น">
                                        <span id="helpBlock" class="help-block hh">จำนวนค่าหุ้นรายเดือน&nbsp;ส่งเดือนละ&nbsp;โดยกรอกเป็นจำนวนเลขไม่ต้องมีเครื่องหมาย&nbsp;"<span class="f-s30">,</span>"&nbsp;เช่น&nbsp;<span class="f-s20">2780.50</span>
                                        <br>กรณีงดส่ง ให้ใส่ ค่าหุ้นรายเดือน เดือนสุดท้ายที่ส่ง
                                        </span>
                                    </div> */}
                                    <div className="col-md-6 col-md-offset-3">
                                        <div className="form-group">
                                            <label className="f-s20">
                                                วัน/เดือน/ปี เกิด
                                            </label>
                                            <div className="row">
                                                <div className="col-xs-12">
                                                    <input
                                                        type="text"
                                                        name="date_of_birth"
                                                        className="form-control input-lg"
                                                        data-mask="99/99/9999"
                                                        data-inputmask="'mask': '99/99/9999'"
                                                        ref={register({
                                                            required: true
                                                        })}
                                                    />
                                                </div>
                                            </div>
                                            <span
                                                id="helpBlock"
                                                className="help-block hh"
                                            >
                                                เช่น
                                                07&nbsp;/&nbsp;02&nbsp;/&nbsp;2520
                                                <br />
                                                ** กรุณาระบุปีเป็น พ.ศ.
                                            </span>
                                        </div>
                                    </div>
                                    {/* <div class="form-group">
                                        <label for="email" class="f-s20">อีเมล</label>
                                        <input type="email" class="form-control input-lg" name="email" id="email" placeholder="อีเมล" required>
                                        <span id="helpBlock" class="help-block hh">กรอกอีเมล ตัวอย่างเช่น example@gmail.com <br>
                                            <font color="red">
                                            *** คำแนะนำ ควรกรอกอีเมลที่ใช้งานจริงของท่าน ***<br>
                                            *** ในกรณีลืมรหัสผ่าน ท่านสามารถกำหนดรหัสผ่านใหม่ได้ทางอีเมล ***
                                            </font>
                                        </span>
                                        <span id="helpBlock" class="help-block hh"><input type="checkbox" name="name" onclick="showPassword(this)">&nbsp;แสดงรหัสผ่าน</span>
                                        </div>*/}
                                    {/* <div className="col-md-12">
                                        <hr />
                                    </div> */}
                                    <div className="col-md-6 col-md-offset-3">
                                        <div className="form-group">
                                            <label
                                                htmlFor="password"
                                                className="f-s20"
                                            >
                                                รหัสผ่าน
                                            </label>
                                            <div className="password-input-wrapper" style={{ position: 'relative' }}>
                                                <input
                                                    type={showPassword ? 'text' : 'password'}
                                                    className="form-control input-lg"
                                                    name="password"
                                                    id="password"
                                                    placeholder="รหัสผ่าน"
                                                    onChange={dokeyup}
                                                    maxLength={15}
                                                    ref={register({
                                                        required: true,
                                                    })}
                                                />
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
                                            <span style={{color: "#B8001F"}}>
                                            {passwordChecks.hasSpecialChar ? (
                                                <span style={{ color: "#50C878" }}>✓ อักขระพิเศษ ({specialCharsDisplay})</span>
                                            ) : (
                                                `- อักขระพิเศษ (${specialCharsDisplay})`
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
                                        </span>
                                            {/* <span id="helpBlock" className="help-block hh text-right"><input type="checkbox" name="name"/>&nbsp;แสดงรหัสผ่าน</span> */}
                                        </div>
                                        <div className="form-group">
                                            <label
                                                htmlFor="repassword"
                                                className="f-s20"
                                            >
                                                ยืนยันรหัสผ่าน
                                            </label>
                                            <div className="password-input-wrapper" style={{ position: 'relative' }}>
                                                <input
                                                    type={showRePassword ? 'text' : 'password'}
                                                    className="form-control input-lg"
                                                    name="repassword"
                                                    id="repassword"
                                                    placeholder="ยืนยันรหัสผ่าน"
                                                    ref={register({
                                                        required: true,
                                                    })}
                                                    disabled
                                                />
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
                                            <span
                                                id="helpBlock"
                                                className="help-block hh"
                                            >
                                                กรอกให้ตรงกับรหัสผ่าน
                                            </span>
                                            {/* <span id="helpBlock" className="help-block hh text-right"><input type="checkbox" name="name"/>&nbsp;แสดงรหัสผ่าน</span> */}
                                        </div>
                                        <div className="form-group">
                                            {/* <div className="g-recaptcha" data-callback="makeaction" data-sitekey="6LedJK0UAAAAAH6Znnq9nF5umHVtgmbyUnhOAeyX" /> */}
                                            <ReCAPTCHA
                                                sitekey="6LccsgkaAAAAAKldAjFpvd4RbnwnBm5J89ETfvrL"
                                                hl="th"
                                                ref={reCap}
                                                onChange={makeaction}
                                            />
                                        </div>
                                        <div className="form-group text-right">
                                            {/* <input type="hidden" name="action" id="action" defaultValue="register" /> */}
                                            <button
                                                type="submit"
                                                className="btn btn-success btn-lg btn-block f-s20"
                                                name="Submit"
                                                id="Submit"
                                            >
                                                <span className="glyphicon glyphicon-import" />
                                                &nbsp;ลงทะเบียน
                                            </button>
                                        </div>
                                        {/* {'{'}{'{'}-- <a href="{{ route('CallCheckCreditOtp') }}">สมัครด้วย otp</a> --{'}'}{'}'} */}
                                    </div>
                                    <div className="col-md-12">
                                        <hr />
                                        <div className="form-group text-left">
                                            <Link to="/logon">
                                                เข้าสู่ระบบ&nbsp;(Login)
                                            </Link>
                                            &nbsp;|&nbsp;
                                            {history.location.pathname ==
                                            "/register" ? (
                                                <Link to={`/forget`}>
                                                    ลืมรหัสผ่าน (Reset Password)
                                                </Link>
                                            ) : (
                                                <Link to={`/register`}>
                                                    สมัครสมาชิก (register)
                                                </Link>
                                            )}
                                        </div>
                                        {/* <div className="form-group text-right">
                                            <Link to="/home">กลับหน้าหลัก</Link>
                                        </div> */}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </LoadingOverlay>
    );
};

export default Memregis;
