import React from "react";
import { Link } from "react-router-dom";
import OwlCarousel from "react-owl-carousel";
import PanelCustom from "../Component/PanelCustom";

import { convert_to_Thaidate } from "../../../helpers";
import LoadingOverlay from "react-loading-overlay";
import { useDispatch, useSelector } from "react-redux";
import { userActions } from "../../../Member/actions";
import useForm from "react-hook-form";

function Block1({ data }) {
    // ============= Detail Box LogIn ============= //
    // ============ ============== ================ //
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
    // ============
    // ============
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
                <h5 style={{ fontSize: 16 }}> ระบบสมาชิก </h5>
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
                <div className="form-group">
                    <Link to={`/member/register`} className="text-success">
                        <b>สมัครสมาชิก</b>
                    </Link>
                    <Link
                        className="pull-right text-danger"
                        to={`/member/forget`}
                    >
                        <b>ลืมรหัสผ่าน ?</b>
                    </Link>
                </div>
            </form>
        );
    };
    // ============
    // ============
    // =====
    // =====

    // ============ Detail Block 1 ================ //
    // ============ ============== ================ //
    const DetailBlock1 = () => {
        return (
            <div className="row">
                <div className="col-md-12">
                    <h2 className="header-title">ข่าวประชาสัมพันธ์</h2>
                    <hr />
                </div>
                <div className="col-md-9">
                    {data.h_news_relations && (
                        <OwlCarousel
                            className="slide-full2 owl-theme"
                            items={1}
                            loop
                            center
                            autoplaySpeed={300}
                            dotsSpeed={400}
                            autoplay
                            autoplayHoverPause
                            mergeFit={false}
                            margin={10}
                            dots
                            dotsClass={"owl-dots"}
                            animateIn={"fadeIn"}
                            animateOut={"fadeOut"}
                            navText={[
                                "<i class='fa fa-angle-left'></i>",
                                "<i class='fa fa-angle-right'></i>"
                            ]}
                        >
                            {data.h_news_relations.map((val, i) =>
                                val.nlink == "uselink" ? (
                                    <a href={`${val.nlink}`} target="_blank">
                                        <div className="item" key={i}>
                                            <img
                                                style={{ maxWidth: "100%" }}
                                                src={
                                                    val.nphoto == ""
                                                        ? `mediafiles/images/news1.png?${Math.random() *
                                                              100}`
                                                        : `mediafiles/${val.nphoto}`
                                                }
                                            />
                                        </div>
                                    </a>
                                ) : (
                                    <Link to={`/show/${val.No}`}>
                                        <div className="item" key={i}>
                                            <img
                                                style={{ maxWidth: "100%" }}
                                                src={
                                                    val.nphoto == ""
                                                        ? `mediafiles/images/news1.png?${Math.random() *
                                                              100}`
                                                        : `mediafiles/${val.nphoto}`
                                                }
                                            />
                                            <span>{val.Question}</span>
                                        </div>
                                    </Link>
                                )
                            )}
                        </OwlCarousel>
                    )}
                </div>
                <div className="col-md-3">
                    {data.h2_news_relations &&
                        data.h2_news_relations.map((val, i) =>
                            val.nlink == "uselink" ? (
                                <div className="box_h2">
                                    <a
                                        href={`${val.nlink}`}
                                        className=""
                                        target="blank"
                                    >
                                        <img
                                            className="img-responsive s1"
                                            src={
                                                val.nphoto == ""
                                                    ? `mediafiles/images/news1.png`
                                                    : `mediafiles/${val.nphoto}`
                                            }
                                        />
                                    </a>
                                    <h6 className="colorBlue fb">
                                        <a
                                            to={`${val.nlink}`}
                                            style={{
                                                "line-height": "24px"
                                            }}
                                        >
                                            {val.Question.length > 55
                                                ? val.Question.substr(0, 50) +
                                                  "..... "
                                                : val.Question}
                                        </a>
                                    </h6>
                                </div>
                            ) : (
                                <div className="box_h2">
                                    <Link to={`/show/${val.No}`} className="">
                                        <img
                                            className="img-responsive s1"
                                            src={
                                                val.nphoto == ""
                                                    ? `mediafiles/images/news1.png`
                                                    : `mediafiles/${val.nphoto}`
                                            }
                                        />
                                    </Link>
                                    <h6 className="colorBlue fb">
                                        <Link
                                            to={`/show/${val.No}`}
                                            style={{
                                                "line-height": "24px"
                                            }}
                                        >
                                            {val.Question.length > 55
                                                ? val.Question.substr(0, 50) +
                                                  "..... "
                                                : val.Question}
                                        </Link>
                                    </h6>
                                </div>
                            )
                        )}
                </div>
                {/* list news old */}
                <div
                    className="col-sm-12 text-left"
                    style={{ margin: "20px 0" }}
                >
                    <div
                        className="item"
                        style={{
                            backgroundColor: "#EEEEEE",
                            padding: "12px 22px 15px 22px"
                        }}
                    >
                        <ul style={{ listStyle: "none", padding: 0 }}>
                            {data.news_relations &&
                                data.news_relations.map((val, i) => (
                                    <li style={{ padding: "12px 0px" }} key={i}>
                                        <i
                                            className="fa fa-hand-o-right"
                                            style={{ fontSize: 16 }}
                                        />
                                        &nbsp;
                                        <font className="colorBlue fb">
                                            {convert_to_Thaidate(
                                                val.Date,
                                                "ll",
                                                "YYYY-MM-DD HH:mm:ss"
                                            )}
                                            &nbsp;
                                            {val.nlink == "uselink" ? (
                                                <a
                                                    href={`${val.nlink}`}
                                                    target="blank"
                                                    className="underline"
                                                >
                                                    {val.Question.length > 85
                                                        ? val.Question.substr(
                                                              0,
                                                              85
                                                          ) + "..... "
                                                        : val.Question}
                                                </a>
                                            ) : (
                                                <Link
                                                    to={`/show/${val.No}`}
                                                    className="underline"
                                                >
                                                    {val.Question.length > 85
                                                        ? val.Question.substr(
                                                              0,
                                                              85
                                                          ) + "..... "
                                                        : val.Question}
                                                </Link>
                                            )}
                                        </font>
                                        <font color="tomato" className="fb">
                                            {` [อ่าน ${val.pageview} คน]`}
                                        </font>
                                    </li>
                                ))}
                        </ul>
                        <div className="text-right">
                            <Link
                                className="news-view-all"
                                to={`/list/news_relations`}
                            >
                                <b>+ ดูทั้งหมด</b>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        );
    };

    // =============== Set option ================= //
    // ============================================ //
    const option = {
        title: "ข่าวประชาสัมพันธ์",
        detail: DetailBlock1()
    };
    const BoxLogIn = {
        title: "ระบบสมาชิกออนไลน์",
        detail: DetailBoxLogIn()
    };

    // =================== Render ================ //
    // =================== ====== ================ //
    return (
        <div className="row Block1">
            <div className="col-sm-12">
                <LoadingOverlay active={auth.loggingIn}>
                    <PanelCustom
                        props={BoxLogIn}
                        titleCenter={true}
                        hiddenMd={true}
                        hiddenLg={true}
                    />
                </LoadingOverlay>
            </div>
            <div className="col-sm-12">
                {/* <PanelCustom props={option} /> */}
                {DetailBlock1()}
            </div>
        </div>
    );
}

export default Block1;
