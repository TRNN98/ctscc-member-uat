import React, { Fragment } from 'react'
import { Skeleton } from '@material-ui/lab';

const MemLoan = () => {
    return (
        <div className="container-fluid">
            <div className="rowx">
                <div className="panel panel-info container wrimagecard" style={{ paddingLeft: 0, paddingRight: 0, boxShadow: '12px 15px 20px 0px rgba(46,61,73,0.15)' }} >
                    <div className="panel-heading">
                        <Skeleton animation='wave' variant='text' width={250} />
                    </div>
                    <div className="panel-body">
                        <div className="col-md-3 col-sm-12 col-xs-12">
                            <div className="wrimagecard-topimage ">
                                <Skeleton animation='wave' variant='circle' height={180} width={180} />
                            </div>
                        </div>
                        <div className="col-md-9 col-sm-12 col-xs-12">
                            <div className="wrimagecard-topimage_title">
                                <div className="row">
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-md-12 text-caption">
                                        <br/>
                                        <Skeleton animation='wave' variant='rect' height={50} />
                                        <br/>
                                        <Skeleton animation='wave' variant='rect' height={50} />
                                        <br/>
                                        <Skeleton animation='wave' variant='rect' height={50} />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    )
}

export default MemLoan
