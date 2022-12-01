import {apiSlice} from "./apiSlice";

export const customerApiSlice = apiSlice.injectEndpoints({
    tagTypes: ['Customers'],
    endpoints: (builder) => ({
        getCustomers: builder.query({
            query: ({page, size}) => ({
                url: `/customers?page=${page}&size=${size}`,
                method: 'GET'
            }),
            providesTags: ['Customers']
        }),
        getCustomersFilter: builder.query({
            query: ({page, size, search}) => ({
                url: `/customers/filter?page=${page}&size=${size}&search=${search}`,
                method: 'GET'
            }),
            invalidatesTags: ['Customers']
        }),
        addCustomer: builder.mutation({
            query: (customer) => ({
                url: '/customers',
                method: 'POST',
                body: customer
            }),
            invalidatesTags: ['Customers']
        }),
        updateCustomer: builder.mutation({
            query: (customer) => ({
                url: `/customers/${customer.id}`,
                method: 'PUT',
                body: customer
            }),
            invalidatesTags: ['Customers']
        }),
        deleteCustomer: builder.mutation({
            query: ({id}) => ({
                url: `/customers/${id}`,
                method: 'DELETE'
            }),
            invalidatesTags: ['Customers']
        }),
    }),
})

export const {
    useGetCustomersQuery,
    useGetCustomersFilterQuery,
    useAddCustomerMutation,
    useUpdateCustomerMutation,
    useDeleteCustomerMutation
} = customerApiSlice
