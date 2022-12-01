import React from "react";

const InternalServer = () => {
    return <div className="error-box">
        <h1>500</h1>
        <h3 className="h2 mb-3"><i className="fas fa-exclamation-circle"></i> Oops! Internal Server Error!</h3>
        <p className="h4 font-weight-normal">An error occurred during processing your request.</p>
        <a href="/" className="btn btn-primary">Back to Home</a>
    </div>;
};

export default InternalServer;
