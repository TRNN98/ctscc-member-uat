import React, { useEffect, Fragment, useState } from "react";
import { useDispatch, useSelector } from "react-redux";

import { feedMemCollActions } from "../../actions";
import { number_format, convert_to_Thaidate } from "../../../helpers";

import MemSkeleton from "../Skeleton/MemLoan";

const MemColl = () => {
    const dispatch = useDispatch();
    const feedMemColl = useSelector(state => state.feedMemColl);

    const [loading, setLoading] = useState(true);

    useEffect(() => {
        if (feedMemColl.fetchSuccess) {
            setLoading(false);
        }
        return async function cleanup() {
            await setLoading(true);
        };
    }, [feedMemColl.fetchSuccess]);

    useEffect(() => {
        async function feedData() {
            await dispatch(
                feedMemCollActions.feedDataPost(`/api/member/member_coll`)
            );
        }
        feedData();
    }, []);

    return (
        <>
            {loading && <MemSkeleton />}
            {!loading && (
                <div className="container-fluid">
                    <div className="rowx">
                        <div
                            className="panel panel-success container wrimagecard"
                            style={{
                                paddingLeft: 0,
                                paddingRight: 0,
                                boxShadow:
                                    "12px 15px 20px 0px rgba(22, 160, 133, 0.1)"
                            }}
                        >
                            <div className="panel-heading">
                                <h3
                                    className="panel-title"
                                    style={{ fontWeight: "bold" }}
                                >
                                    ค้ำประกันบุคคลอื่น
                                </h3>
                            </div>
                            <div className="panel-body">
                                <div className="col-md-2 col-sm-12 col-xs-12">
                                    <div className="wrimagecard-topimage ">
                                        <div
                                            className="wrimagecard-topimage_header"
                                            style={{
                                                backgroundColor:
                                                    "rgba(22, 160, 133, 0.1)"
                                            }}
                                        >
                                            <center>
                                                <i
                                                    className="fa fa-group"
                                                    style={{ color: "#16A085" }}
                                                />
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-md-10 col-sm-12 col-xs-12">
                                    <div
                                        className="row"
                                        style={{
                                            backgroundColor:
                                                "rgba(22, 160, 133, 0.1)"
                                        }}
                                    >
                                        <div className="col-md-2 col-sm-6 col-xs-6 text-caption">
                                            <label>เลขที่สัญญา</label>
                                        </div>
                                        <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                            <label>ชื่อ - สกุล ผู้กู้</label>
                                        </div>
                                        <div className="col-md-2 col-sm-6 col-xs-6 text-caption">
                                            <label>เริ่มสัญญา</label>
                                        </div>
                                        <div className="col-md-2 col-sm-6 col-xs-6 text-caption">
                                            <label>วงเงินกู้</label>
                                        </div>
                                        <div className="col-md-2 col-sm-6 col-xs-6 text-caption">
                                            <label>ยอดคงเหลือ</label>
                                        </div>
                                        <div className="col-md-1 col-sm-6 col-xs-6 text-caption" style={{textAlign: "right"}}>
                                            <label>วงเงินค้ำ</label>
                                        </div>
                                    </div>

                                    {feedMemColl.fetchSuccess &&
                                        (Array.isArray(
                                            feedMemColl.data.guarantee
                                        ) &&
                                        feedMemColl.data.guarantee.length ? (
                                            feedMemColl.data.guarantee.map(
                                                (val, i) => {
                                                    return (
                                                        <Fragment key={i}>
                                                            <div className="row">
                                                                <div className="col-md-2 col-sm-6 col-xs-6 text-detail">
                                                                    <p>
                                                                        {`${i +
                                                                            1}.) ${
                                                                            val.loan_contract_no
                                                                        }`}
                                                                    </p>
                                                                </div>
                                                                <div className="col-md-3 col-sm-6 col-xs-6">
                                                                    <p>
                                                                        {`${val.membership_no}  - ${val.prename}${val.member_name}  ${val.member_surname}`}
                                                                    </p>
                                                                </div>
                                                                <div className="col-md-2 col-sm-6 col-xs-6 text-detail">
                                                                    <p>
                                                                        {convert_to_Thaidate(
                                                                            val.begining_of_contract
                                                                        )}
                                                                    </p>
                                                                </div>
                                                                <div className="col-md-2 col-sm-6 col-xs-6 text-detail">
                                                                    <p>
                                                                        {val.loan_approve_amount ==
                                                                        0
                                                                            ? `-`
                                                                            : number_format(
                                                                                  val.loan_approve_amount
                                                                              )}
                                                                    </p>
                                                                </div>
                                                                <div className="col-md-2 col-sm-6 col-xs-6 text-detail">
                                                                    <p
                                                                        style={{
                                                                            color:
                                                                                "#16A085"
                                                                        }}
                                                                    >
                                                                        {val.principal_balance ==
                                                                        0
                                                                            ? `-`
                                                                            : number_format(
                                                                                  val.principal_balance
                                                                              )}
                                                                    </p>
                                                                </div>
                                                                <div className="col-md-1 col-sm-6 col-xs-6">
                                                                    <p
                                                                        style={{
                                                                            textAlign:
                                                                                "right"
                                                                        }}
                                                                    >
                                                                        {number_format(
                                                                            val.used_amount
                                                                        )}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </Fragment>
                                                    );
                                                }
                                            )
                                        ) : (
                                            <div className="col-md-12">
                                                <br />
                                                <p
                                                    style={{
                                                        color: "red",
                                                        textAlign: "center",
                                                        fontSize: 20
                                                    }}
                                                >
                                                    ไม่มีข้อมูล
                                                </p>
                                            </div>
                                        ))}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
};

export default MemColl;
