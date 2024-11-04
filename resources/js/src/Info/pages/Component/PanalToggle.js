// import { Accordion } from "@material-ui/core";
import React from "react";
import { makeStyles } from "@material-ui/core/styles";
import Accordion from "@material-ui/core/Accordion";
import AccordionSummary from "@material-ui/core/AccordionSummary";
import AccordionDetails from "@material-ui/core/AccordionDetails";
import Typography from "@material-ui/core/Typography";
import ExpandMoreIcon from "@material-ui/icons/ExpandMore";

const useStyles = makeStyles(theme => ({
    root: {
        width: "100%",
        border: "1px solid rgba(0, 0, 0, .125)",
        boxShadow: "0 .125rem 1.25rem rgba(0,0,0,.075)",
        borderRadius: 6
    },
    heading: {
        backgroundImage:
            " linear-gradient(to right, #e76b2e, #e87427, #e87e1e, #e78715, #e59107)",
        borderRadius: "6px 6px 0px 0px",
        minHeight: 64
    },
    Title: {
        fontSize: 24,
        margin: 0,
        fontWeight: "bold ",
        color: "#fff"
    },
    Icon: {
        fontSize: 26
    }
}));

export default function PanalToggle({ props }) {
    const classes = useStyles();
    return (
        <div className={classes.root}>
            <Accordion defaultExpanded>
                <AccordionSummary
                    className={classes.heading}
                    expandIcon={<ExpandMoreIcon className={classes.Icon} />}
                    aria-controls="panel1a-content"
                    id="panel1a-header"
                >
                    <h3 className={classes.Title}>{props.title}</h3>
                </AccordionSummary>
                <AccordionDetails>{props.detail}</AccordionDetails>
            </Accordion>
        </div>
    );
}
