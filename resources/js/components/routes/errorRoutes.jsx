import React, {useEffect} from "react";
import {Route} from "react-router-dom";
import BadRequest from "../pages/errors/badRequest";
import Forbidden from "../pages/errors/Forbidden";
import InternalServer from "../pages/errors/internalServer";
import NotFound from "../pages/errors/notFound";
import Unauthorized from "../pages/errors/Unauthorized";

const ErrorRoutes = () => {
    useEffect(() => {
        const none = 'none'
        window.document.getElementById('global-loader').style.display = none;
    }, []);

    return (
        <Route>
            <Route path="*" element={<NotFound/>}/>
            <Route path="500" element={<InternalServer/>}/>
            <Route path="400" element={<BadRequest/>}/>
            <Route path="401" element={<Unauthorized/>}/>
            <Route path="403" element={<Forbidden/>}/>
        </Route>
    );
};

export default ErrorRoutes;
