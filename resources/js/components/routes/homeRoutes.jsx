import React from "react";
import {Route} from "react-router-dom";
import PrivateRoutes from "../routes/privateRoutes";
import HomePage from "../pages/home/homePage";
import GeneralSettings from "../pages/profile/generalSettings";

function HomeRoutes() {
    return (<Route path="home/" element={<PrivateRoutes/>}>
        <Route exact path="" element={<HomePage/>}/>
        <Route path="profile" element={<GeneralSettings/>}/>
    </Route>);
}

export default HomeRoutes;
