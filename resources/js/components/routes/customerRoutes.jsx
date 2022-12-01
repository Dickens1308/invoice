import React from 'react';
import {Route} from "react-router-dom";
import PrivateRoutes from './privateRoutes';
import CustomerList from "../pages/customer/customerList";
import CustomerCreate from "../pages/customer/customerCreate";
import CustomerEdit from "../pages/customer/customerEdit";

function CustomerRoutes() {
    return (
        <Route path='customers/' element={<PrivateRoutes/>}>
            <Route path="" element={<CustomerList/>}/>
            <Route path="create" element={<CustomerCreate/>}/>
            <Route path=":customerId/update" element={<CustomerEdit/>}/>
        </Route>
    );
}

export default CustomerRoutes;
