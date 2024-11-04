import React from "react";

import { Accordion, Button } from "react-bootstrap";
import { number_format } from "../../../../helpers";

function Kep_detail({ i: i, data: datadetail }) {
    let sum_money_amount = 0,
        contdet = 0;
    // console.log("t", i);
    return (
        <Accordion>
            <h2 className="mb-0" style={{ textAlign: "right" }}>
                <Accordion.Toggle as={Button} variant="link" eventKey={`kepDetail${i}`}>
                    {" "}
                    รายละเอียด{" "}
                </Accordion.Toggle>
            </h2>
            <Accordion.Collapse
                eventKey={`kepDetail${i}`}
                style={{ backgroundColor: "rgba(238, 238, 238)" }}
            >
                <div className="table-responsive">
                    <table
                        className="table table-bordered"
                        style={{ fontSize: 14 }}
                    >
                        <thead>
                            <tr className="bg-primary">
                                <th style={{ textAlign: "center" }}>ลำดับ</th>
                                <th style={{ textAlign: "center" }}>ประเภท</th>
                                <th style={{ textAlign: "center" }}>เงินต้น</th>
                                <th style={{ textAlign: "center" }}>
                                    ดอกเบี้ย
                                </th>
                                <th style={{ textAlign: "center" }}>
                                    เงินเรียกเก็บ
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {datadetail.length &&
                                datadetail.map((valdet, idet) => {
                                    if (idet == 0) {
                                        contdet = 0;
                                        sum_money_amount = 0;
                                    }
                                    sum_money_amount =
                                        sum_money_amount +
                                        parseFloat(
                                            valdet.mproc_money_amount == null
                                                ? 0
                                                : valdet.mproc_money_amount
                                        );
                                    contdet = contdet + 1;

                                    return (
                                        <tr key={idet}>
                                            <td className="text-center">
                                                <p style={{ fontSize: 12 }}>
                                                    {idet + 1}
                                                </p>
                                            </td>
                                            <td>
                                                <p style={{ fontSize: 12 }}>
                                                    {valdet.KEEPING_TYPE_NAME}
                                                </p>
                                            </td>
                                            <td className="text-right">
                                                <p style={{ fontSize: 12 }}>
                                                    {number_format(
                                                        valdet.mproc_principal_of_loan
                                                    )}
                                                </p>
                                            </td>
                                            <td className="text-right">
                                                <p style={{ fontSize: 12 }}>
                                                    {number_format(
                                                        valdet.mproc_interest
                                                    )}
                                                </p>
                                            </td>
                                            <td className="text-right">
                                                <p style={{ fontSize: 12 }}>
                                                    {number_format(
                                                        valdet.mproc_money_amount
                                                    )}
                                                </p>
                                            </td>
                                        </tr>
                                    );
                                })}
                            <tr>
                                <td className="text-right">
                                    <p style={{ fontSize: 12 }}>รวม:</p>
                                </td>
                                <td colSpan={6} className="text-right">
                                    <p style={{ fontSize: 12 }}>
                                        {" "}
                                        {number_format(sum_money_amount)}{" "}
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </Accordion.Collapse>
        </Accordion>
    );
}

export default Kep_detail;
