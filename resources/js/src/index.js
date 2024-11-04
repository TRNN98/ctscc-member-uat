import React, { useEffect } from "react";
import ReactDOM from "react-dom";
import { Provider } from "react-redux";
// import * as Sentry from "@sentry/browser";

import store from "./store";
import Routes from "./routes";

// React Notification
import "react-notifications/lib/notifications.css";

// Sentry.init({
//     dsn: process.env.SENTRY_LARAVEL_DSN,
//     release: "ctscc@1.0.1"
// });

import { CookiesProvider, useCookies } from "react-cookie";
import AcceptCookie from "./Info/components/AcceptCookie";
const App = () => {
    // useEffect(() => {
    //     if (!("Notification" in window)) {
    //         // alert("Web Notification is not supported");
    //         // console.log("Web Notification is not supported");
    //         console.log("Browser does not support notifications.");
    //         // return;
    //     } else {
    //         if (Notification.permission === "granted") {
    //             // show notification here
    //             Notify();
    //         } else {
    //             // request permission from user
    //             Notification.requestPermission()
    //                 .then(function(p) {
    //                     if (p === "granted") {
    //                         // show notification here
    //                         Notify();
    //                     } else {
    //                         console.log("User blocked notifications.");
    //                     }
    //                 })
    //                 .catch(function(err) {
    //                     console.error(err);
    //                 });
    //         }
    //     }

    //     function Notify() {
    //         var channel = Echo.channel("ckuthai");
    //         channel.listen(".desktopNotify", function(data) {
    //             // alert(JSON.stringify(data));
    //             Notification.requestPermission(permission => {
    //                 let notification = new Notification(data.title, {
    //                     body: data.body, // content for the alert
    //                     icon: "/info/assets/index/logo_smskcoop.png" // optional image url
    //                 });

    //                 // link to page on clicking the notification
    //                 notification.onclick = () => {
    //                     window.open("show/" + data.url);
    //                 };
    //             });
    //         });
    //     }
    // }, []);
    const [cookies, setCookie, removeCookie] = useCookies([
        "popup",
        "acceptCookie"
    ]);
    return (
        <Provider store={store}>
            {" "}
            <CookiesProvider>
                <Routes />
                {(!cookies.acceptCookie || cookies.acceptCookie == "N") && (
                    <AcceptCookie />
                )}
            </CookiesProvider>
        </Provider>
    );
};

if (document.getElementById("app")) {
    ReactDOM.render(<App />, document.getElementById("app"));
}
