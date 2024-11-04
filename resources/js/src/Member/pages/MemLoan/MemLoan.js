import React, { Fragment, useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Link } from "react-router-dom";

import { feedMemLoanActions } from "../../actions";
import { number_format, convert_to_Thaidate } from "../../../helpers";

import MemSkeleton from "../Skeleton/MemLoan";
import Collateral from "./Collateral";

const MemLoan = () => {
    const dispatch = useDispatch();
    const feedMemLoan = useSelector(state => state.feedMemLoan);

    const [loading, setLoading] = useState(true);

    useEffect(() => {
        async function feedData() {
            await dispatch(
                feedMemLoanActions.feedDataPost(`/api/member/member_loan`)
            );
        }

        feedData();
    }, []);

    useEffect(() => {
        // Update the document title using the browser API
        loadCircli();
    });

    useEffect(() => {
        if (feedMemLoan.fetchSuccess) {
            setLoading(false);
        }
        return async function cleanup() {
            await setLoading(true);
        };
    }, [feedMemLoan.fetchSuccess]);

    function draw(idwhere, idwhat) {
        $("." + idwhat).remove();
        $("." + idwhere).append('<div class="' + idwhat + '"></div>');
    }

    function loadCircli() {
        if ($.isFunction($.fn.circliful)) {
            if (
                feedMemLoan.fetchSuccess &&
                Array.isArray(feedMemLoan.data.dataloan) &&
                feedMemLoan.data.dataloan.length &&
                $.fn.circliful
            ) {
                for (var i = 0; i < feedMemLoan.data.dataloan.length; i++) {
                    draw("wrimagecard-topimage_header" + i, "col" + i);

                    $(".col" + i).circliful({
                        animation: 1,
                        animationStep: 6,
                        animateInView: true,
                        foregroundBorderWidth: 5,
                        backgroundBorderWidth: 1,
                        // percent: "<?php echo $percent1 ?>",
                        percent: feedMemLoan.data.dataloan[i].percent_pay,
                        iconColor: "#3498DB",
                        icon: "f017",
                        iconSize: "40",
                        iconPosition: "middle",
                        text: "การผ่อนชำระ",
                        textBelow: true,
                        textColor: "#3498DB"
                    });
                }
            }
        }
    }

    return (
        <Fragment>
            {loading && <MemSkeleton />}
            {!loading && (
                <div className="container-fluid">
                    <div className="rowx">
                        {feedMemLoan.fetchSuccess &&
                            (Array.isArray(feedMemLoan.data.dataloan) &&
                            feedMemLoan.data.dataloan.length ? (
                                feedMemLoan.data.dataloan.map((val, i) => {
                                    let num = 0;
                                    return (
                                        <div
                                            className="panel panel-info container wrimagecard"
                                            style={{
                                                paddingLeft: 0,
                                                paddingRight: 0,
                                                boxShadow:
                                                    "12px 15px 20px 0px rgba(46,61,73,0.15)"
                                            }}
                                            key={i}
                                        >
                                            <div className="panel-heading">
                                                <h3
                                                    className="panel-title"
                                                    style={{
                                                        fontWeight: "bold"
                                                    }}
                                                >
                                                    {i + 1 + ".)"}{" "}
                                                    {val.loan_type_description}
                                                </h3>
                                            </div>
                                            <div className="panel-body">
                                                <div className="col-md-2 col-sm-6 col-xs-6 graph-loan">
                                                    <div className="wrimagecard-topimage ">
                                                        <div
                                                            className={`wrimagecard-topimage_header${i}`}
                                                        >
                                                            <div
                                                                className={`col${i}`}
                                                            ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="col-md-10 col-sm-12 col-xs-12">
                                                    <hr style={{ margin: 0 }} />
                                                    <div className="wrimagecard-topimage_title">
                                                        <div className="row">
                                                            <div className="col-md-5 col-sm-6 col-xs-12 text-caption">
                                                                <label>
                                                                    เลขที่สัญญา
                                                                    :{" "}
                                                                </label>
                                                                &nbsp;
                                                                {
                                                                    val.loan_contract_no
                                                                }
                                                            </div>
                                                            <div className="col-md-5 col-sm-6 col-xs-12 text-caption">
                                                                <label>
                                                                    วันที่เริ่มสัญญา
                                                                    :{" "}
                                                                </label>
                                                                &nbsp;
                                                                {convert_to_Thaidate(
                                                                    val.begining_of_contract
                                                                )}
                                                            </div>
                                                        </div>
                                                        <div className="row">
                                                            <div className="col-md-5 col-sm-6 col-xs-12 text-caption">
                                                                <label>
                                                                    วงเงินอนุมัติ
                                                                    :{" "}
                                                                </label>
                                                                &nbsp;
                                                                {number_format(
                                                                    val.loan_approve_amount
                                                                )}
                                                            </div>
                                                            <div className="col-md-5 col-sm-6 col-xs-12 text-caption">
                                                                <label>
                                                                    ยอดคงเหลือ :{" "}
                                                                </label>
                                                                &nbsp;
                                                                {number_format(
                                                                    val.principal_balance
                                                                )}
                                                            </div>
                                                        </div>
                                                        <div className="row">
                                                            <div className="col-md-5 col-sm-6 col-xs-12 text-caption">
                                                                <label>
                                                                    ชำระงวดละ :{" "}
                                                                </label>
                                                                &nbsp;
                                                                {`${number_format(
                                                                    val.period_payment_amount
                                                                )} ( ${
                                                                    val.last_period
                                                                } งวด )`}
                                                            </div>
                                                        </div>
                                                        <div
                                                            className="row"
                                                            style={{
                                                                marginTop: 30
                                                            }}
                                                        >
                                                            <div className="col-md-12">
                                                                <div className="pull-right  text-caption text-caption-detail">
                                                                    <span>
                                                                        <Link
                                                                            to={`/loan_statement/${val.loan_contract_no}`}
                                                                        >
                                                                            <div
                                                                                className="btn btn-info"
                                                                                style={{
                                                                                    color:
                                                                                        "#333",
                                                                                    fontSize: 16
                                                                                }}
                                                                            >
                                                                                รายละเอียด
                                                                                &nbsp;
                                                                                <i
                                                                                    className="fa fa-forward"
                                                                                    style={{
                                                                                        color:
                                                                                            "#333",
                                                                                        fontSize: 30
                                                                                    }}
                                                                                />
                                                                            </div>
                                                                        </Link>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                {/* <div className="row" > */}
                                                        {Array.isArray(
                                                            feedMemLoan.data
                                                                .collateral
                                                        ) &&
                                                            feedMemLoan.data
                                                                .collateral
                                                                .length > 0 && (
                                                                <>
                                                                    <hr />
                                                                    <div className="row" style={{paddingTop: '40px'}}>
                                                                        <div className="col-sm-12 col-md-12 col-lg-12">
                                                                            <Collateral
                                                                                collateral={
                                                                                    feedMemLoan
                                                                                        .data
                                                                                        .collateral
                                                                                }
                                                                                head_contract={
                                                                                    val.loan_contract_no
                                                                                }
                                                                                num={
                                                                                    num
                                                                                }
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                </>
                                                            )}
                                                    {/* </div> */}
                                                </div>
                                            </div>
                                        </div>
                                    );
                                })
                            ) : (
                                <Fragment>
                                    <br />
                                    <br />
                                    <p
                                        className="text-center"
                                        style={{ color: "red", fontSize: 28 }}
                                    >
                                        ไม่มีข้อมูล
                                    </p>
                                </Fragment>
                            ))}
                    </div>
                </div>
            )}
            <style
                dangerouslySetInnerHTML={{
                    __html:
                        "svg text { font-size:large } a:hover{ cursor:pointer; } "
                }}
            />
        </Fragment>
    );
};

export default MemLoan;
