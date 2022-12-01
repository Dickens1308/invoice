import React, { useEffect, useState } from "react";
import { useRegisterMutation } from "../../apis/authApiSlice";
import { Link, useNavigate } from "react-router-dom";
import LoginImg from "../../assets/img/icon/sign-up.webp";
import User1 from "../../assets/img/icon/users1.svg";
import Logo from "../../assets/img/logo.png";
import { useDispatch } from "react-redux";
import { setAuthMessage } from "../../reducers/authSlice";
import Mail from "../../assets/img/icon/mail.svg";

const Register = () => {
    useEffect(() => {
        const none = "none";
        window.document.getElementById("global-loader").style.display = none;
    }, []);

    const [username, setUsername] = useState("");
    const [usernameError, setUsernameError] = useState(false);
    const [email, setEmail] = useState("");
    const [emailError, setErrorEmail] = useState(false);
    const [password, setPassword] = useState("");
    const [passwordError, setErrorPassword] = useState(false);
    const [showPassword, setShowPassword] = useState(false);
    const [message, setMessage] = useState("");

    //Response From Server
    const [resEmail, setResEmail] = useState("");
    const [resEmail1, setResEmail1] = useState("");
    const [resUsername, setResUsername] = useState("");
    const [resUsername1, setResUsername1] = useState("");
    const [resPassword, setResPassword] = useState("");
    const [resPassword1, setResPassword1] = useState("");
    const [resPassword2, setResPassword2] = useState("");

    const [register, { isLoading }] = useRegisterMutation();
    const navigate = useNavigate();
    const dispatch = useDispatch();

    const registerForm = async (e) => {
        e.preventDefault();

        if (email === "") {
            setErrorEmail(true);
        }
        if (password === "") {
            setErrorPassword(true);
        }
        if (username === "") {
            setUsernameError(true);
        }

        if (
            !emailError &&
            username !== "" &&
            email !== "" &&
            password !== "" &&
            !passwordError &&
            !usernameError
        ) {
            window.document.getElementById("global-loader").style.display =
                null;

            register({ username, email, password })
                .unwrap()
                .then(() => {
                    const message = "Successful registered, login to continue?";
                    dispatch(setAuthMessage({ message }));
                    navigate("/login");
                })
                .catch((error) => {
                    if (error.response === null) {
                        setMessage("No server response");
                    } else if (error.status === 403) {
                        if (error.data.data.hasOwnProperty("email")) {
                            setResEmail(error.data.data?.email[0]);
                            setResEmail1(error.data.data?.email[1]);
                        }
                        if (error.data.data?.hasOwnProperty("password")) {
                            setResPassword(error.data.data?.password[0]);
                            setResPassword1(error.data.data?.password[1]);
                            setResPassword2(error.data.data?.password[2]);
                        }
                        if (error.data.data?.hasOwnProperty("username")) {
                            setResUsername(error.data.data?.username[0]);
                            setResUsername1(error.data.data?.username[1]);
                        }

                        setMessage("Please fix error(s) below!");
                    } else {
                        navigate("/500");
                    }
                })
                .finally(() => {
                    window.document.getElementById(
                        "global-loader"
                    ).style.display = "none";
                });
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
        const re = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

        if (re.test(e.target?.value)) {
            setErrorPassword(false);
            setPassword(e.target.value);
        } else {
            setErrorPassword(true);
            setPassword(e.target.value);
        }
    };

    const validateUsername = (e) => {
        if (e.target?.value && e.target.value.length > 5) {
            setUsernameError(false);
            setUsername(e.target.value);
        } else {
            setUsernameError(true);
            setUsername(e.target.value);
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
                                <h3>Create an Account</h3>
                                {message !== "" ? (
                                    <div
                                        className="d-grid col-12"
                                        style={{ textAlign: "center" }}
                                    >
                                        <span className="alert alert-danger text-lg">
                                            {message}
                                        </span>
                                    </div>
                                ) : (
                                    <></>
                                )}
                            </div>
                            <form
                                onSubmit={(e) => registerForm(e)}
                                method="post"
                            >
                                <div className="form-login">
                                    <label>Username</label>
                                    <div className="form-addons">
                                        <input
                                            type="text"
                                            placeholder="Enter your full name"
                                            value={username}
                                            style={{ backgroundImage: "none" }}
                                            onChange={validateUsername}
                                            className={
                                                usernameError
                                                    ? "form-control is-invalid"
                                                    : "form-control"
                                            }
                                        />
                                        <img src={User1} alt="img" />

                                        {usernameError ? (
                                            <span
                                                style={{ fontSize: "12px" }}
                                                className="text-danger"
                                            >
                                                Username should contain minimum
                                                six characters
                                            </span>
                                        ) : (
                                            <></>
                                        )}

                                        {resUsername !== "" ? (
                                            <span
                                                style={{ fontSize: "12px" }}
                                                className="text-danger"
                                            >
                                                {resUsername}
                                            </span>
                                        ) : (
                                            <></>
                                        )}
                                        {resUsername1 !== "" ? (
                                            <span
                                                style={{ fontSize: "12px" }}
                                                className="text-danger"
                                            >
                                                {resUsername1}
                                            </span>
                                        ) : (
                                            <></>
                                        )}
                                    </div>
                                </div>
                                <div className="form-login">
                                    <label>Email</label>
                                    <div className="form-addons">
                                        <input
                                            type="email"
                                            placeholder="Enter your email address"
                                            value={email}
                                            style={{ backgroundImage: "none" }}
                                            onChange={validateEmail}
                                            className={
                                                emailError
                                                    ? "form-control is-invalid"
                                                    : "form-control"
                                            }
                                        />
                                        <img src={Mail} alt="img" />
                                        {emailError ? (
                                            <span
                                                style={{ fontSize: "12px" }}
                                                className="text-danger"
                                            >
                                                Invalid email address
                                            </span>
                                        ) : (
                                            <></>
                                        )}

                                        {resEmail !== "" ? (
                                            <span
                                                style={{ fontSize: "12px" }}
                                                className="text-danger"
                                            >
                                                {resEmail}
                                            </span>
                                        ) : (
                                            <></>
                                        )}
                                        {resEmail1 !== "" ? (
                                            <span
                                                style={{ fontSize: "12px" }}
                                                className="text-danger"
                                            >
                                                {resEmail1}
                                            </span>
                                        ) : (
                                            <></>
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
                                            style={{ backgroundImage: "none" }}
                                            className={
                                                passwordError
                                                    ? "pass-input form-control is-invalid"
                                                    : "pass-input"
                                            }
                                            placeholder="Enter your password"
                                        />
                                        <span
                                            onClick={() =>
                                                setShowPassword(!showPassword)
                                            }
                                            className={
                                                showPassword
                                                    ? "fas toggle-password fa-eye"
                                                    : "fas toggle-password fa-eye-slash"
                                            }
                                        ></span>
                                    </div>
                                    {passwordError ? (
                                        <span
                                            style={{ fontSize: "12px" }}
                                            className="text-danger"
                                        >
                                            The Password must contain at least
                                            eight letters. <br />
                                            The password must contain at least
                                            one uppercase and one lowercase
                                            letter. <br />
                                            The password must contain at least
                                            one symbol. <br />
                                            The password must contain at least
                                            one number. <br />
                                        </span>
                                    ) : (
                                        <></>
                                    )}

                                    {resPassword !== "" ? (
                                        <span
                                            style={{ fontSize: "12px" }}
                                            className="text-danger"
                                        >
                                            {resPassword}
                                        </span>
                                    ) : (
                                        <></>
                                    )}
                                    <br />
                                    {resPassword1 !== "" ? (
                                        <span
                                            style={{ fontSize: "12px" }}
                                            className="text-danger"
                                        >
                                            {resPassword1}
                                        </span>
                                    ) : (
                                        <></>
                                    )}
                                    <br />
                                    {resPassword2 !== "" ? (
                                        <span
                                            style={{ fontSize: "12px" }}
                                            className="text-danger"
                                        >
                                            {resPassword2}
                                        </span>
                                    ) : (
                                        <></>
                                    )}
                                </div>
                                {isLoading ? (
                                    <div id="global-loader">
                                        <div className="whirly-loader"></div>
                                    </div>
                                ) : (
                                    <div className="form-login">
                                        <button
                                            type="submit"
                                            className="btn btn-login"
                                        >
                                            Sign Up
                                        </button>
                                    </div>
                                )}
                            </form>
                            <div className="signinform text-center">
                                <h4>
                                    Already a user?
                                    <Link to="/login" className="hover-a">
                                        {" "}
                                        Sign In
                                    </Link>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div className="login-img">
                        <img src={LoginImg} alt="img" />
                    </div>
                </div>
            )}
        </div>
    );
};

export default Register;
