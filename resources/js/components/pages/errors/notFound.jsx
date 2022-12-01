import React, {useEffect} from "react";
import {Link} from "react-router-dom";

const NotFound = () => {
    useEffect(() => {
        window.document.body.className = 'error-page';
    }, []);

    return <div className="error-box">
        <h1>404</h1>
        <h3 className="h2 mb-3"><i className="fas fa-exclamation-circle"></i> Oops! Page not found!</h3>
        <p className="h4 font-weight-normal">The page you requested was not found.</p>
        <Link to="/home" className="btn btn-primary">Back to Home</Link>
    </div>;
};

export default NotFound;
