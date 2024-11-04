import React, { Fragment, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useParams } from "react-router-dom";
import useForm from "react-hook-form";
import Pagination from "rc-pagination";

import { feedMemLoanStatementActions } from "../../actions";
import { number_format, convert_to_Thaidate } from "../../../helpers";

const MemLoanStatement = () => {
    const dispatch = useDispatch();
    const feedMemLoanStatement = useSelector(
        state => state.feedMemLoanStatement
    );
    const { register, handleSubmit, watch, errors, setValue } = useForm();
    let { statement } = useParams();

    useEffect(() => {
        if (statement != "") {
            async function feedData() {
                await dispatch(
                    feedMemLoanStatementActions.feedDataPost(
                        `/api/member/member_loan_statement/${statement}`
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

        $("#menu_loan").addClass("active");
        return () => {
            $("#menu_loan").removeClass("active");
        };
    }, [statement]);

    const onSubmit = async (data, e) => {
        e.preventDefault();

        const body = {
            inputdatepickerstart: data.inputdatepickerstart,
            inputdatepickerend: data.inputdatepickerend
        };
        await dispatch(
            feedMemLoanStatementActions.feedDataPost(
                `/api/member/member_loan_statement/${statement}`,
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
                feedMemLoanStatementActions.feedDataPost(
                    `/api/member/member_loan_statement/${statement}?page=${currentPage}`
                )
            );
        } else {
            const body = {
                inputdatepickerstart: watch("inputdatepickerstart"),
                inputdatepickerend: watch("inputdatepickerend")
            };
            await dispatch(
                feedMemLoanStatementActions.feedDataPost(
                    `/api/member/member_loan_statement/${statement}?page=${currentPage}`,
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
                feedMemLoanStatementActions.feedDataPost(
                    `/api/member/member_loan_statement/${statement}`
                )
            );
        }
    };

    // $(document).ready(function() {
    //     $("#menu_loan").addClass("active");
    // });

    return (
        <div className="container-fluid">
            <div className="rowx">
                <div
                    className="panel panel-info container wrimagecard"
                    style={{
                        paddingLeft: 0,
                        paddingRight: 0,
                        boxShadow: "12px 15px 20px 0px rgba(46,61,73,0.15)"
                    }}
                >
                    <div className="panel-heading">
                        <h3
                            className="panel-title"
                            style={{ fontWeight: "bold" }}
                        >
                            {feedMemLoanStatement.fetchSuccess &&
                                feedMemLoanStatement.data.headLoan_statement &&
                                `${feedMemLoanStatement.data.headLoan_statement[0].loan_type_description}  [ เลขที่สัญญา ${feedMemLoanStatement.data.headLoan_statement[0].loan_contract_no} ]`}
                            {/* <span id="searchfrom" /> */}
                        </h3>
                    </div>
                    <div className="panel-body">
                        <div className="col-md-12 col-sm-12 col-xs-12">
                            <div className="row">
                                <div className="col-md-2 col-sm-12 col-xs-12">
                                    <div className="wrimagecard-topimage ">
                                        <div className="wrimagecard-topimage_header">
                                            <center>
                                                <i
                                                    className="fa fa-calendar"
                                                    style={{ color: "#16A085" }}
                                                />
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-md-10 col-sm-10 col-xs-10 text-caption">
                                    <div className="row" style={{paddingTop:30}}>
                                        <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                            <label>เลขที่สัญญา : </label>&nbsp;
                                            {feedMemLoanStatement.fetchSuccess &&
                                                feedMemLoanStatement.data
                                                    .headLoan_statement &&
                                                feedMemLoanStatement.data
                                                    .headLoan_statement[0]
                                                    .loan_contract_no}
                                        </div>

                                        <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                            <label>ยอดคงเหลือ : </label>&nbsp;
                                            {feedMemLoanStatement.fetchSuccess &&
                                                feedMemLoanStatement.data
                                                    .headLoan_statement &&
                                                number_format(
                                                    feedMemLoanStatement.data
                                                        .headLoan_statement[0]
                                                        .principal_balance
                                                )}
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
                                    {/* <input className="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" /> */}
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
                            <div
                                className="col-md-12 col-sm-12 col-xs-12"
                                style={{ background: "#E7F5F3" }}
                            >
                                <div className="col-md-3 col-sm-12 col-xs-12 text-detail">
                                    <div className="row">
                                        <div className="col-md-12 col-sm-12 col-xs-12 text-detail" />
                                    </div>
                                </div>
                                <div className="col-md-3 col-sm-4 col-xs-4 text-detail">
                                    <div className="row">
                                        <div className="col-md-12 col-sm-12 col-xs-12 text-detail">
                                            <p
                                                align="center"
                                                style={{ color: "#16A085" }}
                                            >
                                                วันที่
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-md-3 col-sm-4 col-xs-4 text-detail">
                                    <div className="row">
                                        <div className="col-md-6 col-sm-12 col-xs-12 text-detail">
                                            <p
                                                align="center"
                                                style={{ color: "#16A085" }}
                                            >
                                                งวด
                                            </p>
                                        </div>
                                        <div className="col-md-6 col-sm-12 col-xs-12 text-detail">
                                            <p
                                                align="right"
                                                style={{ color: "#16A085" }}
                                            >
                                                ต้น
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-md-3 col-sm-4 col-xs-4 text-detail">
                                    <div className="row">
                                        <div className="col-md-6 col-sm-12 col-xs-12 text-detail">
                                            <p
                                                align="right"
                                                style={{ color: "#16A085" }}
                                            >
                                                ดอก
                                            </p>
                                        </div>
                                        <div className="col-md-6 col-sm-12 col-xs-12 text-detail">
                                            <p
                                                align="right"
                                                style={{ color: "#16A085" }}
                                            >
                                                คงเหลือ
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {feedMemLoanStatement.fetchSuccess &&
                                (Array.isArray(
                                    feedMemLoanStatement.data.loan_statement
                                        .data
                                ) &&
                                feedMemLoanStatement.data.loan_statement.data
                                    .length ? (
                                    feedMemLoanStatement.data.loan_statement.data.map(
                                        (val, i) => {
                                            return (
                                                <Fragment key={i}>
                                                    <div className="row">
                                                        <div className="col-md-12 col-sm-12 col-xs-12 ">
                                                            <div className="col-md-3 col-sm-12 col-xs-12 text-detail">
                                                                <div className="row">
                                                                    <div
                                                                        className="col-md-12 col-sm-12 col-xs-12 text-detail"
                                                                        style={{
                                                                            padding: 0
                                                                        }}
                                                                    >
                                                                        <p align="left">
                                                                            <u>
                                                                                {" "}
                                                                                {`รายการ : ${val.item_type_description}`}
                                                                            </u>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                className="col-md-3 col-sm-4 col-xs-4 text-detail"
                                                                style={{
                                                                    padding: 0
                                                                }}
                                                            >
                                                                <div className="row">
                                                                    <div
                                                                        className="col-md-12 col-sm-12 col-xs-12 text-detail"
                                                                        style={{
                                                                            padding: 0
                                                                        }}
                                                                    >
                                                                        <p align="center">
                                                                            {convert_to_Thaidate(
                                                                                val.loan_payment_date
                                                                            )}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className="col-md-3 col-sm-4 col-xs-4 text-detail">
                                                                {val.sign_status <
                                                                0 ? (
                                                                    <div className="row">
                                                                        <div className="col-md-6 col-sm-12 col-xs-12 text-detail">
                                                                            <p
                                                                                align="center"
                                                                                style={{
                                                                                    color:
                                                                                        "blue"
                                                                                }}
                                                                            >
                                                                                {val.period ==
                                                                                0
                                                                                    ? `-`
                                                                                    : val.period}
                                                                            </p>
                                                                        </div>
                                                                        <div className="col-md-6 col-sm-12 col-xs-12 text-detail">
                                                                            <p
                                                                                align="right"
                                                                                style={{
                                                                                    color:
                                                                                        "red"
                                                                                }}
                                                                            >
                                                                                {number_format(
                                                                                    val.payment_amount
                                                                                )}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                ) : (
                                                                    <div className="row">
                                                                        <div className="col-md-6 col-sm-12 col-xs-12 text-detail">
                                                                            <p
                                                                                align="center"
                                                                                style={{
                                                                                    color:
                                                                                        "blue"
                                                                                }}
                                                                            >
                                                                                {val.period ==
                                                                                0
                                                                                    ? `-`
                                                                                    : val.period}
                                                                            </p>
                                                                        </div>
                                                                        <div className="col-md-6 col-sm-12 col-xs-12 text-detail">
                                                                            <p
                                                                                align="right"
                                                                                style={{
                                                                                    color:
                                                                                        "red"
                                                                                }}
                                                                            >
                                                                                {number_format(
                                                                                    val.payment_amount
                                                                                )}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                )}
                                                            </div>
                                                            <div className="col-md-3 col-sm-4 col-xs-4 text-detail">
                                                                <div className="row">
                                                                    <div className="col-md-6 col-sm-12 col-xs-12 text-detail">
                                                                        <p
                                                                            align="right"
                                                                            style={{
                                                                                color:
                                                                                    "orange"
                                                                            }}
                                                                        >
                                                                            {" "}
                                                                            {number_format(
                                                                                val.interest_amount
                                                                            )}
                                                                        </p>
                                                                    </div>
                                                                    <div className="col-md-6 col-sm-12 col-xs-12 text-detail">
                                                                        <p align="right">
                                                                            {number_format(
                                                                                val.PRINCIPAL_BALANCE
                                                                            )}
                                                                        </p>
                                                                    </div>
                                                                </div>
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
                        <hr style={{ marginTop: 2, marginBottom: 0 }} />
                        <div className="text-center">
                            {feedMemLoanStatement.fetchSuccess &&
                            feedMemLoanStatement.data.loan_statement &&
                            feedMemLoanStatement.data.loan_statement.data
                                .length ? (
                                <Pagination
                                    defaultPageSize={
                                        feedMemLoanStatement.data.loan_statement
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
                                        feedMemLoanStatement.data.loan_statement
                                            .current_page
                                    }
                                    total={
                                        feedMemLoanStatement.data.loan_statement
                                            .total
                                    }
                                    prevIcon={
                                        <a className="page-link" itemProp="url">
                                            <i
                                                style={{ fontSize: "inherit" }}
                                                className="fa fa-angle-left"
                                            />
                                            PREVIOUS
                                        </a>
                                    }
                                    nextIcon={
                                        <a className="page-link" itemProp="url">
                                            NEXT
                                            <i
                                                style={{ fontSize: "inherit" }}
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

export default MemLoanStatement;
