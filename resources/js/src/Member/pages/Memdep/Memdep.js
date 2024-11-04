import React, { Fragment, useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Link } from "react-router-dom";

import { feedMemDepActions } from "../../actions";
import { number_format, convert_to_Thaidate } from "../../../helpers";

import MemSkeleton from "../Skeleton/MemLoan";

const Memdep = () => {
    const dispatch = useDispatch();
    const feedMemDep = useSelector(state => state.feedMemDep);

    const [loading, setLoading] = useState(true);

    useEffect(() => {
        if (feedMemDep.fetchSuccess) {
            setLoading(false);
        }
        return async function cleanup() {
            await setLoading(true);
        };
    }, [feedMemDep.fetchSuccess]);

    useEffect(() => {
        async function feedData() {
            await dispatch(
                feedMemDepActions.feedDataPost(`/api/member/member_dep`)
            );
        }

        feedData();
    }, []);

    return (
        <Fragment>
            <style
                dangerouslySetInnerHTML={{
                    __html: "\n   a:hover{\n    cursor: pointer;\n  }\n "
                }}
            />
            {loading && <MemSkeleton />}
            {!loading && (
                <div className="container-fluid">
                    <div className="rowx">
                        {/* @foreach ($datadeposit as $row) */}
                        {feedMemDep.fetchSuccess &&
                            (Array.isArray(feedMemDep.data.datadeposit) &&
                            feedMemDep.data.datadeposit.length ? (
                                feedMemDep.data.datadeposit.map((val, i) => {
                                    return (
                                        <div
                                            className="panel container wrimagecard panel-info "
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
                                                    ประเภทเงินฝาก :{" "}
                                                    {val.deposit_name}
                                                </h3>
                                            </div>
                                            <div
                                                clas="panel-body"
                                                style={{ marginTop: 10 }}
                                            >
                                                <div className="col-md-2 col-sm-12 col-xs-12">
                                                    <div className="wrimagecard-topimage ">
                                                        <div
                                                            className="wrimagecard-topimage_header"
                                                            style={{
                                                                backgroundColor:
                                                                    "aliceblue"
                                                            }}
                                                        >
                                                            <center>
                                                                <i className="fa fa-bank fa" />
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="col-md-10 col-sm-12 col-xs-12">
                                                    <div className="wrimagecard-topimage_title">
                                                        <div className="row">
                                                            <div className="col-md-6 col-sm-12 col-xs-12">
                                                                <div className="row">
                                                                    <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                                                        <label>
                                                                            เลขที่บัญชี
                                                                            :{" "}
                                                                        </label>
                                                                        &nbsp;
                                                                        {
                                                                            val.deposit_account_no
                                                                        }
                                                                    </div>
                                                                    {/* <div className="col-md-6 col-sm-6 col-xs-6 text-detail">
                                                    <p>{ val.deposit_account_no }</p>
                                                </div> */}
                                                                    <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                                                        <label>
                                                                            ยอดคงเหลือ
                                                                            :{" "}
                                                                        </label>
                                                                        &nbsp;
                                                                        {number_format(
                                                                            val.deposit_balance
                                                                        )}
                                                                    </div>
                                                                    {/* <div className="col-md-6 col-sm-6 col-xs-6 text-detail">
                                                    <p>{ number_format(val.deposit_balance) }</p>
                                                </div> */}
                                                                    <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                                                        <label>
                                                                            ชื่อบัญชี
                                                                            :{" "}
                                                                        </label>
                                                                        &nbsp;
                                                                        {
                                                                            val.deposit_account_name
                                                                        }
                                                                    </div>
                                                                    {/* <div className="col-md-6 col-sm-6 col-xs-6 text-detail">
                                                    <p>{ val.deposit_account_name }</p>
                                                </div> */}
                                                                    <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                                                        <label>
                                                                            ดอกเบี้ยสะสม
                                                                            :{" "}
                                                                        </label>
                                                                        &nbsp;
                                                                        {
                                                                            val.accumulate_interest
                                                                        }
                                                                    </div>
                                                                    {/* <div className="col-md-6 col-sm-6 col-xs-6 text-detail">
                                                    <p>{ val.accumulate_interest }</p>
                                                </div> */}
                                                                </div>
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
                                                                            to={`/dep_statement/${val.deposit_account_no}`}
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
                        <div className="container">
                            <div className="row">
                                <div className="col-md-12 text-right">
                                    <hr />
                                    <h3>
                                        <font color="darkslategray">
                                            รวมเงินคงเหลือ :
                                            <u>
                                                {feedMemDep.fetchSuccess &&
                                                    feedMemDep.data
                                                        .deposit_balance &&
                                                    number_format(
                                                        feedMemDep.data
                                                            .deposit_balance
                                                    )}
                                            </u>
                                        </font>
                                    </h3>
                                    <h3>
                                        <font color="darkslategray">
                                            รวมดอกเบี้ยสะสม :
                                            <u>
                                                {feedMemDep.fetchSuccess &&
                                                    feedMemDep.data
                                                        .accumulate_interest &&
                                                    number_format(
                                                        feedMemDep.data
                                                            .accumulate_interest
                                                    )}
                                            </u>
                                        </font>
                                    </h3>
                                    <hr />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </Fragment>
    );
};

export default Memdep;
