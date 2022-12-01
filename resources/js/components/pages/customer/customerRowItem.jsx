// noinspection JSIgnoredPromiseFromCall
// noinspection JSIgnoredPromiseFromCall

import React from 'react';
import {Link} from "react-router-dom";
import {format} from 'date-fns'
import EditButton from '../../assets/img/icon/edit.svg'
import DeleteButton from '../../assets/img/icon/delete.svg'
import Swal from 'sweetalert2';
import {useDeleteCustomerMutation} from "../../apis/customerApiSlice";


function CustomerRowItem({customer}) {
    const [deleteCustomer] = useDeleteCustomerMutation();
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        heightAuto: false,
        width: 400,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    return (
        <tr>
            <td>
                <label className="checkboxs">
                    <input type="checkbox"/>
                    <span className="checkmarks"></span>
                </label>
            </td>
            <td className="productimgname">
                <Link to="#">{`${customer.first_name} ${customer.last_name}`}</Link>
            </td>
            <td>{customer.email}</td>
            <td>{customer.gender}</td>
            <td>{customer.phone}</td>
            <td>{customer.address}</td>
            <td>{format(new Date(customer.created_at), 'yyyy-MM-dd')}</td>
            <td>
                <Link className="me-3"
                      to={`/customers/${customer.id}/update`}>
                    <img alt="img" src={EditButton}/>
                </Link>
                <Link className="me-3 confirm-text" onClick={() => {
                    Swal.fire({
                        title: 'Delete customer record!',
                        text: `You about to delete customer ${customer.first_name} ${customer.last_name}`,
                        icon: 'warning',
                        confirmButtonText: 'Delete',
                        showCancelButton: true,

                    }).then(r => {
                        if (r.isConfirmed)
                            deleteCustomer({id: customer.id}).then(res => {
                                console.log(res)
                                if (res.hasOwnProperty("data"))
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Customer was deleted',
                                    })

                                if (res.hasOwnProperty("error")) {
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Failed to delete customer',
                                    })
                                }
                            })
                    }).catch(e => {
                        // noinspection JSIgnoredPromiseFromCall
                        Swal.fire({
                            title: 'Failed to deleted customer!',
                            text: `An error occurred failed to delete customer`,
                            icon: 'success',
                            showCloseButton: true
                        })
                    })
                }}>
                    <img alt="img" src={DeleteButton}/>
                </Link>
            </td>
        </tr>
    );
}

export default CustomerRowItem;
