import React, { useEffect, useState } from "react";
import useForm from "react-hook-form";
import { NotificationManager } from "react-notifications";
import { useDispatch, useSelector } from "react-redux";
import { Link } from "react-router-dom";
import { borders, shadows, spacing } from "@material-ui/system";

import {
    createMarkup,
    Wordcount,
    isInputNumber
} from "../../../helpers/functions";

import { userActions } from "../../../Member/actions";
import LoadingOverlay from "react-loading-overlay";
import OwlCarousel from "react-owl-carousel";
import Box from "@material-ui/core/Box";

import PanelCustom from "../Component/PanelCustom";

function RightBar({ data }) {
    const auth = useSelector(store => store.authentication);
    const dispatch = useDispatch();

    const { register, handleSubmit, watch, errors } = useForm();

    const onSubmit = async (data, e) => {
        e.preventDefault();

        await dispatch(
            userActions.login({
                ...data
            })
        );
    };

    useEffect(() => {
        if (errors.membership_no) {
            NotificationManager.error("กรุณากรอก ทะเบียนสมาชิก", "Error", 5000);
        } else if (errors.mem_password) {
            NotificationManager.error("กรุณากรอก รหัสผ่าน", "Error", 5000);
        }
    }, [errors]);
    // ====== Detail รูปประธานกรรมการ ===== //
    const DetailPresident = () => {
        return (
            data.committee && (
                <div>
                    <div className="staff-left" style={{ width: "100%" }}>
                        <div className="staff-left-image">
                            <img
                                className="img-responsive"
                                src={`mediafiles/${data.committee[0].nphoto}`}
                            />
                        </div>
                        <div className="staff-left-detail text-center">
                            {data.committee[0].Question}
                            <br />
                            {data.committee[0].Note}
                        </div>
                    </div>
                </div>
            )
        );
    };

    // ======= Detail Box LogIn ======= //
    const DetailBoxLogIn = () => {
        return auth.loggedIn ? (
            <div>
                <h5>
                    <i
                        className="fa fa-user"
                        style={{
                            fontSize: 26,
                            color: "#f0ad4e"
                        }}
                    />
                    ยินดีต้อนรับ
                    <br />
                    <hr
                        style={{
                            borderTop: "1px solid #cccccc"
                        }}
                    />
                    <b>
                        <u>{`${auth.user.member.PRENAME}${auth.user.member.MEMBER_NAME} ${auth.user.member.MEMBER_SURNAME}`}</u>
                    </b>
                </h5>
                <hr
                    style={{
                        borderTop: "1px solid #cccccc"
                    }}
                />
                <div className="form-group">
                    <Link
                        to="/member/status"
                        className="btn btn-warning btn-lg"
                    >
                        ตรวจสอบข้อมูลสมาชิก
                    </Link>
                </div>
                <div className="form-group">
                    <button
                        type="submit"
                        className="btn btn-danger btn-lg"
                        onClick={() => dispatch(userActions.logout())}
                    >
                        ออกจากระบบ
                    </button>
                </div>
            </div>
        ) : (
            <form onSubmit={handleSubmit(onSubmit)}>
                <h5>
                    <span className="text-danger">
                        <b>**อยู่ในระหว่างทดสอบระบบ**</b>
                    </span>
                </h5>
                <div className="form-group">
                    <input
                        id="membership_no"
                        type="text"
                        autoComplete="username"
                        name="membership_no"
                        className="form-control"
                        placeholder="รหัสเลขสมาชิก"
                        onKeyPress={e => isInputNumber(e)}
                        onBlur={e => Wordcount(e)}
                        maxLength={6}
                        ref={register({
                            required: true
                        })}
                    />
                </div>
                <div className="form-group">
                    <input
                        type="password"
                        autoComplete="current-password"
                        name="mem_password"
                        id="mem_password"
                        className="form-control"
                        placeholder="รหัสผ่าน"
                        ref={register({
                            required: true
                        })}
                    />
                </div>
                <div className="form-group">
                    <input
                        type="submit"
                        className="btn btn-primary form-control"
                        value="เข้าสู่ระบบ"
                    />
                </div>
                <hr/>
                <div className="form-group">
                    <Link to={`/member/register`} className="text-success">
                        <b
                            style={{
                                fontSize: 20,
                                textDecoration: "underline",
                                textDecorationStyle: "double"
                            }}
                        >
                            สมัครสมาชิก
                        </b>
                    </Link>
                    <Link
                        className="pull-right text-danger"
                        to={`/member/forget`}
                    >
                        <b
                            style={{
                                fontSize: 20,
                                textDecoration: "underline",
                                textDecorationStyle: "double"
                            }}
                        >
                            ลืมรหัสผ่าน ?
                        </b>
                    </Link>
                </div>
            </form>
        );
    };

    // ======= Detail Box Rates ======= //
    const DetailBoxRates = () => {
        return (
            <>
                <ul
                    className="nav nav-tabs"
                    role="tablist"
                    id="tab-right"
                    style={{ paddingBottom: "5px" }}
                >
                    <li role="presentation" className="active">
                        <a
                            href="#tabloan"
                            aria-controls="settings"
                            role="tab"
                            data-toggle="tab"
                        >
                            เงินกู้
                        </a>
                    </li>
                    <li role="presentation">
                        <a
                            href="#tabdep"
                            aria-controls="settings"
                            role="tab"
                            data-toggle="tab"
                        >
                            เงินฝาก
                        </a>
                    </li>
                </ul>
                <div className="tab-content">
                    <div
                        role="tabpanel"
                        className="tab-pane  active"
                        id="tabloan"
                    >
                        <div
                            className="right-panel"
                            dangerouslySetInnerHTML={
                                data.loan_rates &&
                                createMarkup(data.loan_rates.Note)
                            }
                        ></div>
                    </div>
                    <div role="tabpanel" className="tab-pane" id="tabdep">
                        <div
                            className="right-panel"
                            dangerouslySetInnerHTML={
                                data.deposit_rates &&
                                createMarkup(data.deposit_rates.Note)
                            }
                        ></div>
                    </div>
                </div>
            </>
        );
    };

    // ======= Detail Box Newspaper ======= //
    const DetailBoxNewspaper = () => {
        return (
            <ul className="box-newspaper">
                <li>
                    <a href="https://www.thairath.co.th/home">ไทยรัฐ</a>
                </li>
                <li>
                    <a href="http://www.dailynews.co.th/">เดลินิวส</a>
                </li>
                <li>
                    <a href="http://www.komchadluek.net/">คม ชัด ลึก</a>
                </li>
                <li>
                    <a href="https://www.khaosod.co.th/home">ข่าวสด</a>
                </li>
                <li>
                    <a href="http://www.bangkokbiznews.com/">กรุงเทพธุรกิจ</a>
                </li>
                <li>
                    <a href="http://www.manager.co.th/">ผู้จัดการ</a>
                </li>
                <li>
                    <a href="http://www.naewna.com/">แนวหน้า</a>
                </li>
                <li>
                    <a href="http://www.siamsport.co.th/">สยามกีฬา</a>
                </li>
                <li>
                    <a href="http://www.mcot.net/">อ.ส.ม.ท.</a>
                </li>
            </ul>
        );
    };

    // ======= Detail Box Counter ======= //
    const DetailBoxCounter = () => {
        return (
            <div className="area-counter text-center">
                <p>ทั้งหมด</p>
                {data.allVisitor &&
                    data.allVisitor.map((val, i) => (
                        <>
                            <Box
                                boxShadow={3}
                                border={2}
                                borderColor={"#e59008"}
                                borderRadius={4}
                                component={"span"}
                                style={{ width: width / 6 }}
                            >
                                {val}
                            </Box>{" "}
                        </>
                    ))}

                <hr />

                <p>วันนี้</p>
                {data.todayVisitor &&
                    data.todayVisitor.map((val, i) => (
                        <>
                            <Box
                                boxShadow={3}
                                border={2}
                                borderColor={"#e59008"}
                                borderRadius={4}
                                component={"span"}
                                style={{ width: width / 6 }}
                            >
                                {val}
                            </Box>{" "}
                        </>
                    ))}
            </div>
        );
    };
    // == get width
    const [width, setWidth] = useState(0);
    useEffect(() => {
        setWidth($(".area-counter").width());
    }, [$(".area-counter")]);

    // ====== Set option ======//

    const BoxPresident = {
        title: "ประธานกรรมการ",
        detail: DetailPresident()
    };

    const BoxLogIn = {
        title: "ระบบสมาชิกออนไลน์",
        detail: DetailBoxLogIn()
    };

    const BoxRates = {
        title: "อัตราดอกเบี้ย",
        detail: DetailBoxRates()
    };

    const BoxNewspaper = {
        title: "Newspaper",
        detail: DetailBoxNewspaper()
    };

    const BoxCounter = {
        title: "จำนวนผู้เยี่ยมชม",
        detail: DetailBoxCounter()
    };

    return (
        <div className="col-md-3 RightBar">
            <div className="right-panel">
                <img src={"info/assets/index/president.png"} width={"100%"} />
            </div>

            <div className="right-panel">
                <h2 className="header-title"> เมนูลัด </h2>
                <LoadingOverlay active={auth.loggingIn}>
                    <div
                        className="interest-box-right"
                        style={{ padding: "5px 12px" }}
                    >
                        {DetailBoxLogIn()}
                    </div>
                </LoadingOverlay>
            </div>

            <div className="right-panel">
                <h2 className="header-title"> อัตราดอกเบี้ย </h2>
                {DetailBoxRates()}
            </div>

            <div className="right-panel">
                <h2 className="header-title"> ติดต่อเรา </h2>
                <div
                    className="text-center"
                    style={{
                        border: "2px solid #e6e4e4ee",
                        padding: "7px 0"
                    }}
                >
                    <iframe
                        src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fhealthcoop%2F&tabs=timeline&width=250&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=false&appId=380868046155502"
                        width={250}
                        height={350}
                        style={{ border: "none", overflow: "hidden" }}
                        scrolling="no"
                        frameBorder={0}
                        allowTransparency="true"
                        allow="encrypted-media"
                    />
                </div>
            </div>

            <div className="right-panel">
                <a href="http://line.me/ti/p/~@healthcoop.pb" target="_blank">
                    <img
                        src={"info/assets/index/add_line.png"}
                        width={"100%"}
                        style={{ marginBottom: 20 }}
                    />
                </a>
            </div>

            <div className="right-panel box-newspaper">
                <h2 className="header-title">Newspaper</h2>
                {DetailBoxNewspaper()}
            </div>

            {/* <PanelCustom props={BoxPresident} titleCenter={true} />

            <PanelCustom props={BoxMng} titleCenter={true} />

            <PanelCustom props={BoxOfficer} titleCenter={true} />

            <PanelCustom props={BoxRates} titleCenter={true} />

            <PanelCustom props={BoxNewspaper} titleCenter={true} />

            <PanelCustom props={BoxCounter} titleCenter={true}/> */}

            {/* <div className="right-panel">
                <div className="panel panel-default panel-custom">
                    <div class="panel-heading">
                        <h3
                            style={{ margin: "5px", fontWeight: "bold" }}
                            className="text-center"
                        >
                            การโอนเงิน
                        </h3>
                    </div>
                    <div
                        class="panel-body"
                        dangerouslySetInnerHTML={
                            data.bank_acc && createMarkup(data.bank_acc.Note)
                        }
                    ></div>
                </div>
            </div> */}
            {/* <div className="right-panel">
                <br />
                <h4 className="header-title" style={{ fontWeight: "bold" }}>
                    ติดตามเรา
                </h4>
                <div
                    className="fb-group"
                    data-href="https://www.facebook.com/groups/352700644815610/"
                    data-width={250}
                    data-show-social-context="true"
                    data-show-metadata="true"
                ></div>
            </div> */}
        </div>
    );
}

export default RightBar;
