import { NotificationManager } from "react-notifications";

class Services {
    getToken() {
        let user = JSON.parse(localStorage.getItem("user"));

        if (user && user.token) {
            return user.token;
        }
    }

    API(url, options) {
        // performs api calls sending the required authentication headers
        const headers = {
            Accept: "application/json, text/plain, */*",
            "Content-Type": "application/json"
        };

        if (this.getToken()) {
            headers["Authorization"] = "Bearer " + this.getToken();
        }

        return axios(url, {
            headers,
            ...options
        })
            .then(this._handleResponseAPIsuc)
            .catch(this._handleResponseAPIerr);
    }

    _handleResponseAPIsuc(response) {
        const data = response.data;

        if (data.rc_des) {
            NotificationManager.success(data.rc_des, "Success", 5000);
        }

        return data;

        // if (response.statusText == "OK") {
        //     if (data.rc_des) {
        //         NotificationManager.success(data.rc_des, 'Success', 5000);
        //     }
        //     return data;
        // }else{
        //     return Promise.reject(data);
        // }
    }

    _handleResponseAPIerr(err) {
        const errors = err.response;
        // if (errors.status === 401) {
        //     location.reload(true);
        // }
        if (errors.data.error) {
            NotificationManager.error(errors.data.error, "Error", 5000);
        } else {
            NotificationManager.error("ไม่สามารถเชื่อมต่อได้", "Error", 5000);
        }
        const error = (errors.data && errors.data.message) || errors.statusText;

        return Promise.reject(error);
    }
}

export default Services;
