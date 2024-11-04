import React, { useEffect, Fragment } from "react";
import { useParams, Link, useHistory } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import useForm from "react-hook-form";

import { createMarkup, convert_to_Thaidate } from "../../../helpers";
import { feeddataActions } from "../../actions";
import Services from "../../services/services";

const Board_show = () => {
    const dispatch = useDispatch();
    const feedData = useSelector(state => state.feedData);
    const authentication = useSelector(state => state.authentication);
    let { topicId } = useParams();
    const history = useHistory();
    const { register, handleSubmit } = useForm();

    const service = new Services();

    useEffect(() => {
        if (topicId != "") {
            async function feedData() {
                await dispatch(
                    feeddataActions.feedData(`/api/info/board_show/${topicId}`)
                );
            }

            feedData();
        }
    }, [topicId]);

    const onSubmit = async (data, e) => {
        e.preventDefault();
        try {
            await dispatch(
                feeddataActions.feedDataPost("/api/info/board_ans", {
                    QNo: topicId,
                    QName: data.QName,
                    QNote: data.QNote
                })
            );
        } catch (error) {
            console.log(error);

            if (feedData.fetchFailure) {
                await setTimeout(history.push("/board"), 100);
            }
        } finally {
            await dispatch(
                feeddataActions.feedData(`/api/info/board_show/${topicId}`)
            );
        }
        await e.target.reset();
    };

    $(function() {
        if (feedData.fetchSuccess && feedData.data.board_detail) {
            $(".board_detail_ans").on(
                "click",
                "#btndel-board-ans",
                async function() {
                    var box = $(this)
                        .parent()
                        .parent();
                    var id = $(this)
                        .parent()
                        .find("span")
                        .text();
                    var conf = confirm("แน่ใจว่าจะลบ ความคิดเห็น ?");

                    if (conf == true) {
                        await service
                            .API(`/api/info/board_ans_del/${id}`, {
                                method: "GET"
                            })
                            .then(data => {
                                if (data.rc_code == "1") {
                                    dispatch(
                                        feeddataActions.feedData(
                                            `/api/info/board_show/${topicId}`
                                        )
                                    );
                                }
                            });
                    }
                }
            );
        }
    });

    return (
        <Fragment>
            <div className="list-type">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <h2 className="title">รายละเอียดข่าว</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div className="container">
                <div className="row">
                    <div className="col-md-12">
                        <div className="page-breadcrumb">
                            <ol
                                className="breadcrumb"
                                style={{
                                    margin: "10px 0",
                                    backgroundColor: "#FFF",
                                    padding: "8px 0",
                                    color: "#838384"
                                }}
                            >
                                <li>
                                    <Link to="/home">หน้าแรก</Link>
                                </li>
                                <li>
                                    <Link to={`/board`}>กระดานข่าว</Link>
                                </li>
                                {feedData.fetchSuccess &&
                                    feedData.data.showboard && (
                                        <li>
                                            <Link
                                                to={`/boardShow/${feedData.data
                                                    .showboard.No &&
                                                    feedData.data.showboard
                                                        .No}`}
                                                className="active"
                                            >
                                                {feedData.data.showboard
                                                    .Question &&
                                                    feedData.data.showboard
                                                        .Question}
                                            </Link>
                                        </li>
                                    )}
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div className="content-inner container">
                <div className="row">
                    <div className="col-md-12">
                        {feedData.fetchSuccess && feedData.data.showboard && (
                            <div
                                className="boxdetail"
                                style={{
                                    padding: 45,
                                    backgroundColor: "#dd702600",
                                    boxShadow: "4px 3px 10px 0px #03030361"
                                }}
                            >
                                <h2>
                                    <b>เรื่อง : </b>
                                    {feedData.data.showboard.Question &&
                                        feedData.data.showboard.Question}
                                </h2>
                                <br />
                                <h4 dangerouslySetInnerHTML={feedData.data.showboard.Note && createMarkup(feedData.data.showboard.Note)}>
                                    {/* {feedData.data.showboard.Note &&
                                        feedData.data.showboard.Note} */}
                                </h4>
                                <hr style={{ border: "1px solid gray" }} />
                                <h6>
                                    {" "}
                                    โดย :{" "}
                                    {feedData.data.showboard.Name &&
                                        feedData.data.showboard.Name}
                                </h6>
                                <h6>
                                    {" "}
                                    <i className="fa fa-clock-o" />
                                    &nbsp;เมื่อวันที่ :{" "}
                                    {feedData.data.showboard.Date &&
                                        convert_to_Thaidate(
                                            feedData.data.showboard.Date,
                                            "LLL",
                                            "YYYY-MM-DD HH:mm:ss"
                                        )}
                                </h6>
                            </div>
                        )}
                    </div>
                    <style
                        dangerouslySetInnerHTML={{
                            __html:
                                "\n                #btndel-board-ans:hover{\n                    color:red !important;\n                }\n            "
                        }}
                    />

                    {(feedData.fetchSuccess &&
                        feedData.data.is_admin == true) ||
                    authentication.loggedIn == true ? (
                        <Fragment>
                            <div
                                className="col-md-12"
                                style={{ marginTop: 50 }}
                                dangerouslySetInnerHTML={createMarkup(
                                    feedData.data.board_detail
                                )}
                            ></div>
                            <div className="col-md-8" style={{ marginTop: 50 }}>
                                <h3>ร่วมแสดงความคิดเห็น</h3>
                                <form onSubmit={handleSubmit(onSubmit)}>
                                    <div className="board_ans">
                                        <div className="form-group">
                                            <textarea
                                                name="QNote"
                                                className="form-control"
                                                cols={120}
                                                rows={8}
                                                ref={register}
                                                required
                                            />
                                        </div>
                                        <div className="form-group">
                                            <label>ชื่อ :</label>
                                            {feedData.data.is_admin == true && (
                                                <input
                                                    type="text"
                                                    name="QName"
                                                    className="form-control"
                                                    defaultValue="ADMIN"
                                                    ref={register}
                                                    required
                                                />
                                            )}
                                            {authentication.loggedIn == true &&
                                                feedData.data.is_admin ==
                                                    false && (
                                                    <input
                                                        type="text"
                                                        name="QName"
                                                        className="form-control"
                                                        defaultValue={`${authentication.user.member.PRENAME}${authentication.user.member.MEMBER_NAME} ${authentication.user.member.MEMBER_SURNAME}`}
                                                        ref={register}
                                                        required
                                                    />
                                                )}
                                        </div>
                                        <div className="form-group">
                                            <button
                                                type="submit"
                                                className="btn btn-lg btn-warning"
                                            >
                                                ส่งความคิดเห็น
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </Fragment>
                    ) : (
                        (feedData.data.is_admin != null &&
                            feedData.data.is_admin == false) ||
                        (authentication.loggedIn == false && (
                            // null
                            <div
                                className="col-md-8 text-right"
                                style={{ marginTop: 50 }}
                            >
                                <h1>ร่วมแสดงความคิดเห็น</h1>
                                <Link to={`/member/logon`}>
                                    <h2>
                                        <i className="fa fa-lock" />{" "}
                                        กรุณาล็อกอินก่อนแสดงความคิดเห็น
                                    </h2>
                                </Link>
                            </div>
                        ))
                    )}
                </div>
            </div>
        </Fragment>
    );
};

export default Board_show;
