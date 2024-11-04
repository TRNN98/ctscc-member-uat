import React, { useEffect, Fragment, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import useForm from "react-hook-form";
import { Link, useHistory } from "react-router-dom";

// import { history } from "../../../helpers";
import { feeddataActions } from "../../actions";
import Services from "../../services/services";

const Board_post = () => {
    const [is_admin, setis_admin] = useState();
    const dispatch = useDispatch();
    const feedData = useSelector(state => state.feedData);
    const authentication = useSelector(state => state.authentication);
    const history = useHistory();

    const { register, handleSubmit } = useForm();

    const service = new Services();

    useEffect(() => {
        async function feedData() {
            await service
                .API(`/api/info/auth/is_admin`, {
                    method: "GET"
                })
                .then(data => setis_admin(data));
        }
        feedData();
    }, []);

    const onSubmit = async (data, e) => {
        e.preventDefault();
        try {
            await dispatch(
                feeddataActions.feedDataPost("/api/info/board_create", {
                    Question: data.Question,
                    QNote: data.QNote,
                    QName: data.QName
                })
            );
        } catch (error) {
            console.log(error);

            if (feedData.fetchFailure) {
                await setTimeout(history.push("/board"), 100);
            }
        } finally {
            await setTimeout(history.push("/board"), 100);
        }
        e.target.reset();
    };

    return (
        <Fragment>
            <div className="list-type">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <h2 className="title">ตั้งกระทู้ใหม่</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div className="container">
                <div className="row">
                    <div className="col-md-12">
                        <div className="page-breadcrumb">
                            <ol
                                className="breadcrumb"
                                style={{
                                    margin: "10px 0",
                                    backgroundColor: "#FFF",
                                    padding: "8px 0",
                                    color: "#838384"
                                }}
                            >
                                <li>
                                    <Link to="/home">หน้าแรก</Link>
                                </li>
                                <li>
                                    <Link to={`/board`}>
                                        กระดานข่าว
                                    </Link>
                                </li>
                                <li>
                                    <Link to={`/boardPost`} className="active">ตั้งกระทู้ใหม่</Link>
                                </li>

                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div className="content-inner container">
                <div className="row">
                    <div className="col-md-8 col-md-offset-2">
                        <form onSubmit={handleSubmit(onSubmit)}>
                            <div className="form-group">
                                <label>เรื่อง :</label>
                                <input
                                    type="text"
                                    name="Question"
                                    className="form-control"
                                    ref={register}
                                    required
                                />
                            </div>
                            <div className="form-group">
                                <label>รายละเอียด :</label>
                                <textarea
                                    name="QNote"
                                    className="form-control"
                                    cols={120}
                                    rows={8}
                                    ref={register}
                                    required
                                />
                            </div>
                            <div className="form-group">
                                <label>ชื่อ :</label>
                                {is_admin && is_admin.is_admin == true && (
                                    <input
                                        type="text"
                                        name="QName"
                                        className="form-control"
                                        defaultValue="ADMIN"
                                        ref={register}
                                        required
                                    />
                                )}
                                {is_admin &&
                                    authentication.loggedIn == true &&
                                    is_admin.is_admin == false && (
                                        <input
                                            type="text"
                                            name="QName"
                                            className="form-control"
                                            defaultValue={`${authentication.user.member.PRENAME}${authentication.user.member.MEMBER_NAME} ${authentication.user.member.MEMBER_SURNAME}`}
                                            ref={register}
                                            required
                                        />
                                    )}
                            </div>
                            <div className="form-group">
                                <input
                                    type="submit"
                                    className="btn btn-warning btn-lg"
                                    defaultValue="ตั้งกระทู้"
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Fragment>
    );
};

export default Board_post;
