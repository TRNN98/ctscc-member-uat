import React from 'react';
import { Skeleton } from '@material-ui/lab';

const Home = () => {
    return (
        <div className="container">
            <div className="row">
                <div className="col-md-9">
                    <Skeleton animation='wave' variant='rect' style={{'margin': '20px 0','padding': '20px',height:'300px'}}/>
                    <Skeleton animation='wave' variant='rect' style={{'margin': '20px 0','padding': '20px',height:'300px'}}/>
                    <Skeleton animation='wave' variant='rect' style={{'margin': '20px 0','padding': '20px',height:'300px'}}/>
                    <Skeleton animation='wave' variant='rect' style={{'margin': '20px 0','padding': '20px',height:'300px'}}/>
                </div>
                <div className="col-md-3">
                    <Skeleton animation='wave' variant='rect' style={{'margin': '20px 0','padding': '20px',height:'350px'}}/>
                    <Skeleton animation='wave' variant='rect' style={{'margin': '20px 0','padding': '20px',height:'220px'}}/>
                    <Skeleton animation='wave' variant='rect' style={{'margin': '20px 0','padding': '20px',height:'150px'}}/>
                    <Skeleton animation='wave' variant='rect' style={{'margin': '20px 0','padding': '20px',height:'150px'}}/>
                    <Skeleton animation='wave' variant='rect' style={{'margin': '20px 0','padding': '20px',height:'150px'}}/>
                    <Skeleton animation='wave' variant='rect' style={{'margin': '20px 0','padding': '20px',height:'150px'}}/>
                </div>
            </div>
        </div>
    );
}

export default Home;
