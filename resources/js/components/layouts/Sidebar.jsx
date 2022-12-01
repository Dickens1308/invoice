import React, { useState } from "react";
import DashboardSvg from "../assets/img/icon/dashboard.svg";
import ProductSvg from "../assets/img/icon/purchase1.svg";
import ExpenseSvg from "../assets/img/icon/expense1.svg";
import UserSvg from "../assets/img/icon/users1.svg";
import { Link, useLocation } from "react-router-dom";

const Sidebar = (props) => {
    const [customer, setCustomer] = useState(false);
    const location = useLocation().pathname;

    return (
        <div className="sidebar" id="sidebar">
            <div className="slimScrollDiv">
                <div className="sidebar-inner slimscroll">
                    <div id="sidebar-menu" className="sidebar-menu">
                        <ul>
                            <li
                                className={location === "/home" ? "active" : ""}
                            >
                                <Link to="/home">
                                    <img src={DashboardSvg} alt="img" />
                                    <span> Dashboard</span>{" "}
                                </Link>
                            </li>

                            <li
                                className="submenu"
                                onClick={() => setCustomer(!customer)}
                            >
                                <Link
                                    to="#"
                                    className={
                                        !customer
                                            ? ""
                                            : location === "/customers" ||
                                              location === "/customers/create"
                                            ? "subdrop active"
                                            : "subdrop"
                                    }
                                >
                                    <img src={UserSvg} alt="img" />
                                    <span> Customers</span>{" "}
                                    <span className="menu-arrow"></span>
                                </Link>
                                <ul
                                    style={{
                                        display:
                                            customer ||
                                            location === "/customers" ||
                                            location === "/customers/create"
                                                ? "block"
                                                : "none",
                                    }}
                                >
                                    <li>
                                        <Link
                                            className={
                                                location === "/customers"
                                                    ? "active"
                                                    : ""
                                            }
                                            to="/customers"
                                        >
                                            Customer List
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            className={
                                                location === "/customers/create"
                                                    ? "active"
                                                    : ""
                                            }
                                            to="/customers/create"
                                        >
                                            Customer Create
                                        </Link>
                                    </li>
                                </ul>
                            </li>

                            <li
                                className="submenu"
                                onClick={() => setCustomer(!customer)}
                            >
                                <Link
                                    to="#"
                                    className={
                                        !customer
                                            ? ""
                                            : location === "/customers" ||
                                              location === "/customers/create"
                                            ? "subdrop active"
                                            : "subdrop"
                                    }
                                >
                                    <img src={UserSvg} alt="img" />
                                    <span> Customers</span>{" "}
                                    <span className="menu-arrow"></span>
                                </Link>
                                <ul
                                    style={{
                                        display:
                                            customer ||
                                            location === "/customers" ||
                                            location === "/customers/create"
                                                ? "block"
                                                : "none",
                                    }}
                                >
                                    <li>
                                        <Link
                                            className={
                                                location === "/customers"
                                                    ? "active"
                                                    : ""
                                            }
                                            to="/customers"
                                        >
                                            Customer List
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            className={
                                                location === "/customers/create"
                                                    ? "active"
                                                    : ""
                                            }
                                            to="/customers/create"
                                        >
                                            Customer Create
                                        </Link>
                                    </li>
                                </ul>
                            </li>

                            <li className="submenu">
                                <Link to="#">
                                    <img src={ProductSvg} alt="img" />
                                    <span> Purchase</span>{" "}
                                    <span className="menu-arrow"></span>
                                </Link>
                                <ul>
                                    <li>
                                        <Link to="/purchaser.html">
                                            Purchase List
                                        </Link>
                                    </li>
                                    <li>
                                        <Link to="/purchase.html">
                                            Add Purchase
                                        </Link>
                                    </li>
                                    <li>
                                        <Link to="/importpurchase.html">
                                            Import Purchase
                                        </Link>
                                    </li>
                                </ul>
                            </li>
                            <li className="submenu">
                                <Link to="#">
                                    <img src={ExpenseSvg} alt="img" />
                                    <span> Expense</span>{" "}
                                    <span className="menu-arrow"></span>
                                </Link>
                                <ul>
                                    <li>
                                        <Link to="/expenselist.html">
                                            Expense List
                                        </Link>
                                    </li>
                                    <li>
                                        <Link to="/createexpense.html">
                                            Add Expense
                                        </Link>
                                    </li>
                                    <li>
                                        <Link to="/expensecategory.html">
                                            Expense Category
                                        </Link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Sidebar;
