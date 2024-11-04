import React, { Fragment } from 'react'
import { Skeleton } from '@material-ui/lab';

function MemStatus() {
    return (
        <>
            <div className="container-fluid">
                <div className="row">
                    <div className="col-md-6 col-sm-6">
                        <Skeleton animation='wave' variant='text' width={250} style={{'margin-bottom': '25px'}}/>
                        <Skeleton animation='wave' variant='circle' height={100} width={100} style={{ 'margin-top': '15px' }} />
                        <Skeleton animation='wave' variant='text' width={80} style={{ 'position': 'relative', 'top': '-105px', 'left': '115px' }} />
                        <Skeleton animation='wave' variant='text' width={150} style={{ 'position': 'relative', 'top': '-125px', 'left': '205px' }} />
                        <Skeleton animation='wave' variant='text' width={100} style={{ 'position': 'relative', 'top': '-115px', 'left': '115px' }} />
                        <Skeleton animation='wave' variant='text' width={220} style={{ 'position': 'relative', 'top': '-135px', 'left': '225px' }} />

                        <Skeleton animation='wave' variant='text' width={100} style={{ 'position': 'relative', 'top': '-115px', 'left': '115px' }} />
                        <Skeleton animation='wave' variant='text' width={220} style={{ 'position': 'relative', 'top': '-135px', 'left': '225px' }} />
                        <Skeleton animation='wave' variant='text' width={80} style={{ 'position': 'relative', 'top': '-125px', 'left': '115px' }} />
                        <Skeleton animation='wave' variant='text' width={150} style={{ 'position': 'relative', 'top': '-145px', 'left': '205px' }} />
                        <Skeleton animation='wave' variant='text' width={100} style={{ 'position': 'relative', 'top': '-115px', 'left': '115px' }} />
                        <Skeleton animation='wave' variant='text' width={220} style={{ 'position': 'relative', 'top': '-135px', 'left': '225px' }} />
                        <Skeleton animation='wave' variant='text' width={80} style={{ 'position': 'relative', 'top': '-125px', 'left': '115px' }} />
                        <Skeleton animation='wave' variant='text' width={150} style={{ 'position': 'relative', 'top': '-145px', 'left': '205px' }} />
                        <Skeleton animation='wave' variant='text' width={100} style={{ 'position': 'relative', 'top': '-130px', 'left': '115px' }} />
                        <Skeleton animation='wave' variant='text' width={220} style={{ 'position': 'relative', 'top': '-150px', 'left': '225px' }} />
                        <Skeleton animation='wave' variant='text' width={80} style={{ 'position': 'relative', 'top': '-140px', 'left': '115px' }} />
                        <Skeleton animation='wave' variant='text' width={150} style={{ 'position': 'relative', 'top': '-160px', 'left': '205px' }} />
                    </div>
                    <div className="col-md-6 col-sm-6">
                        <div className="col-md-6 col-sm-6">
                            <Skeleton animation='wave' variant='rect' height={150} />
                        </div>
                        <div className="col-md-6 col-sm-6">
                            <Skeleton animation='wave' variant='rect' height={150} />
                        </div>
                        <div className="col-md-6 col-sm-6">
                            <Skeleton animation='wave' variant='rect' height={150} style={{ 'margin-top':'20px' }}/>
                        </div>
                        <div className="col-md-6 col-sm-6">
                            <Skeleton animation='wave' variant='rect' height={150} style={{ 'margin-top':'20px' }}/>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default MemStatus