import React, {useEffect, useState} from 'react';
import '../../assets/css/spinner.css'
import {useUpdateCustomerMutation} from "../../apis/customerApiSlice";
import {useNavigate, useParams} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {selectCustomerList, setCustomerMessage} from "../../reducers/customerSlice";
import {motion} from "framer-motion";

const CustomerEdit = () => {

    const [fname, setFname] = useState('');
    const [fnameErr, setFnameErr] = useState(false)

    const [lname, setLname] = useState('');
    const [lnameErr, setLnameErr] = useState(false)

    const [email, setEmail] = useState('');
    const [emailErr, setEmailErr] = useState(false)

    const [phone, setPhone] = useState('');
    const [phoneErr, setPhoneErr] = useState(false)

    const [gender, setGender] = useState('');
    const [genderErr, setGenderErr] = useState(false)

    const [address, setAddress] = useState('');
    const [addressErr, setAddressErr] = useState(false)

    const [message, setMessage] = useState("")

    const navigation = useNavigate();
    const customers = useSelector(selectCustomerList);
    let {customerId} = useParams();
    const dispatch = useDispatch();

    const [updateCustomer, {isLoading}] = useUpdateCustomerMutation();

    useEffect(() => {
        const data = customers.find((e) => {
            return e.id == customerId
        });

        if (data !== null) {
            setEmail(data.email)
            setPhone(data.phone)
            setAddress(data.address)
            setGender(data.gender.toLowerCase())
            setFname(data.first_name)
            setLname(data.last_name)
        }
    }, []);

    const sendDataToBackend = async (e) => {
        updateCustomer({
            'id': customerId,
            'first_name': fname,
            'last_name': lname,
            'email': email,
            'phone_number': phone,
            'home_address': address,
            'gender': gender,
        })
            .unwrap()
            .then((res) => {

                if (res.message === 'customer updated successful') {
                    const message = res.message
                    dispatch(setCustomerMessage({message}))
                    navigation(-1)
                }

            }).catch((e) => {
            if (e.data.message === 'Customer not found in the storage')
                setMessage(e.data.message)

            if (e.data.message === 'Permission denied')
                setMessage("You not allowed to edit customer data")

            else
                setMessage("An error occurred, please try again?")
        });
    }

    const onFormSubmit = async (e) => {
        e.preventDefault()

        if (address === "")
            setAddressErr(true)

        if (fname === "")
            setFnameErr(true)

        if (lname === "")
            setLnameErr(true)

        if (phone === "")
            setPhoneErr(true)

        if (gender === "")
            setGenderErr(true)

        if (email === "")
            setEmailErr(true)


        if (address !== "" && fname !== "" && lname !== ""
            && gender !== "" && phone !== "" && email !== "") {
            await sendDataToBackend();
        }

    }

    const validateName = (e) => {
        setFname(e.target.value);
        if (e.target?.value && e.target.value.length > 3) {
            setFnameErr(false);
        } else {
            setFnameErr(true);
        }
    }

    const validateLName = (e) => {
        setLname(e.target.value);
        if (e.target?.value && e.target.value.length > 3) {
            setLnameErr(false);
        } else {
            setLnameErr(true);
        }
    }

    const validateGender = (e) => {
        setGender(e.target.value)
        if (e.target?.value === "male" || e.target?.value === "female") {
            setGenderErr(false);
        } else {
            setGenderErr(true);
        }
    }

    const validateEmail = (e) => {
        const isValidEmail = /^[\w-.]+@([\w-]+\.)+[\w-]{2,15}$/g;

        setEmail(e.target.value);
        if (e.target?.value && e.target.value.match(isValidEmail))
            setEmailErr(false);
        else
            setEmailErr(true);
    };

    const validatePhone = (e) => {
        setPhone(e.target.value)
        if (e.target?.value && e.target.value.length > 9) {
            setPhoneErr(false);
        } else {
            setPhoneErr(true);
        }
    }

    const validateAddress = (e) => {
        setAddress(e.target.value)
        if (e.target?.value && e.target.value.length > 3) {
            setAddressErr(false);
        } else {
            setAddressErr(true);
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
                            <h4>Customer Management</h4>
                            <h6>Add / Update Customer</h6>
                        </div>
                    </div>

                    <div className="card">
                        <div className="card-body">
                            {
                                message !== "" ?
                                    <div className="alert alert-danger" role="alert">
                                        {message}
                                    </div> : <></>
                            }
                            <form method='post' onSubmit={(e) => onFormSubmit(e)}>
                                <div className="row">
                                    <div className="col-lg-6 col-sm-6 col-12">
                                        <div className="form-group">
                                            <label>Customer First Name</label>
                                            <input type="text"
                                                   className={
                                                       fnameErr
                                                           ? "form-control is-invalid"
                                                           : "form-control"
                                                   }
                                                   value={fname} onChange={(e) => validateName(e)}
                                            />

                                            {fnameErr ? (
                                                <span
                                                    style={{fontSize: "12px"}}
                                                    className="text-danger"
                                                >
                                                Name should contains at least 4 characters
                                            </span>
                                            ) : <></>}
                                        </div>
                                    </div>

                                    <div className="col-lg-6 col-sm-6 col-12">
                                        <div className="form-group">
                                            <label>Customer Last Name</label>
                                            <input type="text"
                                                   className={
                                                       lnameErr
                                                           ? "form-control is-invalid"
                                                           : "form-control"
                                                   }
                                                   value={lname} onChange={(e) => validateLName(e)}
                                            />

                                            {lnameErr ? (
                                                <span
                                                    style={{fontSize: "12px"}}
                                                    className="text-danger"
                                                >
                                                Name should contains at least 4 characters
                                            </span>
                                            ) : <></>}
                                        </div>
                                    </div>

                                    <div className="col-lg-6 col-sm-6 col-12">
                                        <div className="form-group">
                                            <label>Customer Email</label>
                                            <input type="email"
                                                   className={
                                                       emailErr
                                                           ? "form-control is-invalid"
                                                           : "form-control"
                                                   }
                                                   value={email} onChange={(e) => validateEmail(e)}/>

                                            {emailErr ? (
                                                <span
                                                    style={{fontSize: "12px"}}
                                                    className="text-danger"
                                                >
                                                Invalid email address
                                            </span>
                                            ) : <></>}
                                        </div>
                                    </div>

                                    <div className="col-lg-6 col-sm-6 col-12">
                                        <div className="form-group">
                                            <label>Customer Phone</label>
                                            <input type="tel"
                                                   className={
                                                       phoneErr
                                                           ? "form-control is-invalid"
                                                           : "form-control"
                                                   }
                                                   value={phone} onChange={(e) => validatePhone(e)}/>

                                            {phoneErr ? (
                                                <span
                                                    style={{fontSize: "12px"}}
                                                    className="text-danger"
                                                >
                                                Name should contains at least 10 characters
                                            </span>
                                            ) : <></>}
                                        </div>
                                    </div>

                                    <div className="col-lg-6 col-sm-6 col-12">
                                        <div className="form-group">
                                            <label>Address</label>
                                            <input type="text"
                                                   className={
                                                       addressErr
                                                           ? "form-control is-invalid"
                                                           : "form-control"
                                                   }
                                                   value={address} onChange={(e) => validateAddress(e)}/>

                                            {addressErr ? (
                                                <span
                                                    style={{fontSize: "12px"}}
                                                    className="text-danger"
                                                >
                                                Name should contains at least 4 characters
                                            </span>
                                            ) : <></>}
                                        </div>
                                    </div>

                                    <div className="col-lg-6 col-sm-6 col-12">
                                        <div className="form-group">
                                            <label>Choose Gender</label>
                                            <select value={gender}
                                                    className={
                                                        genderErr
                                                            ? "form-control is-invalid"
                                                            : "form-control"
                                                    }
                                                    onChange={(e) => validateGender(e)}
                                                    data-select2-id="1"
                                                    tabIndex="-1" aria-hidden="true">
                                                <option>Choose Gender</option>
                                                <option value='male'>Male</option>
                                                <option value='female'>Female</option>
                                            </select>

                                            {genderErr ? (
                                                <span
                                                    style={{fontSize: "12px"}}
                                                    className="text-danger"
                                                >
                                                Select either male or female
                                            </span>
                                            ) : <></>}
                                        </div>
                                    </div>

                                    <div className="col-12 col-lg-12">
                                        {
                                            !isLoading ?
                                                <button className="btn btn-primary" type='submit'>Submit</button> :
                                                <div className="loadingio-spinner-spinner-1dab3uixhn5">
                                                    <div className="ldio-kak9xq6l6f9">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>
                                        }
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </motion.div>
    );
}

export default CustomerEdit;
