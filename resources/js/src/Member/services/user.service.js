import { NotificationManager } from "react-notifications";

import { authHeader } from "../../helpers";

function login(data) {
    const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        data: JSON.stringify({
            membership_no: data.membership_no,
            mem_password: data.mem_password,
            remember: data.remember,
            recaptcha: data.recaptcha
        })
    };

    return axios(`/api/member/auth/login`, requestOptions)
        .then(_handleResponseAPIsuc)
        .catch(_handleResponseAPIerr)
        .then(user => {
            // login successful if there's a jwt token in the response
            if (user.token) {
                // store user details and jwt token in local storage to keep user logged in between page refreshes
                localStorage.setItem("user", JSON.stringify(user));

                NotificationManager.success("เข้าสู่ระบบแล้ว", "Success", 5000);
            }

            return user;
        });
}

function logout() {
    // remove user from local storage to log user out
    const requestOptions = {
        method: "POST",
        headers: authHeader()
    };
    axios(`/api/member/auth/logout`, requestOptions)
        .then(res => res.data)
        .then(res => {
            if (res.message) {
                NotificationManager.success(res.message, "success", 5000);
            }
        })
        .catch(err => {
            // console.log(err);
        });
    localStorage.removeItem("user");
}

function getAuthUser() {
    // remove user from local storage to log user out
    const requestOptions = {
        method: "POST",
        headers: authHeader()
    };

    return axios(`/api/member/auth/getAuthUser`, requestOptions)
        .then(res => {
            return res.data;
        })
        .catch(err => {
            if (err.response.status == 400) {
                localStorage.removeItem("user");
            }
            return err.response;
        });
}

function pass(password, oldpassword) {
    const requestOptions = {
        method: "POST",
        headers: authHeader(),
        data: JSON.stringify({
            mem_password: password,
            mem_oldpassword: oldpassword
        })
    };

    return axios(`/api/member/member_pass`, requestOptions)
        .then(_handleResponseAPIsuc)
        .catch(_handleResponseAPIerr)
        .then(user => {
            return user;
        });
}

function getImpersonate() {
    // remove user from local storage to log user out
    const requestOptions = {
        method: "GET",
        headers: { "Content-Type": "application/json" }
    };

    return axios(`/admin/impersonate/auth/member`, requestOptions)
        .then(_handleResponseAPIsuc)
        .catch(_handleResponseAPIerr)
        .then(user => {
            // login successful if there's a jwt token in the response
            if (user) {
                // store user details and jwt token in local storage to keep user logged in between page refreshes
                localStorage.setItem("user", JSON.stringify(user));
            }

            return user;
        });
}

function _handleResponseAPIsuc(response) {
    const data = response.data;
    return data;

    // if (response.statusText == "OK") {
    //     return data;
    // } else {
    //     return Promise.reject(data);
    // }
}

function _handleResponseAPIerr(err) {
    const errors = err.response;
    if (errors.status === 401) {
        logout();
    }
    if (errors.data.error) {
        NotificationManager.error(errors.data.error, "Error", 5000);
    }
    // ของดีนนท์บอก
     const error = (errors.data && errors.data.message) || (errors.data && errors.data.reset_status) || errors.statusText;

    return Promise.reject(error);
}

export const userService = {
    login,
    logout,
    getAuthUser,
    pass,
    getImpersonate
};
