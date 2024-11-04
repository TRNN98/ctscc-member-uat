import React from "react";
import { Link } from "react-router-dom";
import Pagination from "rc-pagination";

function ListPhoto({ data, pagination }) {
    return (
        <div className="content-inner container">
            <div className="row">
                <div className="col-md-12">
                    <div className="album-list">
                        <div className="row">
                            {data.list_data &&
                                data.list_data.data.map((val, i) => (
                                    <div
                                        className="col-sm-4"
                                        style={{ padding: 10 }}
                                        key={i}
                                    >
                                        <div className="item">
                                            <div className="image">
                                                <Link to={`/show/${val.No}`}>
                                                    {val.nphoto != '' ? (
                                                        <img
                                                            className="img-responsive"
                                                            src={`mediafiles/${val.nphoto}`}
                                                        />
                                                    ) : (
                                                        <img
                                                            className="img-responsive"
                                                            src="mediafiles/images/pic.png"
                                                        />
                                                    )}
                                                </Link>
                                            </div>
                                            <div className="title">
                                                <Link to={`/show/${val.No}`}>
                                                    {val.Question}
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                        </div>

                        <div className="col-md-12 text-center">
                            {data.list_data && data.list_data.data.length > 0 && (
                                <Pagination
                                    defaultPageSize={6}
                                    className="pagination"
                                    locale={{
                                        // Options.jsx
                                        items_per_page: "/ หน้า",
                                        jump_to: "ไปยัง",
                                        jump_to_confirm: "ยืนยัน",
                                        page: "",

                                        // Pagination.jsx
                                        prev_page: "หน้าก่อนหน้า",
                                        next_page: "หน้าถัดไป",
                                        prev_5: "ย้อนกลับ 5 หน้า",
                                        next_5: "ถัดไป 5 หน้า",
                                        prev_3: "ย้อนกลับ 3 หน้า",
                                        next_3: "ถัดไป 3 หน้า"
                                    }}
                                    onChange={pagination}
                                    current={data.list_data.current_page}
                                    total={data.list_data.total}
                                    prevIcon={
                                        <a className="page-link" itemProp="url">
                                            <i className="fa fa-angle-left" />{" "}
                                            PREVIOUS
                                        </a>
                                    }
                                    nextIcon={
                                        <a className="page-link" itemProp="url">
                                            NEXT{" "}
                                            <i className="fa fa-angle-right" />
                                        </a>
                                    }
                                    jumpNextIcon="..."
                                    jumpPrevIcon="..."
                                />
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default ListPhoto;
