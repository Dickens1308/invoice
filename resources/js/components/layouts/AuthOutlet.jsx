import React, {useEffect} from 'react';
import {Outlet, useLocation} from "react-router-dom";

function AuthOutlet(props) {
    const location = useLocation().pathname;

    useEffect(() => {
        if (location === '/login' || location === '/register') {
            window.document.body.className = "account-page"
        }
    }, [])

    return <Outlet/>;
}

export default AuthOutlet;
