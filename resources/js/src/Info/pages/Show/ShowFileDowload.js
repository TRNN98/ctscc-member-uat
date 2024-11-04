import React from "react";

function showFileDowload({ data, nlink }) {
    return (
        <div id="tgl1" className="tgl-styl style3">
            {data && (
                <div className="tgl-itm">
                    <h4>
                        ดาวน์โหลดไฟล์
                        <i className="fa fa-plus" />
                    </h4>
                    <div className="tgl-cnt">
                        <p>
                            {nlink == "uselink" ? (
                                <a href={`${data}`} target="_blank">
                                    {">>ดูไฟล์เพิ่มเติม<<"}
                                </a>
                            ) : (
                                <a href={`mediafiles/${data}`} target="_blank">
                                    {data}
                                </a>
                            )}
                        </p>
                    </div>
                </div>
            )}
        </div>
    );
}

export default showFileDowload;
