import {configureStore} from "@reduxjs/toolkit";
import authReducer from "../reducers/authSlice";
import customerReducer from '../reducers/customerSlice';
import {apiSlice} from "../apis/apiSlice";

export const store = configureStore({
    reducer: {
        [apiSlice.reducerPath]: apiSlice.reducer,
        auth: authReducer,
        customer: customerReducer,
    },
    middleware: (getDefaultMiddleware) =>
        getDefaultMiddleware().concat(apiSlice.middleware),
    devTools: true,
});
