import React from "react";

const Checker = ({ detail }) => {
    return (
        <div style={{ padding: " 0 90px", textAlign: "center" }}>
            {/* ================================  ที่ปรึกษา ==================================== */}
            <div
                className="col-md-6 col-sm-12 col-xs-12"
                style={{ padding: 0 }}
            >
                <div className="row">
                    <h2
                        style={{
                            fontSize: 30,
                            fontWeight: "bold",
                            color: "orangered"
                        }}
                    >
                        ผู้ตรวจสอบกิจการ
                    </h2>
                    {detail &&
                        detail.map((val, i) =>
                            i + 1 > 2 && i + 1 < 5 ? (
                                <div className="col-md-6 col-sm-12 col-xs-12">
                                    <div
                                        className="card"
                                        style={{ marginBottom: 35 }}
                                    >
                                        <div className="card-imgbox">
                                            <img
                                                src={`mediafiles/${val.nphoto}`}
                                                className="img-responsive img-circle img-per"
                                            />
                                        </div>
                                        <div
                                            className="card-text"
                                            style={{
                                                padding: "2px 16px"
                                            }}
                                        >
                                            <h3>
                                                <b>{val.Question}</b>
                                            </h3>
                                            <hr
                                                style={{
                                                    borderTop:
                                                        "1px solid #9e9e9e6b"
                                                }}
                                            />
                                            <h4>{val.Note}</h4>
                                        </div>
                                    </div>
                                </div>
                            ) : (
                                i + 1 >= 5 && (
                                    <div className="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
                                        <div
                                            className="card"
                                            style={{ marginBottom: 35 }}
                                        >
                                            <div className="card-imgbox">
                                                <img
                                                    src={`mediafiles/${val.nphoto}`}
                                                    className="img-responsive img-circle img-per"
                                                />
                                            </div>
                                            <div
                                                className="card-text"
                                                style={{
                                                    padding: "2px 16px"
                                                }}
                                            >
                                                <h3>
                                                    <b>{val.Question}</b>
                                                </h3>
                                                <hr
                                                    style={{
                                                        borderTop:
                                                            "1px solid #9e9e9e6b"
                                                    }}
                                                />
                                                <h4>{val.Note}</h4>
                                            </div>
                                        </div>
                                    </div>
                                )
                            )
                        )}
                </div>
            </div>
            {/* ================================  ผู้ตรวจสอบกิจการ ==================================== */}
            <div
                className="col-md-6 col-sm-12 col-xs-12"
                style={{ padding: 0 }}
            >
                {detail &&
                    detail.map(
                        (val, i) =>
                            i + 1 <= 2 && (
                                <>
                                    <div className="col-md-8 col-md-offset-3  col-sm-12 col-xs-12">
                                        <h2
                                            style={{
                                                fontSize: 30,
                                                fontWeight: "bold",
                                                color: "orangered"
                                            }}
                                        >
                                            {i + 1 == 1
                                                ? "ที่ปรึกษาสหกรณ์"
                                                : "ที่ปรึกษาจากส่วนราชการ"}
                                        </h2>
                                    </div>
                                    <div className="col-md-8 col-md-offset-3 col-sm-12 col-xs-12">
                                        <div
                                            className="card"
                                            style={{ marginBottom: 35 }}
                                        >
                                            <div className="card-imgbox">
                                                <img
                                                    src={`mediafiles/${val.nphoto}`}
                                                    className="img-responsive img-circle img-per"
                                                />
                                            </div>
                                            <div
                                                className="card-text"
                                                style={{
                                                    padding: "2px 16px"
                                                }}
                                            >
                                                <h3>
                                                    <b>{val.Question}</b>
                                                </h3>
                                                <hr
                                                    style={{
                                                        borderTop:
                                                            "1px solid #9e9e9e6b"
                                                    }}
                                                />
                                                <h4>{val.Note}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </>
                            )
                    )}
            </div>
        </div>
    );
};

export default Checker;
