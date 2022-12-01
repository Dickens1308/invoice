import React from "react";
import {BrowserRouter as Router, Route, Routes} from "react-router-dom";
import {Provider} from "react-redux";
import {store} from "./store";
import AuthRoutes from "./routes/authRoutes";
import Base from "./layouts/Base";
import HomePage from "./pages/home/homePage";
import ErrorRoutes from "./routes/errorRoutes";
import AdminRoutes from "./routes/adminRoutes";
import HomeRoutes from "./routes/homeRoutes";
import CustomerRoutes from "./routes/customerRoutes";
import {AnimatePresence} from "framer-motion";

const RootApp = () => {
    return (
        <Provider store={store}>
            <Router>
                <AnimatePresence>
                    <Routes>
                        <Route path="/" element={<Base/>}>
                            <Route path="" exact element={<HomePage/>}/>
                            {HomeRoutes()}
                            {AdminRoutes()}
                            {CustomerRoutes()}
                            {AuthRoutes()}
                            {ErrorRoutes()}
                        </Route>
                    </Routes>
                </AnimatePresence>
            </Router>
        </Provider>
    );
};

export default RootApp;
