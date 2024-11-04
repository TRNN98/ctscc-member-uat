import { userConstants } from "../constants";
import { userService } from "../services";
import { NotificationManager } from "react-notifications";

export const userActions = {
    login,
    logout,
    getAuthUser,
    change_pass,
    getImpersonate
};

function login(data,history, customAlert) {

    return dispatch => {
        dispatch(request(data.membership_no));

        userService.login(data).then(
            user => {
                dispatch(success(user));
            },
            error => {
                dispatch(failure(error));
                
                if (error === true) {
                    customAlert("เพื่อความปลอดภัยในการใช้งาน กรุณาเปลี่ยนรหัสผ่านใหม่");
                    history.push("/forget");
                }
            }
        );
    };

    function request(user) {
        return {
            type: userConstants.LOGIN_REQUEST,
            user
        };
    }

    function success(user) {
        return {
            type: userConstants.LOGIN_SUCCESS,
            user
        };
    }

    function failure(error) {
        return {
            type: userConstants.LOGIN_FAILURE,
            error
        };
    }
}

function change_pass(password, oldpassword) {
    return dispatch => {
        dispatch(request());

        userService.pass(password, oldpassword).then(
            data => {
                if (data.rc_code == "1") {
                    dispatch(success(data));
                    NotificationManager.success(data.rc_des, "Success", 5000);
                } else {
                    dispatch(failure(data));
                    NotificationManager.error(data.rc_des, "Error", 5000);
                }
                // history.push('/member/status');
            },
            error => {
                dispatch(failure(error));
            }
        );
    };

    function request() {
        return {
            type: userConstants.PASS_REQUEST
        };
    }

    function success(data) {
        return {
            type: userConstants.PASS_SUCCESS,
            data: data
        };
    }

    function failure(data) {
        return {
            type: userConstants.PASS_FAILURE,
            data: data
        };
    }
}

function logout() {
    userService.logout();
    return {
        type: userConstants.LOGOUT
    };
}

function getAuthUser() {
    return dispatch =>
        new Promise((resolve, reject) => {
            userService.getAuthUser().then(data => {
                if (data.status == 400 && data.data.error) {
                    dispatch({
                        type: userConstants.LOGOUT
                    });
                    return reject(data);
                }
                if (data.rc_code == 1) {
                    return resolve();
                }
            });
        });
}

function getImpersonate() {
    return dispatch => {
        return new Promise((resolve, reject) => {
            dispatch(request());

            userService.getImpersonate().then(
                user => {
                    dispatch(success(user));
                    return resolve(user);
                    // history.push("/member/status");
                },
                error => {
                    dispatch(failure(error));
                    return reject(error);
                    // history.push("/home");
                }
            );
        });
    };

    function request(user) {
        return {
            type: userConstants.LOGIN_REQUEST,
            user
        };
    }

    function success(user) {
        return {
            type: userConstants.LOGIN_SUCCESS,
            user
        };
    }

    function failure(error) {
        return {
            type: userConstants.LOGIN_FAILURE,
            error
        };
    }
}
