import React, { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'

import { feedMemGianActions } from '../../actions'

import MemSkeleton from '../Skeleton/MemLoan';

const Memgian = () => {

    const dispatch = useDispatch();
    const feedMemGian = useSelector(state => state.feedMemGian);

    const [loading, setLoading] = useState(true)

    useEffect(() => {
        if (feedMemGian.fetchSuccess) {
            setLoading(false);
        }
        return async function cleanup() {
            await setLoading(true);
        };
    }, [feedMemGian.fetchSuccess]);

    useEffect(() => {
        dispatch(feedMemGianActions.feedDataPost(`/api/member/member_gian`));
        // async function feedData() {
        //     await dispatch(feedMemGianActions.feedDataPost(`/api/member/member_gian`));
        // }
        // feedData();
    }, []);

    return (
        <>
            {loading && (
                <MemSkeleton/>
            )}
            {!loading && (
                <div className="container-fluid">
                    <div className="rowx">
                        <div className="panel panel-warning container wrimagecard" style={{ paddingLeft: 0, paddingRight: 0, boxShadow: '12px 15px 20px 0px rgba(187, 120, 36, 0.1)' }}>
                            <div className="panel-heading">
                                <h3 className="panel-title" style={{ fontWeight: 'bold' }}>
                                    ผู้รับโอนผลประโยชน์
                            {/* ลำดับที่ {'{'}{'{'} $i {'}'}{'}'} */}
                                </h3>
                            </div>
                            <div className="panel-body">
                                {feedMemGian.fetchSuccess && (Array.isArray(feedMemGian.data.gain) && feedMemGian.data.gain.length
                                    ? (feedMemGian.data.gain).map((val, i) => {
                                        return (
                                            <div className="row" style={{ marginBottom: 20 }} key={i}>
                                                <div className="col-md-2 col-sm-12 col-xs-12">
                                                    <div className="wrimagecard-topimage ">
                                                        <div className="wrimagecard-topimage_header" style={{ backgroundColor: 'rgba(187, 120, 36, 0.1)' }}>
                                                            <center><i className="fa fa-universal-access" style={{ color: '#BB7824' }} /></center>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="col-md-10 col-sm-12 col-xs-12">
                                                    <div className="wrimagecard-topimage_title">
                                                        <div className="row">
                                                            <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                                                <label>ชื่อ-สกุล:</label>
                                                            </div>
                                                            <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                                                <p>{val.GAIN_NAME}</p>
                                                            </div>
                                                            <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                                                <label>ความสัมพันธ์:</label>
                                                            </div>
                                                            <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                                                <p>{val.related_na}</p>
                                                            </div>

                                                            {/* <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                        <label>เปอร์เซ็นต์:</label>
                                        </div>
                                        <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                        @if ($itemgain-&gt;PERCENT_GAIN == null || $itemgain-&gt;PERCENT_GAIN == 0)
                                        <p style={{color: 'red'}}>[ยังไม่ได้ระบุ]</p>
                                        @else
                                        <p> {'{'}{'{'} number_format($itemgain-&gt;PERCENT_GAIN*100,2) {'}'}{'}'} % </p>
                                        @endif
                                        </div> */}

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
                    </div>
                </div>
            )}
        </>
    )
}

export default Memgian
