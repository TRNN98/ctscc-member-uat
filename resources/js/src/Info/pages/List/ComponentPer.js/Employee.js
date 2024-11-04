import React from "react";

const Employee = ({ detail }) => {
    return (
        <div
            style={{ padding: " 0 90px", textAlign: "center" }}
            className="box-employee"
        >
            {/* ================================  เจ้าหน้าที่ (ฝ่ายจัดการ) ==================================== */}
            <h2
                style={{
                    fontSize: 30,
                    fontWeight: "bold",
                    color: "orangered"
                }}
            >
                ฝ่ายจัดการ
            </h2>
            <div
                className="col-md-12 col-sm-12 col-xs-12"
                style={{ padding: 0 }}
            >
                {console.log(detail)}
                {detail &&
                    detail.map((val, i) => {
                        if (i + 1 == 5) {
                            return (
                                <>
                                    <div
                                        className="col-md-1 col-sm-12 col-xs-12"
                                        style={{ padding: 0 }}
                                    />
                                    <div
                                        className={`${
                                            i + 1 == 1
                                                ? `col-md-6 col-md-offset-3` // < ======= รูปที่ 1
                                                : i + 1 > 1 && i + 1 < 5 // <===== รูปที่ 2 - 4
                                                ? `col-md-4`
                                                : `col-md-2`
                                        } col-sm-12 col-xs-12`}
                                        style={{
                                            padding:
                                                i + 1 == 1
                                                    ? "0 150px"
                                                    : i + 1 > 1 && i + 1 < 5
                                                    ? "0 40px"
                                                    : "0 5px"
                                        }}
                                    >
                                        <div
                                            className="card"
                                            style={{ marginBottom: 35 }}
                                        >
                                            <div className="card-imgbox">
                                                <img
                                                    src={`mediafiles/${val.nphoto}`}
                                                    className="img-responsive img-circle img-per"
                                                    style={{ padding: 13 }}
                                                />
                                            </div>
                                            <div
                                                className="card-text"
                                                style={{
                                                    padding: "2px 16px"
                                                }}
                                            >
                                                <h6>
                                                    <b>{val.Question}</b>
                                                </h6>
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
                            );
                        } else {
                            return (
                                <div
                                    className={`${
                                        i + 1 == 1
                                            ? `col-md-6 col-md-offset-3` // < ======= รูปที่ 1
                                            : i + 1 > 1 && i + 1 <= 5 // <===== รูปที่ 2 - 4
                                            ? `col-md-4`
                                            : `col-md-2`
                                    } col-sm-12 col-xs-12`}
                                    style={{
                                        padding:
                                            i + 1 == 1
                                                ? "0 150px"
                                                : i + 1 > 1 && i + 1 <= 5
                                                ? "0 40px"
                                                : "0 5px"
                                    }}
                                >
                                    <div
                                        className="card"
                                        style={{ marginBottom: 35 }}
                                    >
                                        <div className="card-imgbox">
                                            <img
                                                src={`mediafiles/${val.nphoto}`}
                                                className="img-responsive img-circle img-per"
                                                style={{ padding: 13 }}
                                            />
                                        </div>
                                        <div
                                            className="card-text"
                                            style={{
                                                padding: "2px 16px"
                                            }}
                                        >
                                            <h6>
                                                <b>{val.Question}</b>
                                            </h6>
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
                            );
                        }

                        if (detail.length - 1 == i) {
                            return (
                                <div
                                    className="col-md-1 col-sm-12 col-xs-12"
                                    style={{ padding: 0 }}
                                />
                            );
                        }
                    })}
            </div>
        </div>
    );
};

export default Employee;
