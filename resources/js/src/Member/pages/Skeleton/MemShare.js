import React, { Fragment } from 'react'
import { Skeleton } from '@material-ui/lab';

function MemShare() {
    return (
        <>
            <div className="container-fluid">

                <div className="panel panel-default container wrimagecard" style={{ paddingLeft: 0, paddingRight: 0, boxShadow: '12px 15px 20px 0px rgba(0, 0, 0, 0.1)' }}>
                    <div className="panel-heading">
                        <Skeleton animation='wave' variant='text' width={250} />
                    </div>

                    <div className="panel-body">
                        <div className="col-md-2 col-sm-12 col-xs-12">
                            <div className="wrimagecard-topimage ">
                                <Skeleton animation='wave' variant='rect' height={120} />
                            </div>
                        </div>
                        <div className="col-md-10 col-sm-12 col-xs-12">
                            <div className="wrimagecard-topimage_title">
                                <div className="row">
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                        <Skeleton animation='wave' variant='text' width={100} />
                                    </div>
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                        <Skeleton animation='wave' variant='text' width={100} />
                                    </div>
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-caption">
                                        <Skeleton animation='wave' variant='text' width={100} />
                                    </div>
                                    <div className="col-md-3 col-sm-6 col-xs-6 text-detail">
                                        <Skeleton animation='wave' variant='text' />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-8 col-lg-offset-3">
                            <Skeleton animation='wave' variant='text' width={100} />
                            <Skeleton animation='wave' variant='rect' width={180} height={30} style={{ 'top': '-25px', 'left': '115px' }} />
                            <Skeleton animation='wave' variant='text' width={100} style={{ 'top': '-50px', 'left': '310px' }} />
                            <Skeleton animation='wave' variant='rect' width={180} height={30} style={{ 'top': '-75px', 'left': '425px' }} />
                        </div>
                        <div className="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                </div>
                                <div className="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                    <Skeleton animation='wave' variant='text' style={{ 'top': '-25px' }} />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </>
    );
}

export default MemShare