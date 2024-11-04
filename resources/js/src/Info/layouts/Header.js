import React, { useEffect, Fragment } from "react";
import { Link, Route, useLocation, useHistory } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import useForm from "react-hook-form";

import { feedmanuActions } from "../actions";

const Header = () => {
    // const authentication = useSelector(state => state.authentication);
    const feedManu = useSelector(state => state.feedManu);
    let history = useHistory();
    const { register, handleSubmit } = useForm();

    usePageViews();

    const onSubmit = async (data, e) => {
        e.preventDefault();

        await setTimeout(
            history.push("/list/search", { search: data.search }),
            100
        );

        e.target.reset();
    };

    $(function() {
        if ($.isFunction($.fn.smartmenus)) {
            $("#main-menu").smartmenus({
                subMenusSubOffsetX: 1,
                subMenusSubOffsetY: -8
            });
        }
    });

    // -- Scroll

    return (
        <Fragment>
            {/* background area header */}
            <div
                className="navbar navbar-fixed-top1"
                style={{ margin: 0, padding: "15px 0" }}
            >
                <div className="container">
                    <div className="row">
                        <div className="col-xs-2 col-md-2 no-s logo-sec">
                            <img
                                src="/info/assets/index/logo.png"
                                width={185}
                            />
                        </div>
                        <div className="col-xs-8 col-md-7">
                            <h2
                                className="m-t-xxxl coopname"
                                style={{
                                    fontSize: 30,
                                    fontWeight: "bold",
                                    color: "#fff"
                                }}
                            >
                                สหกรณ์ออมทรัพย์สาธารณสุขเพชรบุรี จำกัด
                            </h2>
                            <h3
                                className="coopname_eng no-m"
                                style={{
                                    paddingTop: 5,
                                    color: "#fff",
                                    fontSize: 20
                                }}
                            >
                                Phetchaburi Public Health Saving {"&"} Credit
                                Cooperative Limited.
                            </h3>
                        </div>
                        <div className="col-sm-6 col-md-3 hidden-xs m-t-xxxl">
                            <form
                                name="search-form"
                                id="search-form"
                                onSubmit={handleSubmit(onSubmit)}
                            >
                                <div className="form-group has-feedback m-t-xxl">
                                    <input
                                        id="search"
                                        type="text"
                                        className="form-control"
                                        name="search"
                                        placeholder="ค้นหา"
                                        autoComplete="off"
                                        ref={register}
                                        style={{ border: "2px solid #dd6f27" }}
                                    />
                                    <button
                                        style={{
                                            pointerEvents: "auto",
                                            border: "none",
                                            "border-radius": "6px",
                                            background: "transparent"
                                        }}
                                        type="submit"
                                        className="glyphicon glyphicon-search form-control-feedback"
                                        aria-hidden="true"
                                    />
                                </div>
                            </form>
                        </div>

                        <button
                            type="button"
                            className="navbar-toggle collapsed"
                            onClick={() => $(".menu").slideToggle("slow")}
                            style={{
                                position: "relative",
                                bottom: -10,
                                right: 10,
                                width: 45,
                                backgroundColor: "rgb(21 21 21)"
                            }}
                        >
                            <span className="sr-only">Toggle navigation</span>
                            <span className="icon-bar" />
                            <span className="icon-bar" />
                            <span className="icon-bar" />
                        </button>
                    </div>
                </div>
            </div>

            {/* search area Box */}
            {/* <div className="search-area-box">
                <form
                    name="search-form"
                    id="search-form"
                    onSubmit={handleSubmit(onSubmit)}
                >
                    <div className="form-group has-feedback m-t-xxs">
                        <input
                            id="search"
                            type="text"
                            className="form-control"
                            name="search"
                            placeholder="ค้นหา"
                            autoComplete="off"
                            ref={register}
                        />
                        <button
                            style={{
                                pointerEvents: "auto",
                                border: "none",
                                "border-radius": "6px",
                                background: "transparent"
                            }}
                            type="submit"
                            className="glyphicon glyphicon-search form-control-feedback"
                            aria-hidden="true"
                        />
                    </div>
                </form>
            </div> */}

            {/* Menu */}
            <section
                className="nav-menu-bottom"
                style={{ position: "sticky", top: 0, zIndex: 999 }}
            >
                <div className="container-fluid menu">
                    <ul id="main-menu" className="sm sm-blue bg-no-re">
                        {feedManu.fetchSuccess &&
                            feedManu.data.list_manu.map((val, i) => {
                                if (val.is_parent == "0") {
                                    return (
                                        <li key={i}>
                                            <ItemLink
                                                to={val.url}
                                                topic={val.manu_name}
                                            />
                                        </li>
                                    );
                                } else {
                                    return (
                                        <li key={i}>
                                            <a
                                                className="colorwh"
                                                style={{ cursor: "pointer" }}
                                            >
                                                {val.manu_name}
                                            </a>
                                            {val.manu_name == "สมาคมฌาปนกิจ" ? (
                                                <ul className="children">
                                                    {feedManu.data.list_sub_manu
                                                        .filter(
                                                            sub =>
                                                                sub.manu_id ==
                                                                val.seq
                                                        )
                                                        .map((sub_m, i_m) => {
                                                            return (
                                                                <ListItemLink
                                                                    to={
                                                                        sub_m.url
                                                                    }
                                                                    topic={
                                                                        sub_m.description
                                                                    }
                                                                    key={i_m}
                                                                />
                                                            );
                                                        })}
                                                    <li>
                                                        <a
                                                            className="colorwh"
                                                            style={{
                                                                cursor:
                                                                    "pointer"
                                                            }}
                                                        >
                                                            ระเบียบ/ข้อบังคับ/คำสั่ง
                                                        </a>
                                                        <ul className="children">
                                                            <li>
                                                                <Link
                                                                    to={
                                                                        "/list/cremation_order"
                                                                    }
                                                                >
                                                                    ระเบียบ
                                                                </Link>
                                                            </li>
                                                            <li>
                                                                <Link
                                                                    to={
                                                                        "/list/cremation_rules"
                                                                    }
                                                                >
                                                                    ข้อบังคับ
                                                                </Link>
                                                            </li>
                                                            <li>
                                                                <Link
                                                                    to={
                                                                        "/list/cremation_command"
                                                                    }
                                                                >
                                                                    คำสั่ง
                                                                </Link>
                                                            </li>
                                                            <li>
                                                                <Link
                                                                    to={
                                                                        "/list/cremation_announce"
                                                                    }
                                                                >
                                                                    ประกาศ
                                                                </Link>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            ) : (
                                                <ul className="children">
                                                    {feedManu.data.list_sub_manu
                                                        .filter(
                                                            sub =>
                                                                sub.manu_id ==
                                                                val.seq
                                                        )
                                                        .map((sub_m, i_m) => {
                                                            return (
                                                                <ListItemLink
                                                                    to={
                                                                        sub_m.url
                                                                    }
                                                                    topic={
                                                                        sub_m.description
                                                                    }
                                                                    key={i_m}
                                                                />
                                                            );
                                                        })}
                                                </ul>
                                            )}
                                        </li>
                                    );
                                }
                            })}

                        {feedManu.fetchSuccess && (
                            <li>
                                <a href="/adminlogon" target="_blank">
                                    เข้าจัดการระบบ
                                </a>
                            </li>
                        )}
                    </ul>
                </div>
            </section>
        </Fragment>
    );
};

function ItemLink({ to, topic, ...rest }) {
    return (
        <Route
            path={to}
            children={({ match }) => (
                <Link className="colorwh" to={to} {...rest}>
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
                    <Link to={to} {...rest}>
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

export default Header;
