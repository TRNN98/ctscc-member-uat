import Services from "./services";

const service = new Services();

function feedDataGet(url) {
    const requestOptions = {
        method: "GET"
    };

    return service.API(url, requestOptions).then(res => {
        return res;
    });
}

function feedDataPost(url, body = {}) {
    const requestOptions = {
        method: "POST",
        data: JSON.stringify(body)
    };

    return service.API(url, requestOptions).then(res => {
        return res;
    });
}

function fileUploadPost(url, body = {}) {
    const requestOptions = {
        method: "POST",
        data: body
    };

    return service.API(url, requestOptions).then(res => {
        return res;
    });
}
export const feedmemdataService = {
    // homePage,
    feedDataGet,
    feedDataPost,
    fileUploadPost
};
