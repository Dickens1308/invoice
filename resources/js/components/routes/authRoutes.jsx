import React from "react";
import {Route} from "react-router-dom";
import Login from "../pages/auth/login";
import Register from "../pages/auth/Register";
import ForgotPassword from "../pages/auth/forgotPassword";
import AuthOutlet from "../layouts/AuthOutlet";

const AuthRoutes = () => {
    return (<Route element={<AuthOutlet />}>
        <Route path="login" element={<Login/>}/>
        <Route path="register" element={<Register/>}/>
        <Route path="forgot-password" element={<ForgotPassword/>}/>
        <Route path="lockscreen" element={<Login/>}/>
    </Route>);
};

export default AuthRoutes;
