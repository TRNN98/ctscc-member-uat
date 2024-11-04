import React from "react";
import { Link } from "react-router-dom";
import Checker from "./ComponentPer.js/Checker";
import Committee from "./ComponentPer.js/Committee";
import Employee from "./ComponentPer.js/Employee";

const ListPersonnel = ({ data }) => {
    // console.log('l', data.list_data.data);
    return (
        <>
            <div className="content-inner container-fluid">
                <div className="row">
                    <div className="col-md-12">
                        <div className="news-list">
                            <div className="row item">
                                <div className="col-md-12">
                                    <div className="row">
                                        {data.list_data.data[0].Category ==
                                        "checker" ? (
                                            <Checker
                                                detail={data.list_data.data}
                                            />
                                        ) : data.list_data.data[0].Category ==
                                          "committee_info" ? (
                                            <Committee
                                                detail={data.list_data.data}
                                            />
                                        ) : (
                                            <Employee
                                                detail={data.list_data.data}
                                            />
                                        )}

                                        {/* ============================================================================================= */}
                                        {/* {data.list_data.data &&
                                            data.list_data.data.map((val, i) => (

                                                    <div className="col-md-6" style={{ marginBottom: 17 }}>
                                                        {val.Category}
                                                        <div className="card">
                                                            <div className="row">
                                                                <div className="col-md-5">
                                                                    <div className="card-imgbox">
                                                                        <img src={`mediafiles/${val.nphoto}`} className="img-responsive img-circle img-per" />
                                                                    </div>
                                                                </div>
                                                                <div className="col-md-7">
                                                                    <div className="card-text" style={{ padding: '2px 16px', marginTop: 70 }}>
                                                                        <h3><b>{val.Question}</b></h3>
                                                                        <hr style={{ borderTop: '1px solid #9e9e9e6b' }} />
                                                                        <h4>{val.Note}</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            )
                                            )} */}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default ListPersonnel;
