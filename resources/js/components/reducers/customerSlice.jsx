import {createSlice} from "@reduxjs/toolkit";

const customerSlice = createSlice({
    name: 'customer',
    initialState: {
        customers: [],
        message: '',
    }, reducers: {
        setCustomerList: (state, action) => {
            const {list} = action.payload
            state.customers = list
        },
        setCustomerMessage: (state, action) => {
            const {message} = action.payload
            state.message = message
        }
    }
});


export const {setCustomerList, setCustomerMessage} = customerSlice.actions;

export default customerSlice.reducer;

export const selectCustomerList = (state) => state.customer.customers;
export const selectCustomerMessage = (state) => state.customer.message;
