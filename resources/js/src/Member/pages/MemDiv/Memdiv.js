import React, { useEffect, Fragment, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'

import { feedMemDivActions } from '../../actions'
import { number_format, convert_to_Thaidate } from '../../../helpers';

import MemSkeleton from '../Skeleton/MemLoan';

const Memdiv = () => {

    const dispatch = useDispatch();
    const feedMemDiv = useSelector(state => state.feedMemDiv);

    const [loading, setLoading] = useState(true)

    useEffect(() => {
        if (feedMemDiv.fetchSuccess) {
            setLoading(false);
        }
        return async function cleanup() {
            await setLoading(true);
        };
    }, [feedMemDiv.fetchSuccess]);

    useEffect(() => {
        async function feedData() {
            await dispatch(feedMemDivActions.feedDataPost(`/api/member/member_div`));
        }
        feedData();
    }, []);

    return (
        <Fragment>
            <style type="text/css" dangerouslySetInnerHTML={{ __html: "\n @media screen and (max-width: 768px){\n tr{\n font-size: 10px;\n }\n }\n " }} />
            {loading && (
                <MemSkeleton />
            )}
            {!loading && (
                <div className="container-fluid">
                    <div className="rowx">

                        {feedMemDiv.fetchSuccess && (Array.isArray(feedMemDiv.data.div) && feedMemDiv.data.div.length
                            ? (feedMemDiv.data.div).map((val, i) => {

                                let p_acc_year = val.account_year + 543;
                                let p_dividend = val.drop_dividend == "1" ? "งด" : number_format(parseFloat(val.dividend));
                                // let p_dividend = number_format(parseFloat(val.dividend));
                                let p_avg_return = val.drop_average == "1" ? "งด" : number_format(parseFloat(val.average_return));
                                // let p_total_div_avg = number_format(parseFloat(val.dividend) + parseFloat(val.average_return));
                                // let p_del_insure	=	number_format(parseFloat(val.insurance_amount));
                                let p_total_receive_dividend = number_format(parseFloat(val.dividend) + parseFloat(val.average_return));

                                return (
                                    <div className="panel panel-info container wrimagecard" style={{ paddingLeft: 0, paddingRight: 0, boxShadow: '12px 15px 20px 0px rgba(22, 160, 133, 0.1)' }} key={i}>
                                        <div className="panel-heading">
                                            <h3 className="panel-title" style={{ fontWeight: 'bold' }}>
                                                เงินปันผล-เงินเฉลี่ยคืน
                            </h3>
                                        </div>
                                        <div className="panel-body">
                                            <div className="col-md-2 col-sm-12 col-xs-12">
                                                <div className="wrimagecard-topimage_header" style={{ backgroundColor: 'rgba(51, 105, 232, 0.1)' }}>
                                                    <center><i style={{ color: '#3369e8', fontSize: 40 }}>{p_acc_year}</i></center>
                                                    <center><i style={{ color: '#3369e8', fontSize: 15 }}>  รวมจ่าย </i></center>
                                                    <center><i style={{ color: '#3369e8', fontSize: 20 }}> {p_total_receive_dividend} ฿</i></center>
                                                </div>

                                            </div>
                                            {/* </div> */}
                                            <div className="col-md-10 col-sm-12 col-xs-12">
                                                <div className="wrimagecard-topimage_title">
                                                    <div className="row">
                                                        <div className="col-md-6 col-sm-12 col-xs-12 text-caption">
                                                            <label>ปันผล : </label>&nbsp;<strong>{number_format(val.share_rate)}%</strong>
                                                        </div>
                                                        <div className="col-md-6 col-sm-12 col-xs-12 text-caption">
                                                            <label>เฉลี่ยคืน : </label>&nbsp;<strong>{number_format(val.lonint_rate)}%</strong>
                                                        </div>

                                                        <div className="col-md-6 col-sm-12 col-xs-12 text-caption">
                                                            <label>เงินปันผล(บาท) : </label>&nbsp;<strong>{p_dividend}</strong>
                                                        </div>
                                                        {/* <div className="col-md-3 col-sm-12 col-xs-12 text-detail">
                                            <p className="text-right" style={{color: '#333'}}>
                                                <strong>{p_dividend}</strong>
                                            </p>
                                        </div> */}
                                                        <div className="col-md-6 col-sm-12 col-xs-12 text-caption">
                                                            <label>เงินเฉลี่ยคืน(บาท) : </label>&nbsp;<strong>{p_avg_return}</strong>
                                                        </div>
                                                        {/* <div className="col-md-3 col-sm-12 col-xs-12 text-detail">
                                            <p className="text-right" style={{color: '#333'}}>
                                                <strong>{p_avg_return}</strong>
                                            </p>
                                        </div> */}
                                                        {/* <div className="col-md-3 col-sm-12 col-xs-12 text-caption">
                                            <label className="text-right">ตัดประกันชีวิต(บาท):</label>
                                        </div>
                                        <div className="col-md-3 col-sm-12 col-xs-12 text-detail">
                                            <p className="text-right" style={{color: 'red'}}>
                                                {p_del_insure}
                                            </p>
                                        </div> */}
                                                        <div className="col-md-6 col-sm-12 col-xs-12 text-caption">
                                                            <label>รับสุทธิ(บาท) : </label>&nbsp;<strong>{p_total_receive_dividend}</strong>
                                                        </div>

                                                        <div className="col-md-12 col-sm-12 col-xs-12 text-caption">
                                                            {/* <label>รับสุทธิ(บาท) : </label>&nbsp; */}
                                                            <strong>{val.bank_des}</strong>
                                                        </div>
                                                        {/* <div className="col-md-3 col-sm-12 col-xs-12 text-detail">
                                            <p className="text-right" style={{color: '#333'}}>
                                                <strong>{p_total_receive_dividend}</strong>
                                            </p>
                                        </div> */}
                                                    </div>
                                                    <hr />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                )
                            }) : (
                                <p align="center" style={{ color: 'red', fontSize: 30 }}> ไม่มีข้อมูล </p>
                            )
                        )}
                    </div>
                </div>

            )}
        </Fragment>
    )
}

export default Memdiv
