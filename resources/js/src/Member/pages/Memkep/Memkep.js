import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";

import { feedMemKepActions, userActions } from "../../actions";
import { number_format, convert_to_Thaidate } from "../../../helpers";

import Headname from "./component/HeadName";
import Kep_detail from "./component/Kep_detail";
import { NotificationManager } from "react-notifications";
import MemSkeleton from "../Skeleton/MemLoan";
import { Modal } from "react-bootstrap";
// import Pagination from "rc-pagination";

const Memkep = () => {
    const dispatch = useDispatch();
    const feedMemKep = useSelector(state => state.feedMemKep);

    const [loading, setLoading] = useState(true);
    const [modalShow, setModalShow] = useState(false);

    useEffect(() => {
        if (feedMemKep.fetchSuccess) {
            setLoading(false);
        }
        return async function cleanup() {
            await setLoading(true);
        };
    }, [feedMemKep.fetchSuccess]);

    useEffect(() => {
        async function feedData() {
            await dispatch(
                feedMemKepActions.feedDataPost(`/api/member/member_kep`)
            );
        }
        feedData();
    }, [dispatch]);

    const prinreceipt = async (kep_method_amount, year, month, posted_run) => {
        if (posted_run != '0' && kep_method_amount == "0.00") {
            // return setModalShow(true);
            $('#myModal').modal('show');
            return;
        }

        let windowsOpen = window.open();

        dispatch(userActions.getAuthUser())
            .then(() => {
                let user = JSON.parse(localStorage.getItem("user"));

                windowsOpen.location = `api/member/print_pdf/${year}/${month}?token=${user.token}`;
            })
            .catch(err => {
                NotificationManager.error(err.data.error, "Error", 5000);
            });
    };

    return (
        <>
            {loading && <MemSkeleton />}
            {!loading && (
                <div className="container-fluid">
                    <div className="row">
                        {feedMemKep.fetchSuccess &&
                            Array.isArray(feedMemKep.data.datakeepdet) &&
                            feedMemKep.data.datakeepdet.length &&
                            feedMemKep.data.datakeepdet.map((val, i) => {
                                return (
                                    <div
                                        className="container wrimagecard"
                                        key={i}
                                    >
                                        <div clas="row">
                                            <div className="col-md-2 col-sm-12 col-xs-12">
                                                <div className="wrimagecard-topimage">
                                                    <Headname I={i} Val={val} />
                                                </div>
                                            </div>
                                            <div className="col-md-10 col-sm-12 col-xs-12">
                                                <div className="wrimagecard-topimage_title">
                                                    <div className="row">
                                                        <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                                            <label>
                                                                วันที่ใบเสร็จ:
                                                            </label>
                                                        </div>
                                                        <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                                            <p>
                                                                {convert_to_Thaidate(
                                                                    val.receipt_date
                                                                )}
                                                            </p>
                                                        </div>
                                                        <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                                            <label>
                                                                {val.posted_run ==
                                                                "1"
                                                                    ? `เงินที่เก็บได้:`
                                                                    : `เงินที่เรียกเก็บ:`}
                                                            </label>
                                                        </div>
                                                        <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                                            <p
                                                                className={`sum_money_amount${i}`}
                                                            >
                                                                {number_format(
                                                                    val.mproc_money_amount
                                                                )}
                                                                ฿
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                                            <label>
                                                                เลขที่ใบเสร็จ:
                                                            </label>
                                                        </div>
                                                        <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                                            <p>
                                                                {val.receipt_no}
                                                            </p>
                                                        </div>
                                                        <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                                            <label>
                                                                จำนวนรายการ:
                                                            </label>
                                                        </div>
                                                        <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                                            <p
                                                                className={`count_det${i}`}
                                                            >
                                                                {
                                                                    val.count_seqno
                                                                }{" "}
                                                                รายการ
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div className="row">
                                                        {/* <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                                            <label>
                                                                สถานะ:
                                                            </label>
                                                        </div>
                                                        <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                                            <p>
                                                                {val.posted_run ==
                                                                "0"
                                                                    ? "รอนำส่ง"
                                                                    : val.kep_method_amount ==
                                                                      "0.00"
                                                                    ? "หักไม่ได้"
                                                                    : val.receipt_status !=
                                                                      "0"
                                                                    ? "หักได้บางส่วน"
                                                                    : "หักได้ครบ"}
                                                            </p>
                                                        </div> */}
                                                        {/* ************************************************************** */}
                                                        {/* ************************************************************** */}
                                                        {/* <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                                            <label>จำนวนรายการ:</label>
                                                        </div>
                                                        <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                                            <p className={`count_det${i}`}>{val.count_seqno} รายการ</p>
                                                        </div> */}
                                                    </div>
                                                    <div className="row">
                                                        <div className="col-md-12">
                                                            <Kep_detail
                                                                i={i}
                                                                data={
                                                                    feedMemKep
                                                                        .data
                                                                        .datadetail[
                                                                        i
                                                                    ]
                                                                }
                                                            />

                                                            <div
                                                                className="pull-right"
                                                                onClick={() =>
                                                                    prinreceipt(
                                                                        val.kep_method_amount,
                                                                        val.receive_year,
                                                                        val.receive_month,
                                                                        val.posted_run
                                                                    )
                                                                }
                                                            >
                                                                <span
                                                                    style={{
                                                                        color:
                                                                            val.posted_run ==
                                                                            "0"
                                                                                ? "#16a085"
                                                                                : "#4267b2"
                                                                    }}
                                                                >
                                                                    <i
                                                                        className="fa fa-print fa-2x"
                                                                        style={{
                                                                            cursor:
                                                                                "pointer",
                                                                            fontSize: 46
                                                                        }}
                                                                    />
                                                                    <p
                                                                        style={{
                                                                            fontSize: 12
                                                                        }}
                                                                    >
                                                                        <a
                                                                            style={{
                                                                                color:
                                                                                    val.posted_run ==
                                                                                    "0"
                                                                                        ? "#16a085"
                                                                                        : "#4267b2"
                                                                            }}
                                                                        >
                                                                            {val.posted_run ==
                                                                            "0"
                                                                                ? "พิมพ์ใบแจ้งหนี้"
                                                                                : "พิมพ์ใบเสร็จ"}
                                                                        </a>
                                                                    </p>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                className="modal fade"
                                                tabIndex={-1}
                                                role="dialog"
                                                id="myModal"
                                            >
                                                <div
                                                    className="modal-dialog"
                                                    role="document"
                                                >
                                                    <div className="modal-content">
                                                        <div className="modal-header">
                                                            <button
                                                                type="button"
                                                                className="close"
                                                                data-dismiss="modal"
                                                                aria-label="Close"
                                                            >
                                                                <span aria-hidden="true">
                                                                    ×
                                                                </span>
                                                            </button>
                                                            <h4 className="modal-title">
                                                                แจ้งเตือน
                                                            </h4>
                                                        </div>
                                                        <div className="modal-body">
                                                            <p>
                                                            ไม่สามารถพิมพ์ใบเสร็จประจำเดือนได้
                                                            เนื่องจากไม่ได้รับชำระเงินภายในเวลาที่กำหนด
                                                            <br/>
                                                            กรุณาติดต่อเจ้าหน้าที่
                                                            </p>
                                                        </div>
                                                        {/* <div className="modal-footer">
                                                            <button
                                                                type="button"
                                                                className="btn btn-default"
                                                                data-dismiss="modal"
                                                            >
                                                                Close
                                                            </button>
                                                            <button
                                                                type="button"
                                                                className="btn btn-primary"
                                                            >
                                                                Save changes
                                                            </button>
                                                        </div> */}
                                                    </div>
                                                    {/* /.modal-content */}
                                                </div>
                                                {/* /.modal-dialog */}
                                            </div>
                                            {/* /.modal */}
                                        </div>
                                    </div>
                                );
                            })}
                    </div>
                </div>
            )}
        </>
    );
};

function ModelCentered(props) {
    return (
        <Modal
            {...props}
            aria-labelledby="contained-modal-title-vcenter"
            centered
        >
            <Modal.Header closeButton>
                <Modal.Title id="contained-modal-title-vcenter">
                    แจ้งเตือน
                </Modal.Title>
            </Modal.Header>
            <Modal.Body>
                {/* <h4>Centered Modal</h4> */}
                <p>
                    Cras mattis consectetur purus sit amet fermentum. Cras justo
                    odio, dapibus ac facilisis in, egestas eget quam. Morbi leo
                    risus, porta ac consectetur ac, vestibulum at eros.
                </p>
            </Modal.Body>
            {/* <Modal.Footer>
                <Button onClick={props.onHide}>Close</Button>
            </Modal.Footer> */}
        </Modal>
    );
}

export default Memkep;
