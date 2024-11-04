import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { convert_to_Thaidate, createMarkup } from "../../../helpers";

import { feedMemCremActions } from "../../actions";

import MemSkeleton from "../Skeleton/MemLoan";

const Memcrem = () => {
    const dispatch = useDispatch();
    const feedMemCrem = useSelector(state => state.feedMemCrem);

    const [loading, setLoading] = useState(true);

    useEffect(() => {
        if (feedMemCrem.fetchSuccess) {
            setLoading(false);
        }
        return async function cleanup() {
            await setLoading(true);
        };
    }, [feedMemCrem.fetchSuccess]);

    useEffect(() => {
        dispatch(feedMemCremActions.feedDataPost(`/api/member/member_crem`));
        // async function feedData() {
        //     await dispatch(feedMemGianActions.feedDataPost(`/api/member/member_gian`));
        // }
        // feedData();
    }, []);

    return (
        <div className="container-fiuld">
            {loading && <MemSkeleton />}
            {!loading && feedMemCrem.fetchSuccess && (
                <div className="row">
                    <div className="col-md-10 col-md-offset-1">
                        <div className="panel panel-info wrimagecard">
                            <div className="panel-heading">
                                <h3
                                    className="panel-title"
                                    style={{ fontWeight: "bold" }}
                                >
                                    สมาคมฌาปนกิจ
                                </h3>
                            </div>
                            <div className="panel-body">
                                <div className="row">
                                    <div className="col-md-6">
                                        <div className="table-responsive">
                                            <table className="table">
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            className="td-caption"
                                                            style={{
                                                                width: "23%"
                                                            }}
                                                        >
                                                            <label>
                                                                ชื่อ-นามสกุล :
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {
                                                                feedMemCrem.data
                                                                    .crem
                                                                    .MEMBER_NAME
                                                            }{" "}
                                                            {
                                                                feedMemCrem.data
                                                                    .crem
                                                                    .MEMBER_SURNAME
                                                            }
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>
                                                                ประเภทสมาชิก :
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {
                                                                feedMemCrem.data
                                                                    .crem
                                                                    .DESCRIPTION
                                                            }
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>
                                                                {" "}
                                                                วันเกิด :
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {convert_to_Thaidate(
                                                                feedMemCrem.data
                                                                    .crem
                                                                    .DATE_OF_BIRTH
                                                            )}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>
                                                                {" "}
                                                                อายุ :
                                                            </label>
                                                        </td>
                                                        <td
                                                            dangerouslySetInnerHTML={createMarkup(
                                                                feedMemCrem.data
                                                                    .date_of_birth
                                                            )}
                                                        ></td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>
                                                                ที่อยู่ :
                                                            </label>
                                                        </td>
                                                        <td
                                                            style={{
                                                                maxWidth: 230,
                                                                height: 75
                                                            }}
                                                        >
                                                            {
                                                                feedMemCrem.data
                                                                    .crem
                                                                    .ADDRESS_PRESENT
                                                            }
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>
                                                                วิธีการชำระ :
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {
                                                                feedMemCrem.data
                                                                    .crem
                                                                    .KEEP_DESC
                                                            }
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>
                                                                ยอดคงเหลือ :
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {
                                                                feedMemCrem.data
                                                                    .crem
                                                                    .CREM_BALANCE
                                                            }
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div className="col-md-6">
                                        <div className="table-responsive">
                                            <table className="table tbCremRight">
                                                <tbody>
                                                    <tr>
                                                        <td className="td-caption hed">
                                                            <label>
                                                                สถานะ :
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {feedMemCrem.data
                                                                .crem
                                                                .MEMBER_STATUS_CODE ==
                                                            "0"
                                                                ? "ปกติ"
                                                                : feedMemCrem
                                                                      .data.crem
                                                                      .MEMBER_STATUS_CODE ==
                                                                      "3" &&
                                                                  "ลาออก"}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>
                                                                หน่วยงาน :
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {
                                                                feedMemCrem.data
                                                                    .group
                                                                    .MEMBER_GROUP_NAME
                                                            }
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>
                                                                วันที่เป็นสมาชิก
                                                                :
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {convert_to_Thaidate(
                                                                feedMemCrem.data
                                                                    .crem
                                                                    .APPLY_DATE
                                                            )}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>
                                                                บัตร ปชช :
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {
                                                                feedMemCrem.data
                                                                    .crem
                                                                    .ID_CARD
                                                            }
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>เพศ :</label>
                                                        </td>
                                                        <td>
                                                            {feedMemCrem.data
                                                                .crem.SEX == "M"
                                                                ? "ชาย"
                                                                : "หญิง"}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>
                                                                รอเรียกเก็บ :
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {
                                                                feedMemCrem.data
                                                                    .crem
                                                                    .PENDING_AMOUNT
                                                            }
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>
                                                                สงเคราะห์ศพผู้อื่น
                                                                :
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {
                                                                feedMemCrem.data
                                                                    .crem
                                                                    .CREM_ARREAR
                                                            }
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td className="td-caption">
                                                            <label>
                                                                ยอดคงเหลือหลังหัก
                                                                :
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {
                                                                ( (feedMemCrem.data.crem.CREM_BALANCE ) - (feedMemCrem.data.crem.CREM_ARREAR) )
                                                            }
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default Memcrem;
