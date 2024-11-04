import React from "react";
import { Helmet } from "react-helmet";

import "owl.carousel/dist/assets/owl.carousel.css";
import "owl.carousel/dist/assets/owl.theme.default.css";

const Head = () => {
    return (
        <Helmet>
            <meta
                name="description"
                content="สหกรณ์ออมทรัพย์สาธารณสุขเพชรบุรี จํากัด"
            />
            <meta property="og:locale" content="th_TH" />
            <meta property="og:type" content="website" />
            <meta
                property="og:title"
                content="สหกรณ์ออมทรัพย์สาธารณสุขเพชรบุรี จํากัด"
            />
            <meta
                property="og:description"
                content="สหกรณ์ออมทรัพย์สาธารณสุขเพชรบุรี จํากัด"
            />
            <meta property="og:url" content={window.location.href} />
            <link rel="canonical" href={window.location.href} />
            <meta
                property="og:site_name"
                content="สหกรณ์ออมทรัพย์สาธารณสุขเพชรบุรี จํากัด"
            />

            <link
                rel="stylesheet"
                type="text/css"
                href="/info/scripts/fullcalendar/fullcalendar.min.css"
            />
            <link
                rel="stylesheet"
                type="text/css"
                href="/info/html/frontend/bootstrap3.3.5/css/bootstrap.min.css"
            />
            <link
                rel="stylesheet"
                type="text/css"
                href="/info/html/frontend/font/font-awesome4.3.0/css/font-awesome.css"
            />
            <link
                rel="stylesheet"
                type="text/css"
                href="/info/html/frontend/font/style.css"
            />
            <link
                rel="stylesheet"
                type="text/css"
                href="/info/scripts/fancybox/jquery.fancybox.css?v=2.1.5"
            />
            <link
                rel="stylesheet"
                type="text/css"
                href="/info/html/frontend/css/margin.css"
            />
            <link
                rel="stylesheet"
                type="text/css"
                href="/info/html/frontend/css/custom.css"
            />
            <link
                rel="stylesheet"
                type="text/css"
                href="/info/html/frontend/css/custom-cpd.css"
            />
            <link
                rel="stylesheet"
                type="text/css"
                href="/info/html/frontend/css/magnific-popup.css"
            />
            <link
                rel="stylesheet"
                type="text/css"
                href="/info/html/frontend/css/sm-core-css.css"
            />
            <link
                rel="stylesheet"
                type="text/css"
                href="/info/html/frontend/css/sm-blue.css"
            />

            <link rel="stylesheet" type="text/css" href="css/info.css" />
        </Helmet>
    );
};

export default Head;
