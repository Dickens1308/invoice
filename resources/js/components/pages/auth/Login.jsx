import React, { useEffect, useState } from "react";
import {
    selectCurrentMessage,
    setCredentials,
} from "../../reducers/authSlice";
import { useLoginMutation } from "../../apis/authApiSlice";
import { useDispatch, useSelector } from "react-redux";
import { Link, useNavigate } from "react-router-dom";
import Logo from "../../assets/img/logo.png";
import Mail from "../../assets/img/icon/mail.svg";
import LoginImg from "../../assets/img/icon/sign-up.webp";

const Login = () => {
    const [email, setEmail] = useState("");
    const [emailError, setErrorEmail] = useState(false);
    const [password, setPassword] = useState("");
    const [passwordError, setErrorPassword] = useState(false);
    const [showPassword, setShowPassword] = useState(false);
    const [message, setMessage] = useState("");

    const [login, { data, error, isError, isLoading }] = useLoginMutation();
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const registerMessage = useSelector(selectCurrentMessage);

    useEffect(() => {
        const none = "none";
        window.document.getElementById("global-loader").style.display = none;
    }, []);

    const loginForm = async (e) => {
        e.preventDefault();

        if (emailError) setErrorEmail(true);
        else if (passwordError) setErrorPassword(true);
        else {
            if (email === "") {
                setErrorEmail(true);
            }
            if (password === "") {
                setErrorPassword(true);
            }
            if (email !== "" && password !== "") {
                window.document.getElementById("global-loader").style.display =
                    null;

                login({ email, password })
                    .unwrap()
                    .then((res) => {
                        const username = res.data.fullName;
                        const token = res.access_token;

                        dispatch(setCredentials({ username, token }));

                        window.localStorage.setItem(
                            "access_token",
                            res.access_token
                        );
                        window.localStorage.setItem(
                            "refresh_token",
                            res.refresh_token
                        );
                        window.localStorage.setItem("username", res.data.name);

                        navigate("/home");
                    })
                    .catch((error) => {
                        if (error.response === null) {
                            setMessage("No server response");
                        } else if (error.status === 400) {
                            setMessage("Missing username and/or password");
                        } else if (
                            error.status === 401 ||
                            error.status === 403
                        ) {
                            setMessage("Incorrect username and/or password");
                        } else {
                            setMessage("Login failed!");
                        }
                        const none = "none";

                        window.document.getElementById(
                            "global-loader"
                        ).style.display = none;
                    });
            }
        }
    };

    const isValidEmail = /^[\w-.]+@([\w-]+\.)+[\w-]{2,15}$/g;

    const validateEmail = (e) => {
        if (e.target?.value && e.target.value.match(isValidEmail)) {
            setEmail(e.target.value);
            setErrorEmail(false);
        } else {
            setErrorEmail(true);
            setEmail(e.target.value);
        }
    };

    const validatePassword = (e) => {
        if (e.target?.value && e.target.value.length > 7) {
            setErrorPassword(false);
            setPassword(e.target.value);
        } else {
            setErrorPassword(true);
            setPassword(e.target.value);
        }
    };

    return (
        <div className="account-content">
            {isLoading ? (
                <></>
            ) : (
                <div className="login-wrapper">
                    <div className="login-content">
                        <div className="login-userset">
                            <div className="login-logo">
                                <img src={Logo} alt="logo" />
                            </div>
                            <div className="login-userheading">
                                <h3>Sign In</h3>
                                <h4>Please login to your account</h4>
                                {message !== "" ? (
                                    <div
                                        className="d-grid col-12"
                                        style={{ textAlign: "center" }}
                                    >
                                        <span className="alert alert-danger">
                                            {" "}
                                            {message}
                                        </span>
                                    </div>
                                ) : (
                                    <></>
                                )}

                                {registerMessage !== "" ? (
                                    <div
                                        className="d-grid col-12"
                                        style={{ textAlign: "center" }}
                                    >
                                        <span className="alert alert-success">
                                            {" "}
                                            {registerMessage}
                                        </span>
                                    </div>
                                ) : (
                                    <></>
                                )}
                            </div>
                            <form onSubmit={(e) => loginForm(e)} method="post">
                                <div className="form-login">
                                    <label>Email</label>
                                    <div className="form-addons">
                                        <input
                                            type="email"
                                            placeholder="Enter your email address"
                                            value={email}
                                            onChange={validateEmail}
                                            className={
                                                emailError
                                                    ? "form-control is-invalid"
                                                    : "form-control"
                                            }
                                        />

                                        {emailError ? (
                                            <span
                                                style={{ fontSize: "12px" }}
                                                className="text-danger"
                                            >
                                                Invalid email address
                                            </span>
                                        ) : (
                                            <img src={Mail} alt="img" />
                                        )}
                                    </div>
                                </div>
                                <div className="form-login">
                                    <label>Password</label>
                                    <div className="pass-group">
                                        <input
                                            type={
                                                showPassword
                                                    ? "text"
                                                    : "password"
                                            }
                                            value={password}
                                            onChange={validatePassword}
                                            className={
                                                passwordError
                                                    ? "pass-input form-control is-invalid"
                                                    : "pass-input"
                                            }
                                            placeholder="Enter your password"
                                        />

                                        {passwordError ? (
                                            <span
                                                style={{ fontSize: "12px" }}
                                                className="text-danger"
                                            >
                                                Password should contain minimum
                                                eight characters.
                                            </span>
                                        ) : (
                                            <span
                                                onClick={() =>
                                                    setShowPassword(
                                                        !showPassword
                                                    )
                                                }
                                                className={
                                                    showPassword
                                                        ? "fas toggle-password fa-eye"
                                                        : "fas toggle-password fa-eye-slash"
                                                }
                                            ></span>
                                        )}
                                    </div>
                                </div>
                                <div className="form-login">
                                    <div className="alreadyuser">
                                        <h4>
                                            <Link
                                                to="/forgot-password"
                                                className="hover-a"
                                            >
                                                Forgot Password?
                                            </Link>
                                        </h4>
                                    </div>
                                </div>
                                <div className="form-login">
                                    <button
                                        type="submit"
                                        className="btn btn-login"
                                    >
                                        Sign In
                                    </button>
                                </div>
                            </form>
                            <div className="signinform text-center">
                                <h4>
                                    Don’t have an account?{" "}
                                    <Link to="/register" className="hover-a">
                                        Sign Up
                                    </Link>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div className="login-img">
                        <img
                            style={{ width: "100%" }}
                            className="img img-responsive"
                            src={LoginImg}
                            alt="img"
                        />
                    </div>
                </div>
            )}
        </div>
    );
};

export default Login;
