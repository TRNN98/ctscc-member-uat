import React, { useState } from "react";
import { Link } from "react-router-dom";
import { withStyles } from "@material-ui/core/styles";
import MuiAccordion from "@material-ui/core/Accordion";
import MuiAccordionSummary from "@material-ui/core/AccordionSummary";
import MuiAccordionDetails from "@material-ui/core/AccordionDetails";
import ExpandMoreIcon from "@material-ui/icons/ExpandMore";
import ArrowUpIcon from "@material-ui/icons/ExpandLess";
import { Button, IconButton } from "@material-ui/core";

const Accordion = withStyles({
    root: {
        border: "1px solid rgba(0, 0, 0, .125)",
        boxShadow: "0 .125rem 1.25rem rgba(0,0,0,.075)",
        "&:not(:last-child)": {
            borderBottom: 0
        },
        "&$expanded": {
            marginBottom: "15px !important",
            borderRadius: 6
        }
    },
    expanded: {}
})(MuiAccordion);

const AccordionSummary = withStyles({
    root: {
        backgroundColor: "rgba(0, 0, 0, .03)",
        borderBottom: "1px solid rgba(0, 0, 0, .125)",
        marginBottom: -1,
        minHeight: 56,
        backgroundImage:
            " linear-gradient(to right, #e76b2e, #e87427, #e87e1e, #e78715, #e59107)",
        borderRadius: "6px 6px 0px 0px",
        cursor: "default",
        pointerEvents: "none",
        "&$expanded": {
            minHeight: 56
        }
    },
    content: {
        "&$expanded": {
            margin: "12px 0",
            display: "block"
        }
    },
    expandIcon: {
        "& svg": {
            fontSize: 25
        }
    },
    expanded: { minHeight: "auto" }
})(MuiAccordionSummary);

const AccordionDetails = withStyles(theme => ({
    root: {
        padding: theme.spacing(2),
        display: "block"
        // backgroundColor: '#e3faff'
    }
}))(MuiAccordionDetails);

// ==============================================================================

const PanelCustom = ({
    props,
    titleCenter = false,
    hiddenSm = false,
    hiddenMd = false,
    hiddenLg = false
}) => {
    return (
        <Accordion
            defaultExpanded
            className={`${hiddenSm && "hidden-sm"} ${hiddenMd &&
                "hidden-md"} ${hiddenLg && "hidden-lg"}`}
        >
            <AccordionSummary
                aria-controls="panel1d-content"
                id="panel1d-header"
                className={`${titleCenter && "text-center"}`}
                // expandIcon={modeToggle && <ExpandMoreIcon />}
            >
                <h3
                    style={{ margin: "5px", fontWeight: "bold", color: "#fff" }}
                >
                    {props.title}
                </h3>
            </AccordionSummary>
            <AccordionDetails className="detail-box open">
                {props.detail}
            </AccordionDetails>
        </Accordion>
    );
};

export default PanelCustom;
