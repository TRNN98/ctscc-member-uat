import React, { Suspense } from "react";
import PropTypes from "prop-types";
import { Route } from "react-router-dom";
import LoadingOverlay from "react-loading-overlay";

const PublicRoute = ({ component: Component, ...rest }) => {
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
                        <Component {...props} />
                    </Suspense>
                );
            }}
        />
    );
};

PublicRoute.propTypes = {
    component: PropTypes.object.isRequired,
    location: PropTypes.object
};

export default PublicRoute;
