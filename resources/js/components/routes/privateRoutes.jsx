import React, {useEffect} from "react";
import {Navigate, Outlet, useLocation} from "react-router-dom";
import {useSelector} from "react-redux";
import {selectCurrentToken} from "../reducers/authSlice";
import Header from "../layouts/Header";
import Sidebar from "../layouts/Sidebar";

const PrivateRoutes = (props) => {
    const token = useSelector(selectCurrentToken)
    const location = useLocation()

    useEffect(() => {
        const none = 'none';
        window.document.getElementById('global-loader').style.display = none;
    }, []);

    return (token !== null ? <>
        <Header/>
        <Sidebar/>
        <Outlet/>
    </> : <Navigate to='/login' state={{from: location}} replace/>)
};

export default PrivateRoutes;
