import React, { useEffect, Fragment, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import useForm from "react-hook-form";
import Pagination from "rc-pagination";

import { feedMemShareActions } from "../../actions";
import { number_format, convert_to_Thaidate } from "../../../helpers";
import MemSkeleton from "../Skeleton/MemShare";

const MemShare = () => {
    const dispatch = useDispatch();
    const feedMemShare = useSelector(state => state.feedMemShare);

    const [loading, setLoading] = useState(true);

    const { register, handleSubmit, watch, errors, setValue } = useForm();

    useEffect(() => {
        async function feedData() {
            await dispatch(
                feedMemShareActions.feedDataPost(`/api/member/member_share`)
            );
        }

        feedData();

        // $(".datepicker").datepicker({
        //     format: "dd/mm/yyyy",
        //     todayBtn: true,
        //     language: "th", //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
        //     thaiyear: true //Set เป็นปี พ.ศ.
        // });
    }, []);

    useEffect(() => {
        const datepick = () => {
            $(".datepicker").datepicker({
                format: "dd/mm/yyyy",
                todayBtn: true,
                language: "th", //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true //Set เป็นปี พ.ศ.
            });
        };

        if (feedMemShare.fetchSuccess) {
            setLoading(false);
        }
        return async function cleanup() {
            await setLoading(true);
            datepick();
        };
    }, [feedMemShare.fetchSuccess]);

    const onSubmit = async (data, e) => {
        e.preventDefault();

        const body = {
            inputdatepickerstart: data.inputdatepickerstart,
            inputdatepickerend: data.inputdatepickerend
        };

        // console.log(body);

        await dispatch(
            feedMemShareActions.feedDataPost(
                `/api/member/searchMember_share`,
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
                feedMemShareActions.feedDataPost(
                    `/api/member/member_share?page=${currentPage}`
                )
            );
        } else {
            const body = {
                inputdatepickerstart: watch("inputdatepickerstart"),
                inputdatepickerend: watch("inputdatepickerend")
            };

            await dispatch(
                feedMemShareActions.feedDataPost(
                    `/api/member/searchMember_share?page=${currentPage}`,
                    body
                )
            );
        }
    };

    const cleardatepick = async () => {
        // if (
        //     watch("inputdatepickerstart") != "" &&
        //     watch("inputdatepickerend") != ""
        // ) {
        //     setValue("inputdatepickerstart", "");
        //     setValue("inputdatepickerend", "");

        await dispatch(
            feedMemShareActions.feedDataPost(`/api/member/member_share`)
        );
        // }
    };

    return (
        <Fragment>
            {loading && <MemSkeleton />}
            {!loading && (
                <div id="shareMem-part" className="container-fluid">
                    <div
                        className="panel panel-info container wrimagecard"
                        style={{
                            paddingLeft: 0,
                            paddingRight: 0,
                            boxShadow:
                                "rgb(217 237 247 / 55%) 12px 15px 20px 0px"
                        }}
                    >
                        <div className="panel-heading">
                            <h3
                                className="panel-title"
                                style={{ fontWeight: "bold" }}
                            >
                                ทุนเรือนหุ้น
                                {/* <span id="searchfrom" /> */}
                            </h3>
                        </div>
                        <div className="panel-body">
                            <div className="col-md-2 col-sm-12 col-xs-12">
                                <div className="wrimagecard-topimage ">
                                    <div
                                        className="wrimagecard-topimage_header"
                                        style={{ backgroundColor: "#e3f2fd" }}
                                    >
                                        <center>
                                            <i
                                                className="fa fa-pie-chart"
                                                style={{ color: "#64B5F6" }}
                                            />
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div className="col-md-10 col-sm-12 col-xs-12">
                                {feedMemShare.fetchSuccess &&
                                    feedMemShare.data.sharehead &&
                                    feedMemShare.data.sharehead.length && (
                                        <>
                                            <div className="wrimagecard-topimage_title">
                                                <div className="row">
                                                    <div className="col-md-6 col-sm-6 col-xs-12 text-caption">
                                                        <label>
                                                            หุ้นสะสมรวม :{" "}
                                                        </label>
                                                        &nbsp;
                                                        {feedMemShare.fetchSuccess &&
                                                            number_format(
                                                                feedMemShare
                                                                    .data
                                                                    .sharehead[0]
                                                                    .share_stock
                                                            )}
                                                    </div>
                                                    {/* <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                        <p> { feedMemShare.fetchSuccess && number_format(feedMemShare.data.sharehead[0].share_stock) }</p>
                                    </div> */}
                                                    <div className="col-md-6 col-sm-6 col-xs-12 text-caption">
                                                        <label>
                                                            ส่งหุ้นเดือนละ :{" "}
                                                        </label>
                                                        &nbsp;
                                                        {feedMemShare.fetchSuccess &&
                                                            feedMemShare.data
                                                                .sharehead[0]
                                                                .share_amount_fp}
                                                    </div>
                                                    {/* <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                        <p> { feedMemShare.fetchSuccess && (feedMemShare.data.sharehead[0].share_amount_fp) } </p>
                                    </div> */}
                                                    <div className="col-md-6 col-sm-6 col-xs-12 text-caption">
                                                        <label>
                                                            งวดล่าสุด :{" "}
                                                        </label>
                                                        &nbsp;
                                                        {feedMemShare.fetchSuccess &&
                                                            number_format(
                                                                feedMemShare
                                                                    .data
                                                                    .sharehead[0]
                                                                    .period_recrieve,
                                                                0
                                                            )}
                                                    </div>
                                                    {/* <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                        <p> { feedMemShare.fetchSuccess && number_format(feedMemShare.data.sharehead[0].period_recrieve,0) } </p>
                                    </div> */}
                                                </div>
                                            </div>
                                            <nav className="navbar navbar-light text-center">
                                                <form
                                                    className="form-inline col-xs-12"
                                                    onSubmit={handleSubmit(
                                                        onSubmit
                                                    )}
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
                                                        ref={register({
                                                            required: true
                                                        })}
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
                                                        ref={register({
                                                            required: true
                                                        })}
                                                        required
                                                    />
                                                    {/* <input className="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" /> */}
                                                    <button
                                                        id="inputdatepick"
                                                        className="btn btn-success my-2 my-sm-0"
                                                        name="inputdatepick"
                                                        type="submit"
                                                        style={{
                                                            marginRight: "10px"
                                                        }}
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
                                        </>
                                    )}

                                <div
                                    className="bg-info col-md-12 col-sm-12 col-xs-12"
                                    style={{
                                        /* background: 'rgb(232, 116, 5)'*/ paddingTop: 8
                                    }}
                                >
                                    <div className="col-md-6 col-sm-4 col-xs-4 text-detail">
                                        <div className="row">
                                            <div className="col-md-4 col-sm-12 col-xs-12 text-detail" />
                                            <div className="col-md-4 col-sm-12 col-xs-12 text-detail">
                                                <p
                                                    align="right"
                                                    style={{ color: "#3F51B5" }}
                                                >
                                                    วันที่
                                                </p>
                                            </div>
                                            <div className="col-md-4 col-sm-12 col-xs-12 text-detail">
                                                <p
                                                    align="right"
                                                    style={{ color: "#3F51B5" }}
                                                >
                                                    งวด
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-md-3 col-sm-4 col-xs-4 text-detail">
                                        <p
                                            align="right"
                                            style={{ color: "#3F51B5" }}
                                        >
                                            จำนวนเงิน
                                        </p>
                                    </div>
                                    <div className="col-md-3 col-sm-4 col-xs-4 text-detail">
                                        <p
                                            align="right"
                                            style={{ color: "#3F51B5" }}
                                        >
                                            หุ้นสะสม
                                        </p>
                                    </div>
                                </div>
                                <div className="shareHold">
                                    {feedMemShare.fetchSuccess &&
                                        (Array.isArray(
                                            feedMemShare.data.sharestatement
                                                .data
                                        ) &&
                                        feedMemShare.data.sharestatement.data
                                            .length ? (
                                            feedMemShare.data.sharestatement.data.map(
                                                (val, i) => {
                                                    return (
                                                        <Fragment key={i}>
                                                            <div className="row">
                                                                <div
                                                                    className="col-md-12 col-sm-12 col-xs-12"
                                                                    style={{
                                                                        padding: 0
                                                                    }}
                                                                >
                                                                    <div className="col-md-12 col-sm-12 col-xs-12">
                                                                        <div className="row">
                                                                            <div className="col-md-5 col-sm-12 col-xs-12 text-detail">
                                                                                {val.share_value <
                                                                                0 ? (
                                                                                    <p
                                                                                        align="left"
                                                                                        style={{
                                                                                            color:
                                                                                                "red",
                                                                                            fontWeight:
                                                                                                "bold",
                                                                                            textDecoration:
                                                                                                "underline"
                                                                                        }}
                                                                                    >{` รายการ : ${val.item_type_description}`}</p>
                                                                                ) : (
                                                                                    <p
                                                                                        align="left"
                                                                                        style={{
                                                                                            fontWeight:
                                                                                                "bold",
                                                                                            textDecoration:
                                                                                                "underline"
                                                                                        }}
                                                                                    >{`รายการ : ${val.item_type_description}`}</p>
                                                                                )}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div className="col-md-6 col-sm-4 col-xs-4 text-detail">
                                                                        <div className="row">
                                                                            {/* <div className="col-md-5 col-sm-12 col-xs-12 text-detail">
                                                                                {val.share_value <
                                                                                0 ? (
                                                                                    <p
                                                                                        align="left"
                                                                                        style={{
                                                                                            color:
                                                                                                "red"
                                                                                        }}
                                                                                    >{` รายการ : ${val.item_type_description}`}</p>
                                                                                ) : (
                                                                                    <p align="left">{`รายการ : ${val.item_type_description}`}</p>
                                                                                )}
                                                                            </div> */}
                                                                            <div className="col-md-4 col-sm-12 col-xs-12" />
                                                                            <div className="col-md-4 col-sm-12 col-xs-12 text-detail">
                                                                                <p align="right">
                                                                                    {" "}
                                                                                    {convert_to_Thaidate(
                                                                                        val.operate_date
                                                                                    )}
                                                                                </p>
                                                                            </div>
                                                                            <div className="col-md-3 col-sm-12 col-xs-12 text-detail">
                                                                                <p
                                                                                    align="right"
                                                                                    style={{
                                                                                        color:
                                                                                            "blue"
                                                                                    }}
                                                                                >
                                                                                    {
                                                                                        val.period
                                                                                    }
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div className="col-md-3 col-sm-4 col-xs-4 text-detail">
                                                                        {val.share_value <
                                                                        0 ? (
                                                                            <p
                                                                                align="right"
                                                                                style={{
                                                                                    color:
                                                                                        "red"
                                                                                }}
                                                                            >
                                                                                {number_format(
                                                                                    val.share_value
                                                                                )}
                                                                            </p>
                                                                        ) : (
                                                                            <p
                                                                                align="right"
                                                                                style={{
                                                                                    color:
                                                                                        "green"
                                                                                }}
                                                                            >
                                                                                {" "}
                                                                                +{" "}
                                                                                {number_format(
                                                                                    val.share_value
                                                                                )}
                                                                            </p>
                                                                        )}
                                                                    </div>
                                                                    <div className="col-md-3  col-sm-3 col-xs-3 text-detail">
                                                                        <p align="right">
                                                                            {number_format(
                                                                                val.share_stock
                                                                            )}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </Fragment>
                                                    );
                                                }
                                            )
                                        ) : (
                                            <p
                                                align="center"
                                                style={{
                                                    color: "red",
                                                    fontSize: 20
                                                }}
                                            >
                                                {" "}
                                                ไม่มีข้อมูล{" "}
                                            </p>
                                        ))}
                                    <div className="text-center">
                                        {feedMemShare.fetchSuccess &&
                                        feedMemShare.data.sharestatement &&
                                        feedMemShare.data.sharestatement.data
                                            .length ? (
                                            <Pagination
                                                defaultPageSize={
                                                    feedMemShare.data
                                                        .sharestatement.per_page
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
                                                    feedMemShare.data
                                                        .sharestatement
                                                        .current_page
                                                }
                                                total={
                                                    feedMemShare.data
                                                        .sharestatement.total
                                                }
                                                prevIcon={
                                                    <a
                                                        className="page-link"
                                                        itemProp="url"
                                                    >
                                                        <i
                                                            style={{
                                                                fontSize:
                                                                    "inherit"
                                                            }}
                                                            className="fa fa-angle-left"
                                                        />{" "}
                                                        PREVIOUS
                                                    </a>
                                                }
                                                nextIcon={
                                                    <a
                                                        className="page-link"
                                                        itemProp="url"
                                                    >
                                                        NEXT{" "}
                                                        <i
                                                            style={{
                                                                fontSize:
                                                                    "inherit"
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
                </div>
            )}
        </Fragment>
    );
};

export default MemShare;
