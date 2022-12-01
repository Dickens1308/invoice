import {createSlice} from "@reduxjs/toolkit";

const authSlice = createSlice({
    name: 'auth', initialState: {
        user: window.localStorage.getItem('username') === null ? null : window.localStorage.getItem('username'),
        token: window.localStorage.getItem('access_token') === null ? null : window.localStorage.getItem('access_token'),
        message: '',
    }, reducers: {
        setCredentials: (state, action) => {
            const {user, accessToken} = action.payload
            state.user = user
            state.token = accessToken
        }, setAuthMessage: (state, action) => {
            const {message} = action.payload
            state.message = message
        }, logOut: (state) => {
            state.user = null
            state.token = null
        }
    }
});


export const {setCredentials, logOut, setAuthMessage} = authSlice.actions;

export default authSlice.reducer;

export const selectCurrentUser = (state) => state.auth.user;
export const selectCurrentToken = (state) => state.auth.token;
export const selectCurrentMessage = (state) => state.auth.message;
