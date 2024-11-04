import React, { Suspense } from "react";
import PropTypes from "prop-types";
import { Route, Redirect } from "react-router-dom";
import { useSelector } from "react-redux";
import LoadingOverlay from "react-loading-overlay";

const PrivateRoute = ({ component: Component, ...rest }) => {
    const isAuthenticated = useSelector(state => state.authentication.loggedIn);

    return (
        <Route
            {...rest}
            render={props => {
                return (
                    <Suspense
                        fallback={
                            <LoadingOverlay
                                active={true}
                                spinner
                                text="Loading ..."
                            >
                                <p
                                    style={{
                                        width: "1024px",
                                        height: "1024px"
                                    }}
                                ></p>
                            </LoadingOverlay>
                        }
                    >
                        {isAuthenticated ? (
                            <Component {...props} />
                        ) : (
                            <Redirect
                                to={{
                                    pathname: "/logon",
                                    state: { from: props.location }
                                }}
                            />
                        )}
                    </Suspense>
                );
            }}
        />
    );
};

PrivateRoute.propTypes = {
    component: PropTypes.object.isRequired,
    location: PropTypes.object
};

export default PrivateRoute;
