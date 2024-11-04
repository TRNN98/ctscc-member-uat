import React from "react";
import Accordion from "@material-ui/core/Accordion";
import AccordionSummary from "@material-ui/core/AccordionSummary";
import AccordionDetails from "@material-ui/core/AccordionDetails";
import Typography from "@material-ui/core/Typography";
import ExpandMoreIcon from "@material-ui/icons/ExpandMore";
import { makeStyles } from "@material-ui/core";

const useStyles = makeStyles(theme => ({
    root: {
        color: "#16A085",
        backgroundColor: "rgba(22, 160, 133, 0.1)",
        border: "1px solid rgba(0, 0, 0, .125)",
        boxShadow: "none"
    },
    heading: {
        fontSize: 16
    },
    bor: {
        borderTop: "1px solid #B2DFDB"
    }
}));

const Collateral = ({ collateral, head_contract, num }) => {
    const classes = useStyles();
    return (
        <Accordion className={classes.root}>
            <AccordionSummary
                expandIcon={<ExpandMoreIcon />}
                aria-controls="panel1a-content"
                id="panel1a-header"
                rounded
            >
                <Typography className={classes.heading}>
                    <i
                        className="fa fa-group"
                        style={{
                            fontSize: 20,
                            fontWeight: "bold",
                            paddingRight: 10
                        }}
                    />
                    หลักประกันสัญญาเงินกู้
                </Typography>
            </AccordionSummary>
            <AccordionDetails className={classes.bor}>
                <ul style={{ listStyle: "none" }}>
                    {collateral.map((valdt, i) => {
                        if (head_contract == valdt.loan_contract_no) {
                            num++;
                            return (
                                <li
                                    style={{ padding: "5px 0" }} key={i}
                                >{`${num}.) ${valdt.collateral_description} `}</li>
                            );
                        }
                    })}
                </ul>
            </AccordionDetails>
        </Accordion>
    );
};

export default Collateral;
