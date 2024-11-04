import React from "react";
import * as moment from "moment";
import LoadingOverlay from "react-loading-overlay";

export const number_format = (val, digit = 2) => {
    var nf = new Intl.NumberFormat("th", {
        minimumFractionDigits: digit
    });
    return nf.format(val);
};

export const convert_to_Thaidate = (
    val,
    format = "ll",
    fm = "YYYY-MM-DD",
    thaiyear = true
) => {
    let date = moment(val, fm, "th", true);
    if (date.isValid()) {
        if (thaiyear) {
            date.add(543, "years");
        }
        return date.format(format);
    }
};

export const convert_to_Thaidatetime = val => {
    let date = moment(val, "YYYY-MM-DD HH:mm:ss", "th", true);
    if (date.isValid()) {
        date.add(543, "years");
        return date.format("ll");
    }
};

export const createMarkup = (html, success = true) => {
    if (!success) {
        return {
            __html: "<center><h3>Loading ...</h3></center>"
        };
    }
    return { __html: html };
};

export const useEventListener = (target, type, listener, ...options) => {
    React.useEffect(() => {
        const targetIsRef = target.hasOwnProperty("current");
        const currentTarget = targetIsRef ? target.current : target;
        if (currentTarget)
            currentTarget.addEventListener(type, listener, ...options);
        return () => {
            if (currentTarget)
                currentTarget.removeEventListener(type, listener, ...options);
        };
    }, [target, type, listener, options]);
};

export const Wordcount = e => {
    e.preventDefault();
    let newWrd;
    let txtbox = $("#membership_no");
    let Wrdlen = $("#membership_no").val().length;

    if (Wrdlen == 1) {
        newWrd = "0000" + txtbox.val();
        txtbox.val(newWrd);
    }
    if (Wrdlen == 2) {
        newWrd = "000" + txtbox.val();
        txtbox.val(newWrd);
    }
    if (Wrdlen == 3) {
        newWrd = "00" + txtbox.val();
        txtbox.val(newWrd);
    }
    if (Wrdlen == 4) {
        newWrd = "0" + txtbox.val();
        txtbox.val(newWrd);
    }
};

export const isInputNumber = e => {
    var char = String.fromCharCode(e.which);
    if (!/[0-9]/.test(char)) {
        e.preventDefault();
    }
};
