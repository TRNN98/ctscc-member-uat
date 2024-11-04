import React from "react";
import { useDispatch } from "react-redux";
import { Link, Route } from "react-router-dom";

import { userActions } from "../actions";
import { history } from "../../helpers";

const Sidebar = () => {
    const dispatch = useDispatch();

    return (
        <div id="sidebar-wrapper">
            <ul className="sidebar-nav nav-pills nav-stacked" id="menu">
                <ListItemLink
                    to="/status"
                    icon="fa fa-dashboard fa-stack-1x"
                    title="หน้าจอหลัก/ข้อมูลทั่วไปสมาชิก"
                    name="ข้อมูลส่วนบุคคล"
                />
                <ListItemLink
                    to="/share"
                    icon="fa fa-pie-chart fa-stack-1x"
                    title="ทุนเรือนหุ้น/รายการเคลื่อนไหวหุ้น"
                    name="ทะเบียนหุ้น"
                />
                <ListItemLink
                    to="/loan"
                    icon="fa fa-pie-chart fa-stack-1x"
                    id="menu_loan"
                    title="เงินกู้คงเหลือ/รายการเคลื่อนไหวเงินกู้"
                    name="เงินกู้"
                />
                <ListItemLink
                    to="/deposit"
                    icon="fa fa-bank fa-stack-1x"
                    id="menu_dep"
                    title="เงินกู้คงเหลือ/รายการเคลื่อนไหวเงินกู้"
                    name="เงินฝาก"
                />
                <ListItemLink
                    to="/kep"
                    icon="fa fa-calendar fa-stack-1x"
                    title="รายการเรียกเก็บประจำเดือน แสดงข้อมูลย้อนหลัง 6 เดือน"
                    name="รายการเรียกเก็บ"
                />
                <ListItemLink
                    to="/coll"
                    icon="fa fa-group fa-stack-1x"
                    title="เราค้ำประกันสัญญาเงินกู้ใครบ้าง"
                    name="การค้ำประกัน"
                />
                <ListItemLink
                    to="/gian"
                    icon="fa fa-child fa-stack-1x"
                    title="รายละเอียด/ชื่อผู้รับโอนผลประโยชน์"
                    name="ผู้รับโอนผลประโยชน์"
                />
                <ListItemLink
                    to="/dividend"
                    icon="fa fa-database fa-stack-1x"
                    title="ยอดรวม/การตัดจ่าย บัญชีธนาคารที่โอนเงินเข้า"
                    name="ปันผล/เฉลี่ยคืน"
                />
                {/* <ListItemLink to="/crem" icon="fa fa-user fa-stack-1x" title="ข้อมูลสมาคมฌาปนกิจ" name="สมาคมฌาปนกิจ"/> */}
                <ListItemLink
                    to="/password"
                    icon="fa fa-gears fa-stack-1x"
                    title="เปลี่ยนรหัสผ่านในการเข้าระบบ"
                    name="เปลี่ยนรหัสผ่าน"
                />
                {/* <ListItemLink to="/member/password" icon="fa fa-gears fa-stack-1x" title="เปลี่ยนรหัสผ่านในการเข้าระบบ" name="เปลี่ยนรหัสผ่าน"/> */}

                <li id="menu_logout">
                    <a
                        onClick={() => dispatch(userActions.logout())}
                        className="menu_logout"
                        title="ออกจากระบบข้อมูลสมาชิก *ควรออกทุกครั้งที่เข้าใช้งาน"
                    >
                        <span className="fa-stack fa-lg pull-left">
                            <i className="fa fa-sign-out fa-stack-1x" />
                        </span>
                        ออกจากระบบ
                    </a>
                </li>

                {/* <br />
                <br /> */}

                {/* <li id="menu_logout">
                    <a onClick={() => history.push('/home')} className="menu_logout" data-toggle="tooltip" title="ออกจากระบบข้อมูลสมาชิก *ควรออกทุกครั้งที่เข้าใช้งาน">
                        <span className="fa-stack fa-reply pull-left">
                            <i className="fa fa-sign-out fa-stack-1x" />
                        </span>
                        กลับหน้าหลัก
                    </a>
                </li> */}

                {/* <ListItemLink
                    to="/home"
                    icon="fa fa-reply fa-stack-1x"
                    title=""
                    name="กลับหน้าหลัก"
                /> */}
                <li>&nbsp;</li>
                <li>
                    <a
                        href={`https://ctscc.or.th`}
                        target="_self"
                        className="menu"
                    >
                        {/* <div className="menu" title={title}> */}
                        <span className="fa-stack fa-lg pull-left">
                        <i className="fa  fa-reply" />
                        </span>
                        &nbsp; {`กลับหน้าหลัก`}
                        {/* </div> */}
                    </a>
                </li>
            </ul>
        </div>
    );
};

function ListItemLink({ to, icon, name, title, id, ...rest }) {
    const toggleOnclick = () => {
        if (window.matchMedia("screen and (max-width: 768px)").matches) {
            $("#sidebar-wrapper").width(0);
            $("#wrapper").css("padding-left", "unset");
            $(this).css("background-color", "red");
        }
    };

    return (
        <Route
            path={to}
            children={({ match }) => (
                <li
                    id={id}
                    className={match ? "active" : ""}
                    onClick={toggleOnclick}
                >
                    <Link to={to} className="menu" title={title} {...rest}>
                        {/* <div className="menu" title={title}> */}
                        <span className="fa-stack fa-lg pull-left">
                            <i className={icon} />
                        </span>
                        {name}
                        {/* </div> */}
                    </Link>
                </li>
            )}
        />
    );
}

export default Sidebar;
