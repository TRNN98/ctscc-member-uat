import React, { Fragment, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useParams } from "react-router-dom";
import useForm from "react-hook-form";
import Pagination from "rc-pagination";

import { feedMemDepStatementActions } from "../../actions";
import { number_format, convert_to_Thaidate } from "../../../helpers";

const MemdepStatement = () => {
    const dispatch = useDispatch();
    const feedMemDepStatement = useSelector(state => state.feedMemDepStatement);
    const { register, handleSubmit, watch, errors, setValue } = useForm();
    let { statement } = useParams();

    useEffect(() => {
        if (statement != "") {
            async function feedData() {
                await dispatch(
                    feedMemDepStatementActions.feedDataPost(
                        `/api/member/member_dep_statement/${statement}`
                    )
                );
            }

            feedData();
        }

        $(".datepicker").datepicker({
            format: "dd/mm/yyyy",
            todayBtn: true,
            language: "th", //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true //Set เป็นปี พ.ศ.
        });

        $("#menu_dep").addClass("active");
        return () => {
            $("#menu_dep").removeClass("active");
        };
    }, [statement]);

    const onSubmit = async (data, e) => {
        e.preventDefault();

        const body = {
            inputdatepickerstart: data.inputdatepickerstart,
            inputdatepickerend: data.inputdatepickerend
        };
        await dispatch(
            feedMemDepStatementActions.feedDataPost(
                `/api/member/member_dep_statement/${statement}`,
                body
            )
        );
    };

    const OnchangePagination = async (currentPage, pageSize) => {
        if (
            watch("inputdatepickerstart") == "" &&
            watch("inputdatepickerend") == ""
        ) {
            await dispatch(
                feedMemDepStatementActions.feedDataPost(
                    `/api/member/member_dep_statement/${statement}?page=${currentPage}`
                )
            );
        } else {
            const body = {
                inputdatepickerstart: watch("inputdatepickerstart"),
                inputdatepickerend: watch("inputdatepickerend")
            };
            await dispatch(
                feedMemDepStatementActions.feedDataPost(
                    `/api/member/member_dep_statement/${statement}?page=${currentPage}`,
                    body
                )
            );
        }
    };

    const cleardatepick = async () => {
        if (
            watch("inputdatepickerstart") != "" &&
            watch("inputdatepickerend") != ""
        ) {
            setValue("inputdatepickerstart", "");
            setValue("inputdatepickerend", "");

            await dispatch(
                feedMemDepStatementActions.feedDataPost(
                    `/api/member/member_dep_statement/${statement}`
                )
            );
        }
    };

    // $(document).ready(function() {
    //     $("#menu_dep").addClass("active");
    // });

    return (
        <div className="container-fluid">
            <div
                className="panel panel-info container wrimagecard"
                style={{
                    paddingLeft: 0,
                    paddingRight: 0,
                    boxShadow: "12px 15px 20px 0px rgba(46,61,73,0.15)"
                }}
            >
                <div className="panel-heading">
                    <h3 className="panel-title" style={{ fontWeight: "bold" }}>
                        ประเภทเงินฝาก :{" "}
                        {feedMemDepStatement.fetchSuccess &&
                            feedMemDepStatement.data.DepStatementHead &&
                            feedMemDepStatement.data.DepStatementHead
                                .deposit_name}
                    </h3>
                </div>
                <div clas="panel-body" style={{ marginTop: 10 }}>
                    <div
                        className="col-md-12 col-sm-12 col-xs-12"
                        style={{ paddingBottom: 30 }}
                    >
                        <div className="wrimagecard-topimage_title">
                            <div className="row">
                                <div className="col-md-2 col-sm-12 col-xs-12">
                                    <div className="wrimagecard-topimage ">
                                        <div
                                            className="wrimagecard-topimage_header"
                                            style={{
                                                backgroundColor: "#e8e8e8"
                                                // feedMemDepStatement.fetchSuccess &&
                                                // feedMemDepStatement.data
                                                //     .DepStatementHead &&
                                                // feedMemDepStatement.data
                                                //     .DepStatementHead.color_bg
                                            }}
                                        >
                                            <center>
                                                <i
                                                    className="fa fa-calendar"
                                                    style={{
                                                        color: "#337ab7"
                                                        // feedMemDepStatement.fetchSuccess &&
                                                        // feedMemDepStatement.data
                                                        //     .DepStatementHead &&
                                                        // feedMemDepStatement.data
                                                        //     .DepStatementHead.color_text
                                                    }}
                                                />
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-md-10 col-sm-10 col-xs-10">
                                    <div className="row">
                                        <div className="col-md-5 col-sm-6 col-xs-12">
                                            <div className="row">
                                                <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                                    <label>
                                                        เลขที่บัญชี :{" "}
                                                    </label>
                                                    &nbsp;
                                                    {feedMemDepStatement.fetchSuccess &&
                                                        feedMemDepStatement.data
                                                            .DepStatementHead &&
                                                        feedMemDepStatement.data
                                                            .DepStatementHead
                                                            .deposit_account_no}
                                                </div>
                                                <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                                    <label>ชื่อบัญชี : </label>
                                                    &nbsp;
                                                    {feedMemDepStatement.fetchSuccess &&
                                                        feedMemDepStatement.data
                                                            .DepStatementHead &&
                                                        feedMemDepStatement.data
                                                            .DepStatementHead
                                                            .deposit_account_name}
                                                </div>
                                                <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                                    <label>
                                                        ยอดที่ถอนได้ :{" "}
                                                    </label>
                                                    &nbsp;
                                                    {feedMemDepStatement.fetchSuccess &&
                                                        feedMemDepStatement.data
                                                            .DepStatementHead &&
                                                        number_format(
                                                            feedMemDepStatement
                                                                .data
                                                                .DepStatementHead
                                                                .withdrawable_amount
                                                        )}
                                                </div>
                                            </div>
                                        </div>
                                        <div className="col-md-5 col-sm-6 col-xs-12">
                                            <div className="row">
                                                <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                                    <label>
                                                        วันที่เปิดบัญชี :{" "}
                                                    </label>
                                                    &nbsp;
                                                    {feedMemDepStatement.fetchSuccess &&
                                                        feedMemDepStatement.data
                                                            .DepStatementHead &&
                                                        convert_to_Thaidate(
                                                            feedMemDepStatement
                                                                .data
                                                                .DepStatementHead
                                                                .deposit_opened_date
                                                        )}
                                                </div>
                                                <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                                    <label>ประเภท : </label>
                                                    &nbsp;
                                                    {feedMemDepStatement.fetchSuccess &&
                                                        feedMemDepStatement.data
                                                            .DepStatementHead &&
                                                        feedMemDepStatement.data
                                                            .DepStatementHead
                                                            .deposit_name}
                                                </div>
                                                <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                                    <label>ยอดคงเหลือ : </label>
                                                    &nbsp;
                                                    {feedMemDepStatement.fetchSuccess &&
                                                        feedMemDepStatement.data
                                                            .DepStatementHead &&
                                                        number_format(
                                                            feedMemDepStatement
                                                                .data
                                                                .DepStatementHead
                                                                .deposit_balance
                                                        )}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <nav className="navbar navbar-light text-center">
                                <form
                                    className="form-inline col-xs-12"
                                    onSubmit={handleSubmit(onSubmit)}
                                >
                                    <label className="col-form-label">
                                        ค้นหา จาก
                                    </label>
                                    <input
                                        readOnly
                                        id="inputdatepickerstart"
                                        name="inputdatepickerstart"
                                        className="datepicker form-control mr-sm-2"
                                        data-date-format="mm/dd/yyyy"
                                        ref={register({ required: true })}
                                        required
                                    />
                                    <label className="col-form-label">
                                        ถึง
                                    </label>
                                    <input
                                        readOnly
                                        id="inputdatepickerend"
                                        name="inputdatepickerend"
                                        className="datepicker form-control mr-sm-2"
                                        data-date-format="mm/dd/yyyy"
                                        ref={register({ required: true })}
                                        required
                                    />
                                    <button
                                        id="inputdatepick"
                                        className="btn btn-success my-2 my-sm-0"
                                        name="inputdatepick"
                                        type="submit"
                                        style={{ marginRight: "10px" }}
                                    >
                                        ค้นหา
                                    </button>
                                    <button
                                        id="cleardatepick"
                                        className="btn btn-danger my-2 my-sm-0"
                                        name="cleardatepick"
                                        onClick={cleardatepick}
                                        type="button"
                                    >
                                        ดูทั้งหมด
                                    </button>
                                </form>
                            </nav>
                            <hr />
                            <div className="row">
                                <div
                                    className="col-md-12 col-sm-12 col-xs-12 "
                                    style={{
                                        padding: "3px 0px",
                                        backgroundColor: "rgb(231, 245, 243)",
                                        color: "#fff",
                                        fontWeight: "bold",
                                        marginBottom: 12
                                    }}
                                >
                                    <div className="col-lg-2 col-md-3 col-sm-3 col-xs-6 text-detail">
                                        <p
                                            align="right"
                                            style={{
                                                color: "rgb(22, 160, 133)"
                                            }}
                                        >
                                            วันที่ทำรายการ
                                        </p>
                                    </div>
                                    <div className="col-lg-3 col-md-3 col-sm-3 col-xs-6 text-detail">
                                        <p
                                            align="right"
                                            style={{
                                                color: "rgb(22, 160, 133)"
                                            }}
                                        >
                                            ถอน/ฝาก
                                        </p>
                                    </div>
                                    <div className="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-detail">
                                        <p
                                            align="right"
                                            style={{
                                                color: "rgb(22, 160, 133)"
                                            }}
                                        >
                                            คงเหลือ
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {feedMemDepStatement.fetchSuccess &&
                                (Array.isArray(
                                    feedMemDepStatement.data.dep_statement.data
                                ) &&
                                feedMemDepStatement.data.dep_statement.data
                                    .length ? (
                                    feedMemDepStatement.data.dep_statement.data.map(
                                        (val, i) => {
                                            return (
                                                <Fragment key={i}>
                                                    <div className="row">
                                                        <div
                                                            className="col-md-12 col-sm-12 col-xs-12 "
                                                            style={{
                                                                padding: 0
                                                            }}
                                                        >
                                                            {/* <div className="col-md-12 col-sm-12 col-xs-12 text-detail">
                                                                <p align="left">
                                                                    {` รายการ : ${val.deposit_item_description}`}
                                                                </p>
                                                            </div> */}
                                                            <div
                                                                className="col-lg-2 col-md-3 col-sm-3 col-xs-6 text-detail"
                                                                style={{
                                                                    padding: 0
                                                                }}
                                                            >
                                                                <p
                                                                    align="right"
                                                                    style={{
                                                                        color:
                                                                            "green"
                                                                    }}
                                                                >
                                                                    {convert_to_Thaidate(
                                                                        val.operate_date
                                                                    )}
                                                                </p>
                                                            </div>
                                                            <div className="col-lg-3 col-md-3 col-sm-3 col-xs-6 text-detail">
                                                                <p
                                                                    className={
                                                                        "p_deposit_balance"
                                                                    }
                                                                    align={`right`}
                                                                    style={{
                                                                        color:
                                                                            val.sign_flag ==
                                                                            -1
                                                                                ? "red"
                                                                                : "green",
                                                                        paddingRight:
                                                                            val.sign_flag ==
                                                                            -1
                                                                                ? 40
                                                                                : 0
                                                                    }}
                                                                >
                                                                    {val.sign_flag ==
                                                                    -1
                                                                        ? `- ${number_format(
                                                                              val.deposit_balance
                                                                          )}`
                                                                        : `+ ${number_format(
                                                                              val.deposit_balance
                                                                          )}`}
                                                                </p>
                                                            </div>
                                                            <div className="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-detail">
                                                                <p
                                                                    align="right"
                                                                    style={{
                                                                        color:
                                                                            "black",
                                                                        fontWeight:
                                                                            "bold",
                                                                        textDecorationLine:
                                                                            "underline",
                                                                        textDecorationStyle:
                                                                            "double"
                                                                    }}
                                                                >
                                                                    {" "}
                                                                    {number_format(
                                                                        val.total_balance
                                                                    )}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr
                                                        style={{
                                                            marginTop: 2,
                                                            marginBottom: 0
                                                        }}
                                                    />
                                                </Fragment>
                                            );
                                        }
                                    )
                                ) : (
                                    <p
                                        align="center"
                                        style={{ color: "red", fontSize: 20 }}
                                    >
                                        ไม่มีข้อมูล
                                    </p>
                                ))}
                        </div>
                    </div>
                    <div className="col-md-12">
                        <div className="text-center">
                            {feedMemDepStatement.fetchSuccess &&
                            feedMemDepStatement.data.dep_statement &&
                            feedMemDepStatement.data.dep_statement.data
                                .length ? (
                                <Pagination
                                    defaultPageSize={
                                        feedMemDepStatement.data.dep_statement
                                            .per_page
                                    }
                                    className="pagination"
                                    locale={{
                                        // Options.jsx
                                        items_per_page: "/ หน้า",
                                        jump_to: "ไปยัง",
                                        jump_to_confirm: "ยืนยัน",
                                        page: "",

                                        // Pagination.jsx
                                        prev_page: "หน้าก่อนหน้า",
                                        next_page: "หน้าถัดไป",
                                        prev_5: "ย้อนกลับ 5 หน้า",
                                        next_5: "ถัดไป 5 หน้า",
                                        prev_3: "ย้อนกลับ 3 หน้า",
                                        next_3: "ถัดไป 3 หน้า"
                                    }}
                                    onChange={OnchangePagination}
                                    current={
                                        feedMemDepStatement.data.dep_statement
                                            .current_page
                                    }
                                    total={
                                        feedMemDepStatement.data.dep_statement
                                            .total
                                    }
                                    prevIcon={
                                        <a className="page-link" itemProp="url">
                                            <i
                                                style={{
                                                    fontSize: "inherit"
                                                }}
                                                className="fa fa-angle-left"
                                            />{" "}
                                            PREVIOUS
                                        </a>
                                    }
                                    nextIcon={
                                        <a className="page-link" itemProp="url">
                                            NEXT{" "}
                                            <i
                                                style={{
                                                    fontSize: "inherit"
                                                }}
                                                className="fa fa-angle-right"
                                            />
                                        </a>
                                    }
                                    jumpNextIcon="..."
                                    jumpPrevIcon="..."
                                />
                            ) : null}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default MemdepStatement;
