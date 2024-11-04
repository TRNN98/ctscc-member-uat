// //import libs
import React, { Fragment, useEffect, useState } from "react";
import PropTypes from "prop-types";
import { useSelector, useDispatch } from "react-redux";
import { withRouter, matchPath, useLocation } from "react-router-dom";
// import { NotificationManager } from "react-notifications";

// import services actions
import { userActions } from "../Member/actions";

// import components
import routes from "../routes/routes";
import MemberLayout from "../Member/layouts/MemberLayout";
import InfoLayout from "../Info/layouts/InfoLayout";

const Layout = ({ children, ...props }) => {
    const dispatch = useDispatch();
    const isAuthenticated = useSelector(state => state.authentication.loggedIn);

    const { pathname } = useLocation();
    const [path, setPath] = useState(null);

    useEffect(() => {
        if (isAuthenticated) {
            dispatch(userActions.getAuthUser()).catch(() => {
                // NotificationManager.error(err.data.error, "Error", 5000);
            });
        }

        for (var i = 0; i < routes.length; i++) {
            let path = matchPath(pathname, {
                path: routes[i].path
            });

            if (path != null) {
                setPath(routes[i]);
                break; // stop the loop
            }
        }
    }, [dispatch, isAuthenticated, pathname]);

    const layout = path && path.layout;

    if (layout == "member") {
        return <MemberLayout {...props}>{children}</MemberLayout>;
    } else if (layout == "info") {
        return <InfoLayout {...props}>{children}</InfoLayout>;
    } else {
        return <Fragment>{children}</Fragment>;
    }
};

Layout.displayName = "Layout";

Layout.propTypes = {
    children: PropTypes.node.isRequired
};

export default withRouter(Layout);
