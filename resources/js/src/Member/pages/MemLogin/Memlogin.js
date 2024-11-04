import React, { useState, useRef, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Link, useHistory, withRouter } from "react-router-dom";
import { Helmet } from "react-helmet";
import { NotificationManager } from "react-notifications";
import useForm from "react-hook-form";
import LoadingOverlay from "react-loading-overlay";
import ReCAPTCHA from "react-google-recaptcha";

import {
    useScript,
    useStyle,
    Wordcount,
    isInputNumber
} from "../../../helpers";
import { userActions } from "../../actions";

const Memlogin = () => {
    const dispatch = useDispatch();
    const authentication = useSelector(state => state.authentication);
    const [recap, setRecap] = useState(false);
    let history = useHistory();

    useEffect(() => {
        if (authentication.loggedIn) {
            history.push("/status");
        }
    }, [authentication]);

    const { register, handleSubmit, watch, errors } = useForm();
    const reCap = useRef(null);

    useEffect(() => {
        if (errors.membership_no) {
            NotificationManager.error("กรุณากรอก ทะเบียนสมาชิก", "Error", 5000);
        } else if (errors.mem_password) {
            NotificationManager.error("กรุณากรอก รหัสผ่าน", "Error", 5000);
        }
    }, [errors]);

    const onSubmit = async (data, e) => {
    e.preventDefault();

    // Check if recaptcha is present (uncomment the if statement when needed)
    // if (!recap) {
    //     NotificationManager.error(
    //         "กรุณาติ๊ก ยืนยันว่าคุณไม่ใช่บอท",
    //         "Error",
    //         5000
    //     );
    //     return;
    // }

    // Call the custom alert function here
    const customAlert = (message) => {
        alert(message); // Replace this with your custom alert function
    };

    await dispatch(
        userActions.login(data, history, customAlert)  // Pass custom alert function
    );
};

    const makeaction = value => {
        if (value) {
            setRecap(true);
        } else {
            setRecap(false);
        }
    };

    useScript("member/login/vendor/jquery/jquery-3.2.1.min.js");
    useScript("member/login/vendor/animsition/js/animsition.min.js");
    useScript("member/login/vendor/bootstrap/js/popper.js");
    useScript("member/login/vendor/bootstrap/js/bootstrap.min.js");
    useScript("member/login/vendor/countdowntime/countdowntime.js");
    useScript("member/login/js/main.js");
    useScript("member/coop/librarys/bootstrap/js/bootstrap.min.js");
    useScript("member/coop/librarys/bootstrap/js/bootstrap-notify.min.js");

    return (
        <LoadingOverlay
            active={authentication.loggingIn}
            spinner
            text="Loading ..."
        >
            <Helmet>
                <link
                    rel="stylesheet"
                    href="info/html/frontend/font/style.css"
                />
                <link
                    rel="stylesheet"
                    href="member/login/vendor/bootstrap/css/bootstrap.min.css"
                />
                <link
                    rel="stylesheet"
                    href="member/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css"
                />
                <link
                    rel="stylesheet"
                    href="member/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css"
                />
                <link
                    rel="stylesheet"
                    href="member/login/vendor/animate/animate.css"
                />
                <link
                    rel="stylesheet"
                    href="member/login/vendor/css-hamburgers/hamburgers.min.css"
                />
                <link
                    rel="stylesheet"
                    href="member/login/vendor/animsition/css/animsition.min.css"
                />
                <link
                    rel="stylesheet"
                    href="member/login/vendor/daterangepicker/daterangepicker.css"
                />
                <link rel="stylesheet" href="member/login/css/util.css" />
                <link rel="stylesheet" href="member/login/css/main.css" />
                <link
                    rel="stylesheet"
                    href="https://fonts.googleapis.com/css?family=Kanit&subset=thai"
                />
                <link
                    rel="stylesheet"
                    href="member/coop/librarys/font-awesome/css/font-awesome.min.css"
                />
                <link
                    rel="stylesheet"
                    href="member/coop/librarys/bootstrap/css/bootstrap.min.css"
                />
                <link
                    rel="stylesheet"
                    href="member/coop/librarys/bootstrap/css/bootstrap-theme.min.css"
                />
            </Helmet>
            <div className="limiter">
                <div className="container-login100">
                    <div className="wrap-login100 p-l-85 p-r-85 p-t-30 p-b-30">
                        <form
                            className="login100-form validate-form flex-sb flex-w"
                            name="form1"
                            method="post"
                            onSubmit={handleSubmit(onSubmit)}
                            autoComplete="off"
                        >
                            <div className="container">
                                <div className="col-md-12">
                                    <div className="row">
                                        <div
                                            className="col-md-3 col-xs-3 "
                                            id="logon-header"
                                        >
                                            <span
                                                id="logon-header-bar"
                                                className="glyphicon glyphicon-folder-open login100-form-title p-b-32 "
                                                style={{
                                                    color: "#009688",
                                                    fontSize: 55
                                                }}
                                            />
                                        </div>
                                        <div className="col-md-9 col-xs-9 fa-4x">
                                            <h2
                                                style={{
                                                    marginTop: "-5px",
                                                    marginLeft: "-15px"
                                                }}
                                            >
                                                สหกรณ์ออมทรัพย์
                                            </h2>
                                            <h4
                                                style={{
                                                    marginTop: "-5px",
                                                    marginLeft: "-15px",
                                                    color: "#009688"
                                                }}
                                            >
                                                สหกรณ์ออมทรัพย์ครูชุมพร จำกัด
                                            </h4>
                                            <h6
                                                style={{
                                                    marginTop: "-5px",
                                                    marginLeft: "-15px"
                                                }}
                                            >
                                                ระบบตรวจสอบข้อมูลสมาชิก
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span className="txt2 p-b-11">
                                <h4>ทะเบียนสมาชิก</h4>
                            </span>
                            {/* กรุณากรอกหมายเลขสมาชิกให้ครบทุกหลัก */}
                            <div
                                className="wrap-input100 validate-input m-b-36"
                                data-validate="กรุณาระบุทะเบียนสมาชิก"
                                style={{ marginBottom: "1%" }}
                            >
                                <input
                                    className="input100"
                                    type="text"
                                    name="membership_no"
                                    id="membership_no"
                                    maxLength={6}
                                    placeholder="กรุณากรอกหมายเลขสมาชิก"
                                    onKeyPress={e => isInputNumber(e)}
                                    onBlur={e => Wordcount(e)}
                                    ref={register({ required: true })}
                                />
                                <span className="focus-input100" />
                            </div>
                            <div>
                                <span className="txt2 p-b-11">
                                    กรุณากรอกหมายเลขสมาชิกให้ครบ 5 หลัก เช่น
                                    01234
                                </span>
                            </div>
                            {/* <p> */}
                            <div style={{ marginTop: "15%" }} />
                            {/* <span class="txt2 p-b-11">
                                <h4 >รหัสผ่าน</h4>
                            </span>	 */}
                            {/* <p>.
                            <p>ขึ้นบรรทัดไหม่ */}
                            <div
                                style={{
                                    marginTop: "0%",
                                    marginRight: "50%",
                                    marginBottom: "4.5%"
                                }}
                            >
                                <span className="txt2 p-b-11">
                                    <h4>รหัสผ่าน</h4>
                                </span>
                            </div>
                            <div
                                className="wrap-input100 validate-input m-b-12"
                                data-validate="กรุณาใส่รหัสผ่าน"
                            >
                                <span className="btn-show-pass">
                                    <i className="fa fa-eye" />
                                </span>
                                <input
                                    className="input100"
                                    type="password"
                                    name="mem_password"
                                    id="mem_password"
                                    placeholder="กรุณาระบุรหัสผ่าน"
                                    ref={register({ required: true })}
                                />
                                <span className="focus-input100" />
                            </div>
                            <div className="m-b-12">
                                <input
                                    className=""
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    ref={register}
                                />
                                <i> </i> จำรหัสผ่าน
                                {/* <input type="checkbox" name="remember" checked> */}
                                <span className="focus-input100" />
                            </div>
                            <div
                                className="m-b-12"
                                style={{
                                    width: "100%",
                                    display: "flex",
                                    justifyContent: "center"
                                }}
                            >
                                {/* <div className="g-recaptcha" data-callback={() => makeaction()} data-sitekey="6LeA3d4UAAAAADQBPZ55L69V-kAFh5UDWAfdC5mo" /> */}
                                {/* <ReCAPTCHA
                                    sitekey="6LernboZAAAAAExgkHU18deimtP_6zrmgrKGaV5M"
                                    hl="th"
                                    ref={reCap}
                                    onChange={makeaction}
                                /> */}
                            </div>
                            {/* </p> */}
                            <div className="flex-sb-m w-full p-b-30">
                                <div>
                                    <Link to={`/register`} className="txt3">
                                        <h4>ลงทะเบียน</h4>
                                    </Link>
                                </div>
                                <div>
                                    <Link to={`/forget`} className="txt3">
                                        <h4>ลืมรหัสผ่าน ?</h4>
                                    </Link>
                                </div>
                            </div>
                            <div
                                className="container-login100-form-btn"
                                style={{ justifyContent: "center" }}
                            >
                                <button
                                    type="submit"
                                    className="login100-form-btn"
                                    name="Submit"
                                    id="submit"
                                >
                                    {" "}
                                    เข้าสู่ระบบ{" "}
                                </button>
                            </div>
                            <div className="flex-sb-m w-full p-t-20">
                                <div></div>
                                <div>
                                    <a href="https://ctscc.or.th" target="_self">
                                        <div className="txt3">
                                            <h4>
                                                {" "}
                                                <i className="fa  fa-reply" />
                                                &nbsp; กลับหน้าหลัก
                                            </h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </LoadingOverlay>
    );
};

export default withRouter(Memlogin);
