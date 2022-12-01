import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";
import { logOut, setCredentials } from "../reducers/authSlice";

const baseQuery = fetchBaseQuery({
    baseUrl: "http://localhost:8000/api/",
    // credentials: 'include',
    prepareHeaders: (headers) => {
        // const token = getState().auth.token
        const token = localStorage.getItem("access_token");

        if (token) {
            headers.set("authorization", `Bearer ${token}`);
        }

        headers.set("accept", "application/json");

        return headers;
    },
});

const baseQueryWithReauth = async (args, api, extraOptions) => {
    let result = await baseQuery(args, api, extraOptions);

    if (result?.error?.status === 401) {
        // Get New Access Token
        const refreshResult = await baseQuery(
            {
                url: "/auth/refresh",
                method: "post",
                headers: {
                    Authorization: window.localStorage.getItem("refresh_token"),
                    accept: "application/json",
                },
            },
            api,
            extraOptions
        );

        console.log(refreshResult);

        if (refreshResult?.data) {
            const user = api.getState().auth.user;
            window.localStorage.setItem(
                "access_token",
                refreshResult.data.access_token
            );
            api.dispatch(
                setCredentials({ user, ...refreshResult.data.access_token })
            );

            // Retry The Original Query
            result = await baseQuery(args, api, extraOptions);
        } else {
            api.dispatch(logOut());
            localStorage.removeItem("access_token");
            localStorage.removeItem("refresh_token");
        }
    }

    return result;
};

export const apiSlice = createApi({
    baseQuery: baseQueryWithReauth,
    endpoints: () => ({}),
});
