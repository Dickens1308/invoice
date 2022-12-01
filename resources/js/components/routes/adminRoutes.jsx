import React from "react";
import { Route } from "react-router-dom";
import AdminDashboard from "../pages/admin";
import PrivateRoutes from "./privateRoutes";

const AdminRoutes = () => {
    return (
        <Route path="admin/" element={<PrivateRoutes />}>
            <Route path="" exact element={<AdminDashboard />} />
        </Route>
    );
};

export default AdminRoutes;
