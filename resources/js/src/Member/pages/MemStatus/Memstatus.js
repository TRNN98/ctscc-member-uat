import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";

import { feedmemdataActions } from "../../actions";
import { Skeleton } from "@material-ui/lab";
import MemStatusSkeleton from "../Skeleton/MemStatus";
import ImgProfile from "./ImgProfile";

function Memstatus() {
    const dispatch = useDispatch();
    const feedMemData = useSelector(state => state.feedMemData);

    const [loading, setLoading] = useState(true);

    useEffect(() => {
        async function feedData() {
            await dispatch(
                feedmemdataActions.feedDataPost(`/api/member/member_status`)
            );
        }

        feedData();
    }, []);

    useEffect(() => {
        if (feedMemData.fetchSuccess) {
            setLoading(false);
        }
        return async function cleanup() {
            await setLoading(true);
        };
    }, [feedMemData.fetchSuccess]);

    const number_format = val => {
        var nf = new Intl.NumberFormat();
        // console.log(val);
        // console.log(nf.format(val));
        return nf.format(val);
    };

    return (
        <>
            {loading && <MemStatusSkeleton />}
            {!loading && (
                <div className="container-fluid">
                    <div className="row">
                        <div className="col-md-6 col-sm-6">
                            <div className="panel panel-info wrimagecard">
                                <div className="panel-heading">
                                    <h3
                                        className="panel-title"
                                        style={{ fontWeight: "bold" }}
                                    >
                                        {feedMemData.fetchSuccess &&
                                            feedMemData.data.data1[0].prename &&
                                            feedMemData.data.data1[0]
                                                .member_name &&
                                            feedMemData.data.data1[0]
                                                .member_surname &&
                                            `${feedMemData.data.data1[0].prename}  ${feedMemData.data.data1[0].member_name}  ${feedMemData.data.data1[0].member_surname}`}
                                    </h3>
                                </div>
                                <div className="panel-body">
                                    <div className="row">
                                        <div
                                            className="col-md-3 col-lg-3 "
                                            align="center"
                                        >
                                            {/* <img
                                                alt="User Pic"
                                                id="user_pic"
                                                src="member/images/mem_new.jpg"
                                                className="img-circle img-thumbnail"
                                            /> */}
                                            <ImgProfile/>
                                        </div>
                                        <div className=" col-md-9 col-lg-9 ">
                                            <table className="table table-user-information">
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            className="td-caption"
                                                            style={{
                                                                width: "30%"
                                                            }}
                                                        >
                                                            ทะเบียน:
                                                        </td>
                                                        <td>
                                                            {feedMemData.fetchSuccess &&
                                                                ` ${feedMemData.data.data1[0].membership_no}`}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            บัตร ปปช.:
                                                        </td>
                                                        <td>
                                                            {feedMemData.fetchSuccess &&
                                                                ` ${feedMemData.data.data1[0].id_card}`}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            วันเกิด:
                                                        </td>
                                                        {feedMemData.fetchSuccess && (
                                                            <td
                                                                dangerouslySetInnerHTML={createMarkup(
                                                                    feedMemData
                                                                        .data
                                                                        .date_of_birth
                                                                )}
                                                            ></td>
                                                        )}
                                                    </tr>
                                                    <tr></tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            วันที่เป็นสมาชิก:
                                                        </td>
                                                        {feedMemData.fetchSuccess && (
                                                            <td
                                                                dangerouslySetInnerHTML={createMarkup(
                                                                    feedMemData
                                                                        .data
                                                                        .approve_date
                                                                )}
                                                            ></td>
                                                        )}
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            หน่วยงาน:
                                                        </td>
                                                        <td>
                                                            {feedMemData.fetchSuccess &&
                                                                ` ${feedMemData.data.data1[0].member_group_name}`}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            ตำแหน่ง:
                                                        </td>
                                                        <td>
                                                            {feedMemData.fetchSuccess &&
                                                                ` ${feedMemData.data.data1[0].position_name == null && '-'}`}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            เงินเดือน:
                                                        </td>
                                                        <td>
                                                            {feedMemData.fetchSuccess &&
                                                                ` ${feedMemData.data.salary_amount}`}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            ที่อยู่ปัจจุบัน:
                                                        </td>
                                                        <td rowSpan={2}>
                                                            {feedMemData.fetchSuccess &&
                                                                feedMemData.data
                                                                    .data1[0]
                                                                    .address_present}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div className="col-md-3 col-sm-4">
                                <div className="wrimagecard wrimagecard-topimage">
                                    <Link to={`/deposit`}>
                                        <div
                                            className="wrimagecard-topimage_header"
                                            style={{
                                                backgroundColor:
                                                    "rgba(187, 120, 36, 0.1)"
                                            }}
                                        >
                                            <center>
                                                <i
                                                    className="fa fa-area-chart"
                                                    style={{ color: "#BB7824" }}
                                                />
                                            </center>
                                        </div>
                                        <div className="wrimagecard-topimage_title">
                                            <h4>
                                                <span
                                                    className="td-caption"
                                                    style={{ fontSize: 18 }}
                                                >
                                                    เงินฝาก
                                                </span>
                                                <div
                                                    className="pull-right badge"
                                                    style={{ fontSize: 15 }}
                                                >
                                                    {feedMemData.fetchSuccess &&
                                                        ` ${feedMemData.data.deposit_balance}`}
                                                </div>
                                            </h4>
                                        </div>
                                    </Link>
                                </div>
                            </div>
                            <div className="col-md-3 col-sm-4">
                                <div className="wrimagecard wrimagecard-topimage">
                                    <Link to={`/loan`}>
                                        <div
                                            className="wrimagecard-topimage_header"
                                            style={{
                                                backgroundColor:
                                                    "rgba(22, 160, 133, 0.1)"
                                            }}
                                        >
                                            <center>
                                                <i
                                                    className="fa fa-cubes"
                                                    style={{ color: "#16A085" }}
                                                />
                                            </center>
                                        </div>
                                        <div className="wrimagecard-topimage_title">
                                            <h4>
                                                <span
                                                    className="td-caption"
                                                    style={{ fontSize: 18 }}
                                                >
                                                    เงินกู้
                                                </span>
                                                <div
                                                    className="pull-right badge"
                                                    id="WrControls"
                                                    style={{ fontSize: 15 }}
                                                >
                                                    {feedMemData.fetchSuccess &&
                                                        ` ${feedMemData.data.principal_balance}`}
                                                </div>
                                            </h4>
                                        </div>
                                    </Link>
                                </div>
                            </div>
                            <div className="col-md-3 col-sm-4">
                                <div className="wrimagecard wrimagecard-topimage">
                                    <Link to={`/share`}>
                                        <div
                                            className="wrimagecard-topimage_header"
                                            style={{
                                                backgroundColor:
                                                    "rgba(213, 15, 37, 0.1)"
                                            }}
                                        >
                                            <center>
                                                <i
                                                    className="fa fa-pencil-square-o"
                                                    style={{ color: "#d50f25" }}
                                                >
                                                    {" "}
                                                </i>
                                            </center>
                                        </div>
                                        <div className="wrimagecard-topimage_title">
                                            <h4>
                                                <span
                                                    className="td-caption"
                                                    style={{ fontSize: 18 }}
                                                >
                                                    ทุนเรือนหุ้น
                                                </span>
                                                <div
                                                    className="pull-right badge"
                                                    id="WrForms"
                                                    style={{ fontSize: 15 }}
                                                >
                                                    {feedMemData.fetchSuccess &&
                                                        ` ${number_format(
                                                            feedMemData.data
                                                                .data1[0]
                                                                .share_stock
                                                        )}`}
                                                </div>
                                            </h4>
                                        </div>
                                    </Link>
                                </div>
                            </div>
                            <div className="col-md-3 col-sm-4">
                                <div className="wrimagecard wrimagecard-topimage">
                                    <Link to={`kep`}>
                                        <div
                                            className="wrimagecard-topimage_header"
                                            style={{
                                                backgroundColor:
                                                    "rgba(51, 105, 232, 0.1)"
                                            }}
                                        >
                                            <center>
                                                <i
                                                    className="fa fa-table"
                                                    style={{ color: "#3369e8" }}
                                                >
                                                    {" "}
                                                </i>
                                            </center>
                                        </div>
                                        <div className="wrimagecard-topimage_title">
                                            <h4>
                                                <span
                                                    className="td-caption"
                                                    style={{ fontSize: 18 }}
                                                >
                                                    เรียกเก็บรายเดือน/พิมพ์ใบเสร็จ
                                                </span>
                                                <div
                                                    className="pull-right badge"
                                                    id="WrGridSystem"
                                                />
                                            </h4>
                                        </div>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
}

function createMarkup(html) {
    return { __html: html };
}

export default Memstatus;
