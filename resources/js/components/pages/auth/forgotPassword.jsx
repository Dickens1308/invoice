import React, {useState} from 'react';
import LoginImg from "../../assets/img/login.jpg";
import Mail from "../../assets/img/icon/mail.svg";
import Logo from "../../assets/img/logo.png";
import {Link} from "react-router-dom";

function ForgotPassword() {
    const [email, setEmail] = useState("");
    const [emailError, setErrorEmail] = useState(false);

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

    const submitResetForm = (e) => {
        e.preventDefault()
    }


    return (<div className="account-content">
        <div className="login-wrapper">
            <div className="login-content">
                <div className="login-userset ">
                    <div className="login-logo">
                        <img src={Logo} alt="logo"/>
                    </div>
                    <div className="login-userheading">
                        <h3>Forgot password?</h3>
                        <h4>Don’t worry! it happens. Please enter the address <br/>
                            associated with your account.</h4>
                    </div>
                    <div className="form-login">
                        <label>Email</label>
                        <div className="form-addons">
                            <input
                                type="email" value={email} onChange={validateEmail}
                                autoFocus={true}
                                className={emailError ? "form-control is-invalid" : "form-control"}
                                placeholder="Enter your email address"/>

                            {emailError ? <span
                                style={{fontSize: "12px"}}
                                className="text-danger"
                            >
                                            Invalid email address
                                        </span> : <img
                                src={Mail}
                                alt="img"
                            />}
                        </div>
                    </div>
                    <div className="form-login">
                        <button type='submit' className="btn btn-login">Submit</button>
                    </div>

                    <div className="signinform text-center">
                        <h4>
                            Remembered account password? {" "}
                            <Link
                                to="/login"
                                className="hover-a"
                            >
                                Sign In
                            </Link>
                        </h4>
                    </div>
                </div>
            </div>
            <div className="login-img">
                <img src={LoginImg} alt="img"/>
            </div>
        </div>
    </div>);
}

export default ForgotPassword;
