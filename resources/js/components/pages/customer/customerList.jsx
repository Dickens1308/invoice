import '../../assets/css/spinner.css'
import React, {useEffect, useRef, useState} from 'react';
import {useGetCustomersFilterQuery, useGetCustomersQuery} from "../../apis/customerApiSlice";
import CustomerRowItem from "./customerRowItem";
import AddIcon from '../../assets/img/icon/plus.svg'
import FilterIcon from '../../assets/img/icon/filter.svg'
import SearchIcon from '../../assets/img/icon/search-white.svg'
import PdfIcon from '../../assets/img/icon/pdf.svg'
import ExcelIcon from '../../assets/img/icon/excel.svg'
import PrintIcon from '../../assets/img/icon/printer.svg'
import {Link} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {
    selectCustomerList,
    selectCustomerMessage,
    setCustomerList,
    setCustomerMessage
} from "../../reducers/customerSlice";
import Swal from "sweetalert2";
import {motion} from "framer-motion";
import LinkPaginator from "../../layouts/linkPaginator";
import {useReactToPrint} from "react-to-print";
import TableSpinner from "../../layouts/tableSpinner";

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    heightAuto: false,
    width: 500,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

const CustomerList = () => {
    const [list, setList] = useState([]);
    const [size, setSize] = useState(10);
    const [page, setPage] = useState(1);
    const [total, setTotal] = useState(0)
    const [links, setLinks] = useState([])
    const [from, setFrom] = useState(0)
    const [to, setTo] = useState(0)

    const tableRefPrint = useRef();

    const handlePrint = useReactToPrint({
        content: () => tableRefPrint.current,
        documentTitle: 'Customer List',
        onBeforePrint: (e) => {
            console.log("passed")
        },
        onAfterPrint: () => {
        }
    })

    const dispatch = useDispatch();
    const customers = useSelector(selectCustomerList);
    const customerMsg = useSelector(selectCustomerMessage)

    const [search, setSearch] = useState('')
    const {data, isLoading, isSuccess, isError, isFetching} = useGetCustomersQuery({page, size});

    useEffect(() => {
        if (customers && customers.length)
            setList(customers)
    }, [customers])

    useEffect(() => {
        if (customerMsg !== "") {
            Toast.fire({
                icon: 'success',
                title: customerMsg === "customer updated successful" ?
                    'Customer updated successful' : "customer created successful",
            }).then(() => {
                const message = ""
                dispatch(setCustomerMessage({message}))
            })
        }
    }, [customerMsg])

    useEffect(() => {
        if (isSuccess) {
            if (data.data && data.data.length) {
                {
                    dataFromApi(data)
                }
            }
        }
    }, [data, isError]);

    const dataFromApi = (data) => {
        const list = data.data;
        const myLinks = [].concat(data.meta.links).reverse()
        dispatch(setCustomerList({list}))
        setLinks(myLinks)
        setPage(data.meta.current_page)
        setFrom(data.meta.from);
        setTo(data.meta.to);
        setTotal(data.meta.total);
    }

    const changePage = (pageNo) => setPage(pageNo)

    const searchFormSubmit = (e) => {
        setSearch(e.target.value)
        if (search !== "") {
            const {data} = useGetCustomersFilterQuery({page, size, search})
            // if (data && data.length)
            //     dataFromApi(data)
        }
    }

    return (
        <motion.div
            initial={{opacity: 0}}
            animate={{opacity: 1}}
            exit={{opacity: 0}}
        >
            <div className="page-wrapper">
                <div className="content">
                    <div className="page-header">
                        <div className="page-title">
                            <h4>Customer List</h4>
                            <h6>Manage your Customers</h6>
                        </div>
                        <div className="page-btn">
                            <Link className="btn btn-added" to={'/customers/create'}>
                                <img alt="img" src={AddIcon}/>Add Customer
                            </Link>
                        </div>
                    </div>

                    <div className="card">
                        <div className="card-body">
                            <div className="table-top">
                                <div className="search-set">
                                    <div className="search-path">
                                        <a className="btn btn-filter" id="filter_search">
                                            <img alt="img" src={FilterIcon}/>
                                        </a>
                                    </div>
                                    <div className="search-input">
                                        <a className="btn btn-searchset">
                                            <img alt="img" src={SearchIcon}/></a>

                                        <div id="DataTables_Table_0_filter" className="dataTables_filter">
                                            <label>
                                                <input type="search"
                                                       value={search}
                                                       onChange={searchFormSubmit}
                                                       className="form-control form-control-sm"
                                                       placeholder="Search..."
                                                       aria-controls="DataTables_Table_0"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div className="wordset">
                                    <ul>
                                        <li>
                                            <a onClick={() => handlePrint()} data-bs-placement="top"
                                               data-bs-toggle="tooltip" title="pdf">
                                                <img alt="img" src={PdfIcon}/></a>
                                        </li>
                                        <li>
                                            <a data-bs-placement="top" data-bs-toggle="tooltip" title="excel">
                                                <img alt="img" src={ExcelIcon}/>
                                            </a>
                                        </li>
                                        <li>
                                            <a onClick={() => handlePrint()} data-bs-placement="top"
                                               data-bs-toggle="tooltip" title="print">
                                                <img alt="img" src={PrintIcon}/>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div className="table-responsive" ref={tableRefPrint}>
                                <table className="table  datanew">
                                    <thead>
                                    <tr>
                                        <th>
                                            <label className="checkboxs">
                                                <input id="select-all" type="checkbox"/>
                                                <span className="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th>Customer Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Phone Number</th>
                                        <th>Home Address</th>
                                        <th>Create Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {
                                        list && list.length && (!isLoading || !isFetching) ?
                                            list.map(customer =>
                                                <CustomerRowItem key={customer.id}
                                                                 customer={customer}
                                                />)
                                            : (isLoading || isFetching) ?
                                                <TableSpinner/>
                                                : <tr className='border-white border-0'>
                                                    <td></td>
                                                    <td>
                                              <span className='text text-black-50 text-xl'>
                                                  Not customer Found in Storage
                                              </span>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                    }
                                    </tbody>
                                </table>

                            </div>
                            <div>
                                <div className="dataTables_length" id="DataTables_Table_0_length">
                                    <label>
                                        <select value={size} onChange={(e) => setSize(e.target.value)}
                                                name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"
                                                className="custom-select custom-select-sm form-control form-control-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="1000">1000</option>
                                            <option value="10000">10000</option>
                                        </select>
                                    </label>
                                </div>

                                {
                                    links && links.length ?
                                        <LinkPaginator page={page} links={links} changePage={changePage}/> : <></>
                                }

                                <div style={{"marginTop": "25px"}} className="dataTables_info"
                                     id="DataTables_Table_0_info" role="status"
                                     aria-live="polite">{from} - {to} of {total} items
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </motion.div>
    );
}

export default CustomerList;
