//import libs
import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import { useSelector } from "react-redux";
import LoadingOverlay from "react-loading-overlay";
// import components
import Header from "./Header";
import Footer from "./Footer";
// import Menu from "./Menu";
import Head from "./Head";
import KeyboardArrowUpIcon from "@material-ui/icons/KeyboardArrowUp";
// import Responsive_header from "./Responsive_header";

function InfoLayout({ children }) {
    const feedData = useSelector(state => state.feedData);

    const [showScroll, setShowScroll] = useState(false);

    // --==== Scroll To Top ===-- //
    const checkScrollTop = () => {
        if (!showScroll && window.pageYOffset > 400) {
            setShowScroll(true);
        } else if (showScroll && window.pageYOffset <= 400) {
            setShowScroll(false);
        }
    };

    window.addEventListener("scroll", checkScrollTop);

    const scrollToTop = () => {
        window.scrollTo({ top: 0, left: 0, behavior: "smooth" });
    };
    // --=== End Scroll To Top ===-- //
    return (
        <>
            <Head />
            <Header />
            {/* <Menu /> */}
            {/* <Header_sheach /> */}
            {/* <Responsive_header /> */}
            {children}
            <Footer />
            {/* slide to top */}
            {showScroll && (
                <KeyboardArrowUpIcon
                    style={{
                        fontSize: 45,
                        position: "fixed",
                        bottom: 45,
                        right: 15,
                        backgroundColor: "#BDBDBD",
                        color: "#323232",
                        borderRadius: "50%",
                        cursor: "pointer",
                        zIndex: 9
                    }}
                    onClick={scrollToTop}
                />
            )}
        </>
    );
}

const displayName = "Info Layout";
const propTypes = {
    children: PropTypes.node.isRequired
};

InfoLayout.dispatch = displayName;
InfoLayout.propTypes = propTypes;

export default InfoLayout;
