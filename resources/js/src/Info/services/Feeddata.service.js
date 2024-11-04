import Services from './services';

const service = new Services();

function feedData(url) {

    const requestOptions = {
        method: 'GET'
    };

    return service.API(url, requestOptions)
        .then(res => {
            return res;
        });
}

function feedDataPost(url, body= {}) {

    const requestOptions = {
        method: 'POST',
        data: JSON.stringify(body)
    };

    return service.API(url, requestOptions)
        .then(res => {
            return res;
        });
}

export const feeddataService = {
    // homePage,
    feedData,
    feedDataPost
};
