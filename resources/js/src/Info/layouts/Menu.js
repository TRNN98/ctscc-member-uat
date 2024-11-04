import React, { Fragment, useEffect } from "react";
import { Link, Route, useLocation } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
// import Responsive_header from "./Responsive_header";
import { feedmanuActions } from "../actions";
const Menu = () => {
    const authentication = useSelector(state => state.authentication);
    const feedManu = useSelector(state => state.feedManu);

    usePageViews();

    // -------------- Search -------------- //
    // =======================================
    $(".srch-btn").on("click", function() {
        $(".hdr-srch-bx").addClass("active");
        return false;
    });
    $(".srch-cls-btn").on("click", function() {
        $(".hdr-srch-bx").removeClass("active");
        return false;
    });
    // =======================================
    // --------------End Search -------------- //

    return (
        // <div className="menu-wrp3 sticky-header">
        //     <div className="container">
        //         <div className="logo" style={{padding: "4px 0px" }}><a href="index.html" title="Logo" itemProp="url"><img style={{width: "80px"}} src="info/assets/index/logo.png" alt="logo.png" itemProp="image" /></a></div>
        //         <nav>
        //             <div>
        //                 <ul>
        //                 { feedManu.fetchSuccess && feedManu.data.list_manu.map((val, i) => {
        //                     if (val.is_parent == '0') {
        //                         return (
        //                             <li className="menu-item-has-children" key={i}>
        //                                 <ItemLink to={val.url} topic={val.manu_name} />
        //                             </li>
        //                         )
        //                     }else{
        //                         return (
        //                             <li className="menu-item-has-children" key={i}>
        //                                 <a itemProp="url">{val.manu_name}</a>
        //                                 <ul className="children">
        //                                     { feedManu.data.list_sub_manu.filter(sub => sub.manu_id == val.seq).map((sub_m, i_m) => {
        //                                         return <ListItemLink to={sub_m.url} topic={sub_m.description} key={i_m} />
        //                                     })}
        //                                 </ul>
        //                             </li>
        //                         )
        //                     }

        //                 }) }

        //                     { authentication.loggedIn
        //                     ?
        //                         <li className="menu-item-has-children" style={{ paddingLeft: "100px"}}>
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
        //                             <li className="menu-item-has-children" style={{paddingLeft: "100px"}}>
        //                                 <Link to="/member/register"><button className="btn-primary" style={{minWidth: "110px", lineHeight: "35px"}}>สมัครสมาชิก</button></Link>
        //                             </li>
        //                             <li className="menu-item-has-children" style={{marginLeft: "10px"}}>
        //                                 <Link to="/member/logon"><button className="btn-primary" style={{minWidth: "110px", lineHeight: "35px"}}>เข้าสู่ระบบ</button></Link>
        //                             </li>
        //                         </Fragment>
        //                     }
        //                 </ul>

        //             </div>
        //         </nav>
        //     </div>
        // </div>
        // ================================================================================================
        <>
            <div
                className="menu-wrp3"
                style={{
                    backgroundImage:
                        "linear-gradient(to right, #45a8fe, #3dadfc, #39b1fa, #39b5f7, #3cb9f4)",
                    padding: 10
                }}
            >
                <div className="container">
                    <div className="row">
                        <div className="col-md-2">
                            <Link to="/home" title="Logo" itemProp="url">
                                <img
                                    src="info/assets/index/logo.png"
                                    alt="logo.png"
                                    itemProp="image"
                                />
                            </Link>
                        </div>
                        <div className="col-md-6">
                            <h2
                                className="m-t-xxxl coopname"
                                style={{
                                    fontSize: 24,
                                    fontWeight: "bold",
                                    color: "#f5f6f7"
                                }}
                            >
                                สหกรณ์ออมทรัพย์สาธารณสุขเพชรบุรี จำกัด
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            {/* ====== Menu Nav Bottom ====== */}
            <div className="menu-wrp3" style={{ backgroundColor : '#e1f5fe' }}>
                <div className="container">
                    <nav>
                        <div>
                            <a className="srch-btn" title itemProp="url">
                                <i className="fa fa-search" />
                            </a>
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
                                                    <a itemProp="url">
                                                        {val.manu_name}
                                                    </a>
                                                    <ul
                                                        className="children"
                                                        style={{
                                                            padding: "6px 0"
                                                        }}
                                                    >
                                                        {feedManu.data.list_sub_manu
                                                            .filter(
                                                                sub =>
                                                                    sub.manu_id ==
                                                                    val.seq
                                                            )
                                                            .map(
                                                                (
                                                                    sub_m,
                                                                    i_m
                                                                ) => {
                                                                    return (
                                                                        <ListItemLink
                                                                            to={
                                                                                sub_m.url
                                                                            }
                                                                            topic={
                                                                                sub_m.description
                                                                            }
                                                                            key={
                                                                                i_m
                                                                            }
                                                                        />
                                                                    );
                                                                }
                                                            )}
                                                    </ul>
                                                </li>
                                            );
                                        }
                                    })}
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div className="menu-wrp3 sticky-header">
                <div className="container">
                    <div className="logo">
                        <a href="index.html" title="Logo" itemProp="url">
                            <img
                                src="assets/images/logo.png"
                                alt="logo.png"
                                itemProp="image"
                            />
                        </a>
                    </div>
                    <nav>
                        <div>
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
                                                    <a itemProp="url">
                                                        {val.manu_name}
                                                    </a>
                                                    <ul className="children">
                                                        {feedManu.data.list_sub_manu
                                                            .filter(
                                                                sub =>
                                                                    sub.manu_id ==
                                                                    val.seq
                                                            )
                                                            .map(
                                                                (
                                                                    sub_m,
                                                                    i_m
                                                                ) => {
                                                                    return (
                                                                        <ListItemLink
                                                                            to={
                                                                                sub_m.url
                                                                            }
                                                                            topic={
                                                                                sub_m.description
                                                                            }
                                                                            key={
                                                                                i_m
                                                                            }
                                                                        />
                                                                    );
                                                                }
                                                            )}
                                                    </ul>
                                                </li>
                                            );
                                        }
                                    })}
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div className="hdr-srch-bx">
                <span className="srch-cls-btn">
                    <i className="fa fa-close" />
                </span>
                <form>
                    <input type="text" placeholder="Search your keywords..." />
                    <button type="submit">
                        <i className="fa fa-search" />
                    </button>
                </form>
            </div>
        </>
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

export default Menu;
