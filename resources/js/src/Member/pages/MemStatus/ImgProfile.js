import React, { useEffect, useState, Fragment, useCallback } from "react";
import { useDispatch, useSelector } from "react-redux";
import { feedmemdataActions } from "../../actions";
import ImageUploader from "react-images-upload";
import { NotificationManager } from "react-notifications";

// Material
import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogActions from "@material-ui/core/DialogActions";
import DialogContent from "@material-ui/core/DialogContent";
import DialogContentText from "@material-ui/core/DialogContentText";
import DialogTitle from "@material-ui/core/DialogTitle";
// import useMediaQuery from "@material-ui/core/useMediaQuery";
// import { useTheme } from "@material-ui/core/styles";
import Slider from "@material-ui/core/Slider";
// ------------------------------------------
import Cropper from "react-easy-crop";

function ImgProfile() {
    const dispatch = useDispatch();
    const feedMemData = useSelector(state => state.feedMemData);
    const [myImg, setMyImg] = useState();
    const [profileImg, setProfileImg] = useState();

    const [imageCroped, setImageCroped] = useState();
    const [imageCropedPixels, setImageCropedPixels] = useState();
    // Material
    const [open, setOpen] = React.useState(false);
    // const theme = useTheme();
    // const fullScreen = useMediaQuery(theme.breakpoints.down("sm"));
    // function

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
    };

    const handleSubmit = () => {
        let sendCroppedArea = imageCroped;
        let sendCroppedAreaPixels = imageCropedPixels;
        const data = {
            image: myImg,
            name:
                feedMemData.fetchSuccess &&
                feedMemData.data.data1[0].membership_no,
            croppedArea: sendCroppedArea,
            croppedAreaPixels: sendCroppedAreaPixels
        };
        feedmemdataActions
            .fileUpload(data)
            .then(result => {
                // console.log(result)
                if (result.rc_code == "1") {
                    $("#user_pic").attr("src", result.rc_resources);
                    setProfileImg(
                        loadImage(
                            feedMemData.fetchSuccess &&
                                feedMemData.data.data1[0].membership_no
                        )
                    );

                    setOpen(false);
                    NotificationManager.success(result.rc_des, "Success", 5000);
                } else if (result.rc_code == "0") {
                    setOpen(false);
                    NotificationManager.error(result.rc_des, "Error", 5000);
                } else {
                    setOpen(false);
                    NotificationManager.warning(
                        "มีบางอย่างพิดพลาด.. กรุณาลองใหม่อีกครั้ง..",
                        5000
                    );
                }
            })
            .catch(err => {
                setOpen(false);
                NotificationManager.error(
                    "ไม่สามารถเชื่อมต่อได้",
                    "Error",
                    5000
                );
            });

        function loadImage(variable) {
            var image = new Image();
            var url_image = "member/profile/" + variable + ".jpg";

            image.src = url_image;
            var http = new XMLHttpRequest();
            http.open("HEAD", image.src, false); // false = Synchronous
            http.send(null); // it will stop here until this http request is complete
            if (
                http.status === 200 &&
                http.getResponseHeader("Content-Type") == "image/jpeg"
                // &&
                // // อันนี้แปลว่า keep alive
                // http.getResponseHeader("Connection") != "Keep-Alive"
            ) {
                return variable + `.jpg`;
            } else {
                return `default.jpg`;
            }
        }
    };
    // Material end

    // react-easy-crop
    const [crop, setCrop] = useState({ x: 0, y: 0 });
    const [zoom, setZoom] = useState(1);
    const onCropComplete = useCallback((croppedArea, croppedAreaPixels) => {
        setImageCroped(croppedArea);
        setImageCropedPixels(croppedAreaPixels);
        // console.log(croppedArea, croppedAreaPixels);
    }, []);
    // -----------------------------
    useEffect(() => {
        // async function feedData() {
        //     await dispatch(
        //         feedmemdataActions.feedDataPost(`/api/member/member_status`)
        //     );
        // }
        // feedData();
    }, []);

    useEffect(() => {
        // $("body").css("overflow-x", "unset");
        if (feedMemData.fetchSuccess) {
            setProfileImg(
                loadImage(
                    feedMemData.fetchSuccess &&
                        feedMemData.data.data1[0].membership_no
                )
            );
        }

        function loadImage(variable) {
            var image = new Image();
            var url_image = "member/profile/" + variable + ".jpg";

            image.src = url_image;
            var http = new XMLHttpRequest();
            http.open("HEAD", image.src, false); // false = Synchronous
            http.send(null); // it will stop here until this http request is complete
            if (
                http.status === 200 &&
                http.getResponseHeader("Content-Type") == "image/jpeg"
                // &&
                // // อันนี้แปลว่า keep alive
                // http.getResponseHeader("Connection") != "Keep-Alive"
            ) {
                return variable + `.jpg`;
            } else {
                return `default.jpg`;
            }
        }
    }, [feedMemData.fetchSuccess]);

    const onDrop = (pictureFiles, pictureDataURLs) => {
        setMyImg(pictureDataURLs[0]);
        // $("#user_pic").attr("src", pictureDataURLs[0]);
        // const data = {
        //     image: pictureDataURLs[0],
        //     name:
        //         feedMemData.fetchSuccess &&
        //         feedMemData.data.data1[0].membership_no
        // };
        setOpen(true);
        // feedmemdataActions
        //     .fileUpload(data)
        //     .then(result => {
        //         // console.log(result)
        //         if (result.rc_code == "1") {
        //             NotificationManager.success(result.rc_des, "Success", 5000);
        //         } else if (result.rc_code == "0") {
        //             NotificationManager.error(result.rc_des, "Error", 5000);
        //         } else {
        //             NotificationManager.warning(
        //                 "มีบางอย่างพิดพลาด.. กรุณาลองใหม่อีกครั้ง..",
        //                 5000
        //             );
        //         }
        //     })
        //     .catch(err => {
        //         NotificationManager.error(
        //             "ไม่สามารถเชื่อมต่อได้",
        //             "Error",
        //             5000
        //         );
        //     });
    };
    return (
        <Fragment>
            {/* Material */}
            <Dialog
                // fullScreen={fullScreen}
                maxWidth={"lg"}
                open={open}
                onClose={handleClose}
                aria-labelledby="responsive-dialog-title"
            >
                <DialogTitle id="responsive-dialog-title">
                    {/* ปรับขนาดรูปภาพ */}
                </DialogTitle>
                <DialogContent>
                    <DialogContentText>
                        <div
                            className=""
                            style={{ width: "80vw", height: "50vh" }}
                        >
                            <div className="crop-container">
                                <Cropper
                                    image={myImg && myImg}
                                    crop={crop}
                                    zoom={zoom}
                                    aspect={4 / 3}
                                    onCropChange={setCrop}
                                    onCropComplete={onCropComplete}
                                    onZoomChange={setZoom}
                                />
                            </div>
                            <div className="controls">
                                <Slider
                                    value={zoom}
                                    min={1}
                                    max={3}
                                    step={0.1}
                                    aria-labelledby="Zoom"
                                    onChange={(e, zoom) => setZoom(zoom)}
                                    classes={{ container: "slider" }}
                                />
                            </div>
                        </div>
                    </DialogContentText>
                </DialogContent>
                <DialogActions>
                    <Button
                        variant="contained"
                        size="large"
                        autoFocus
                        onClick={handleClose}
                        color="secondary"
                    >
                        <h5>ยกเลิก</h5>
                    </Button>
                    <Button
                        variant="contained"
                        size="large"
                        onClick={handleSubmit}
                        color="primary"
                        autoFocus
                    >
                        <h5>ตกลง</h5>
                    </Button>
                </DialogActions>
            </Dialog>

            {/* Material */}
            <div className="">
                <img
                    alt="User Pic"
                    id="user_pic"
                    src={`member/profile/${profileImg}?${Math.random() * 100}`}
                    className="img-circle img-thumbnail"
                />

                <br />
                <ImageUploader
                    withLabel={false}
                    withIcon={false}
                    withPreview={false}
                    buttonText="อัพโหลดรูป"
                    onChange={onDrop}
                    imgExtension={[".jpeg", ".jpg", ".gif", ".png", ".gif"]}
                    // maxFileSize={1048576}
                    singleImage={true}
                />
            </div>
        </Fragment>
    );
}

export default ImgProfile;
