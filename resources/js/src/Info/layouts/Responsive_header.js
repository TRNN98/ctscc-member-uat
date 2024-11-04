import React, { useEffect, Fragment } from "react";
import { Link, Route, useLocation } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { feedmanuActions } from "../actions";

const Responsive_header = () => {
    const authentication = useSelector(state => state.authentication);
    const feedManu = useSelector(state => state.feedManu);

    usePageViews();

    // useEffect(() => {
    //     $(".rsnp-mnu li.menu-item-has-children > a").on("click", function() {
    //         $(this)
    //             .parent()
    //             .siblings()
    //             .children("ul")
    //             .slideUp();
    //         $(this)
    //             .parent()
    //             .siblings()
    //             .removeClass("active");
    //         $(this)
    //             .parent()
    //             .children("ul")
    //             .slideToggle();
    //         $(this)
    //             .parent()
    //             .toggleClass("active");
    //         return false;
    //     });

    //     return () => {
    //         $(".rsnp-mnu li.menu-item-has-children > a").prop("onclick", null);
    //         $(".rsnp-mnu li.menu-item-has-children > a").removeAttr("onclick");
    //     };
    // }, [feedManu]);

    $(".rspn-mnu-btn").on("click", function() {
        $(".rsnp-mnu").addClass("slidein");
        return false;
    });
    $(".rspn-mnu-cls").on("click", function() {
        $(".rsnp-mnu").removeClass("slidein");
        return false;
    });

    return (
        // <div className="rspn-hdr">
        //     <div className="lg-mn">
        //         <div className="logo" style={{ paddingRight: '10px' }}>
        //             {/* <a href="index.html" title="Logo" itemProp="url"> */}
        //                 <img style={{width: "50px"}} src="info/assets/index/ICO.png" itemProp="image" />
        //             {/* </a> */}
        //         </div>
        //         <h5>
        //             สหกรณ์ออมทรัพย์ครูสมุทรสงคราม จำกัด
        //         </h5>
        //         <span className="rspn-mnu-btn"><i className="fa fa-align-center" /></span>
        //     </div>
        //     <div className="rsnp-mnu">
        //         <span className="rspn-mnu-cls"><i className="fa fa-times" /></span>
        //         <ul>
        //             { feedManu.fetchSuccess && feedManu.data.list_manu.map((val, i) => {
        //                 if (val.is_parent == '0') {
        //                     return (
        //                         <li key={i}>
        //                             <ItemLink to={val.url} topic={val.manu_name} />
        //                         </li>
        //                     )
        //                 }else{
        //                     return (
        //                         <li className="menu-item-has-children" key={i}>
        //                             <a itemProp="url">{val.manu_name}</a>
        //                             <ul className="children">
        //                                 { feedManu.data.list_sub_manu.filter(sub => sub.manu_id == val.seq).map((sub_m, i_m) => {
        //                                     return <ListItemLink to={sub_m.url} topic={sub_m.description} key={i_m} />
        //                                 })}
        //                             </ul>
        //                         </li>
        //                     )
        //                 }

        //             }) }
        //             { authentication.loggedIn
        //                     ?
        //                         <li style={{ paddingTop: "100px"}}>
        //                             <Route
        //                                 path="/member/status"
        //                                 children={() => (
        //                                     <Link to="/member/status">
        //                                         <button className="btn-primary" style={{minWidth: "170px", lineHeight: "50px"}}>
        //                                                 <div itemProp="url"><i className="fa fa-user-circle-o" /> {`${authentication.user.member.PRENAME}${authentication.user.member.MEMBER_NAME} ${authentication.user.member.MEMBER_SURNAME}`}</div>
        //                                             </button>
        //                                         {/* <button className="btn-primary" style={{minWidth: "170px", lineHeight: "35px"}}>
        //                                             <div itemProp="url">ยินดีต้อนรับ <br/>{`${authentication.user.member.PRENAME}${authentication.user.member.MEMBER_NAME} ${authentication.user.member.MEMBER_SURNAME}`}</div>
        //                                         </button> */}
        //                                     </Link>
        //                                 )}
        //                             />

        //                         </li>
        //                         : <Fragment>
        //                             <li style={{paddingTop: "100px"}}>
        //                                 <Link to="/member/register"><button className="btn-primary" style={{minWidth: "110px", lineHeight: "35px"}}>สมัครสมาชิก</button></Link>
        //                             </li>
        //                             <li style={{marginTop: "10px"}}>
        //                                 <Link to="/member/logon"><button className="btn-primary" style={{minWidth: "110px", lineHeight: "35px"}}>เข้าสู่ระบบ</button></Link>
        //                             </li>
        //                         </Fragment>
        //                     }
        //         </ul>
        //     </div>{/* Responsive Menu */}
        // </div>
        // ========================================================================================

        <div className="rspn-hdr">
            <div className="lg-mn">
                <div className="logo">
                    <a href="index.html" title="Logo" itemProp="url">
                        <img
                            src="info/assets/index/logo.png"
                            alt="logo.png"
                            itemProp="image"
                        />
                    </a>
                </div>
                <span className="rspn-mnu-btn">
                    <i className="fa fa-align-center" />
                </span>
            </div>
            <div className="rsnp-mnu">
                <span className="rspn-mnu-cls">
                    <i className="fa fa-times" />
                </span>
                <ul>
                    {feedManu.fetchSuccess &&
                        feedManu.data.list_manu.map((val, i) => {
                            if (val.is_parent == "0") {
                                return (
                                    <li
                                        className="menu-item-has-children"
                                        key={i}
                                    >
                                        <ItemLink
                                            to={val.url}
                                            topic={val.manu_name}
                                        />
                                    </li>
                                );
                            } else {
                                return (
                                    <li
                                        className="menu-item-has-children"
                                        key={i}
                                    >
                                        <a itemProp="url">{val.manu_name}</a>
                                        <ul className="children">
                                            {feedManu.data.list_sub_manu
                                                .filter(
                                                    sub =>
                                                        sub.manu_id == val.seq
                                                )
                                                .map((sub_m, i_m) => {
                                                    return (
                                                        <ListItemLink
                                                            to={sub_m.url}
                                                            topic={
                                                                sub_m.description
                                                            }
                                                            key={i_m}
                                                        />
                                                    );
                                                })}
                                        </ul>
                                    </li>
                                );
                            }
                        })}
                </ul>
            </div>
        </div>
    );
};

function ItemLink({ to, topic, ...rest }) {
    return (
        <Route
            path={to}
            children={({ match }) => (
                <Link itemProp="url" to={to} {...rest}>
                    {topic}
                </Link>
            )}
        />
    );
}

function ListItemLink({ to, topic, ...rest }) {
    return (
        <Route
            path={to}
            children={({ match }) => (
                <li>
                    <Link itemProp="url" to={to} {...rest}>
                        {topic}
                    </Link>
                </li>
            )}
        />
    );
}

function usePageViews() {
    let location = useLocation();
    const dispatch = useDispatch();
    const feedManu = useSelector(state => state.feedManu);

    useEffect(() => {
        async function feedData() {
            await dispatch(feedmanuActions.feedData(`/api/info/manu`));
        }
        if (feedManu.fetchSuccess == false) {
            feedData();
        }

        $(".rsnp-mnu").removeClass("slidein");

        //   ga.send(["pageview", location.pathname]);
    }, [location]);
}

export default Responsive_header;
