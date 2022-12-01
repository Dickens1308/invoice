import React from "react";

const Unauthorized = () => {
    return <div className="error-box">
        <h1>401</h1>
        <h3 className="h2 mb-3"><i className="fas fa-exclamation-circle"></i> Unauthorized!</h3>
        <p className="h4 font-weight-normal">You are not authorized to view given resource.</p>
        <a href="/" className="btn btn-primary">Back to Home</a>
    </div>
};

export default Unauthorized;
