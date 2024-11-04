import React, { useEffect, Fragment } from "react";
import { Link } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";

import { feeddataActions } from "../../actions";
import { convert_to_Thaidatetime } from "../../../helpers";
import Services from "../../services/services";

const Board = () => {
    const dispatch = useDispatch();
    const feedData = useSelector(state => state.feedData);
    const authentication = useSelector(state => state.authentication);

    const service = new Services();

    useEffect(() => {
        async function feedData() {
            await dispatch(feeddataActions.feedData(`/api/info/board`));
        }
        feedData();
    }, [dispatch]);

    const Board_del = async id => {
        var conf = confirm("ยืนยันการลบ กระทู้");

        if (conf == true) {
            await service
                .API(`/api/info/board_del/${id}`, {
                    method: "GET"
                })
                .then(data => {
                    if (data.rc_code == "1") {
                        dispatch(feeddataActions.feedData(`/api/info/board`));
                    }
                });
        }
    };

    return (
        <Fragment>
            <div className="list-type">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <h2 className="title">กระดานข่าว</h2>
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
                                    <Link to={`/board`} className="active">
                                        กระดานข่าว
                                    </Link>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div className="content-inner container">
                <div className="row">
                    <div className="col-md-12">
                        {(feedData.fetchSuccess &&
                            feedData.data.is_admin == true) ||
                        authentication.loggedIn == true ? (
                            <div className="datatable-dashv1-list custom-datatable-overright">
                                <div className="modal-bootstrap modal-login-form pull-center">
                                    <div className="btnadd pull-center">
                                        <Link
                                            to={`/boardPost`}
                                            className="btn btn-success btn-lg"
                                        >
                                            ตั้งกระทู้ใหม่
                                        </Link>
                                    </div>
                                </div>
                                <table className="table" width="100%" style={{ marginTop : 10 }}>
                                    <thead>
                                        <tr>
                                            <th
                                                className="text-center"
                                                width="10%"
                                            >
                                                ลำดับ
                                            </th>
                                            <th width="45%">เรื่อง</th>
                                            <th width="25%">โดย</th>
                                            <th
                                                className="text-center"
                                                width="15%"
                                            >
                                                <i className="fa fa-clock-o" />
                                                &nbsp;วันที่
                                            </th>
                                            
                                            {feedData.fetchSuccess && feedData.data.is_admin == true ? <th width="5%" /> : '' }
                                            {/* {console.log('test',feedData.fetchSuccess && feedData.data.is_admin == false && authentication.loggedIn == true)} */}
                                            {/* { console.log( 'test1',authentication.user.member.MEMBERSHIP_NO) } */}
                                            {/* {console.log('test2',parseInt(feedData.data.board && feedData.data.board.data[0].membership_no) )} */}
                                            {feedData.fetchSuccess && feedData.data.is_admin == false && authentication.loggedIn == true ? <th width="5%" /> : '' }
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {feedData.data.board &&
                                            feedData.data.board.data &&
                                            feedData.data.board.data.map(
                                                (val, i) => {
                                                    return (
                                                        <tr key={i}>
                                                            <td className="text-center">
                                                                {" "}
                                                                [ {val.No} ]
                                                            </td>
                                                            <td>
                                                                <Link
                                                                    to={`/boardShow/${val.No}`}
                                                                >
                                                                    {val
                                                                        .Question
                                                                        .length >
                                                                    80
                                                                        ? `${val.Question.substr(
                                                                              80
                                                                          )} ...`
                                                                        : val.Question}
                                                                </Link>
                                                                <font
                                                                    size={2}
                                                                    color="gray"
                                                                >
                                                                    <strong>
                                                                        <i className="fa fa-caret-right" />{" "}
                                                                        [{" "}
                                                                        <i className="fa fa-eye" />
                                                                        {
                                                                            val.pageview
                                                                        }{" "}
                                                                        ] [
                                                                        ตอบกระทู้{" "}
                                                                        {
                                                                            val.CountAnser
                                                                        }{" "}
                                                                        ]
                                                                    </strong>
                                                                </font>
                                                            </td>
                                                            <td>{val.Name}</td>
                                                            <td className="text-center">
                                                                {convert_to_Thaidatetime(
                                                                    val.Date
                                                                )}
                                                            </td>
                                                            {feedData.data
                                                                .is_admin ==
                                                                true && (
                                                                <td className="text-center">
                                                                    <button
                                                                        onClick={() =>
                                                                            Board_del(
                                                                                val.No
                                                                            )
                                                                        }
                                                                        className="btn text-danger"
                                                                    >
                                                                        ลบ
                                                                    </button>
                                                                </td>
                                                            )}
                                                            {!feedData.data.is_admin &&
                                                                (parseInt(val.membership_no) == authentication.user.member.MEMBERSHIP_NO) ? (
                                                                    
                                                                <td className="text-center">
                                                                    <button
                                                                        onClick={() =>
                                                                            Board_del(
                                                                                val.No
                                                                            )
                                                                        }
                                                                        className="btn text-danger"
                                                                    >
                                                                        ลบ
                                                                    </button>
                                                                </td>
                                                                ) : ''
                                                            }
                                                        </tr>
                                                    );
                                                }
                                            )}
                                    </tbody>
                                </table>
                            </div>
                        ) : (
                            <Fragment>
                                <hr />
                                <h1 className="text-center">
                                    ร่วมแสดงความคิดเห็น
                                </h1>
                                <Link to={`/member/logon`}>
                                    <h2 className="text-center">
                                        <i className="fa fa-lock" />{" "}
                                        กรุณาล็อกอินก่อนแสดงความคิดเห็น
                                    </h2>
                                </Link>
                                <a href="/adminlogon">
                                    {" "}
                                    <i className="fa fa-arrow-right" />{" "}
                                    สำหรับเข้าสู่ระบบ Admin
                                </a>
                                <hr />
                            </Fragment>
                        )}
                    </div>
                </div>
            </div>
        </Fragment>
    );
};

export default Board;
