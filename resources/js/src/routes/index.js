// import libs
import React from "react";
import {
    BrowserRouter as Router,
    Switch,
    Route,
    Redirect,
    useLocation
} from "react-router-dom";
import { NotificationContainer } from "react-notifications";

import ScrollToTop from "../helpers/ScrollToTop";

// import components
import routes from "./routes";
import PublicRoute from "./Public";
import PrivateRoute from "./Private";

import Layout from "./layout";

function Routes() {
    return (
        <Router>
            <Layout>
                <ScrollToTop />
                <Switch>
                    {routes.map((route, i) => {
                        if (route.auth) {
                            return <PrivateRoute key={i} {...route} />;
                        }
                        return <PublicRoute key={i} {...route} />;
                    })}
                    <Route path="*">
                        {/* <Redirect to="/home" /> */}
                        <NoMatch />
                    </Route>
                </Switch>
            </Layout>
            <NotificationContainer />
        </Router>
    );
}

function NoMatch() {
    let location = useLocation();

    return (
        <div>
            <h3>
                No match for <code>{location.pathname}</code>
            </h3>
        </div>
    );
}

export default Routes;
