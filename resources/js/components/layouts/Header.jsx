import React, {useState} from 'react';
import {useDispatch, useSelector} from "react-redux";
import {logOut, selectCurrentUser} from "../reducers/authSlice";
import {useLogoutMutation} from "../apis/authApiSlice";
import {Link, useNavigate} from "react-router-dom";
import LogoutSvg from '../assets/img/icon/log-out.svg'
import Logo from '../assets/img/logo.png'
import LogoSmall from '../assets/img/logo-small.png'


const Header = () => {
    const [sideBar, setSideBar] = useState(false)
    const [toggleBar, setToggleBar] = useState(false)

    const username = useSelector(selectCurrentUser)

    const [logout] = useLogoutMutation()
    const dispatch = useDispatch()
    const navigate = useNavigate()

    const logoutUser = () => {
        window.document.getElementById('global-loader').style.display = null;

        logout().unwrap().then((res) => {
            navigate('/login')
        }).catch((err) => {
            console.log("Token expired already, login!")
        }).finally(() => {
            dispatch(logOut())
            const none = 'none';
            window.localStorage.clear()
            window.document.getElementById('global-loader').style.display = none;
        })
    }

    return (<div className="header">
        <div id="header-left" className="header-left active">
            <Link to="/" className="logo">
                <img src={Logo} alt=""/>
            </Link>
            <Link to="/" className="logo-small">
                <img src={LogoSmall} alt=""/>
            </Link>
            <Link id="toggle_btn" className="active" to="#" onClick={() => {
            }}>
            </Link>
        </div>

        <Link id="mobile_btn" className="mobile_btn" to="#" onClick={() => {
            setSideBar(!sideBar)
            if (sideBar) {
                window.document.getElementById('root').classList.add('slide-nav')
                window.document.getElementById('sidebar-overlay').classList.add('opened')
            } else {
                window.document.getElementById('root').classList.remove('slide-nav')
                window.document.getElementById('sidebar-overlay').classList.remove('opened')
            }
        }}>
        <span className="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
        </Link>

        <ul className="nav user-menu">

            <li className="nav-item">
                <div className="top-nav-search">
                    <a href="#" className="responsive-search">
                        <i className="fa fa-search"></i>
                    </a>
                    <form action="#">
                        <div className="searchinputs">
                            <input type="text" placeholder="Search Here ..."/>
                            <div className="search-addon">
                            <span><img
                                src="https://dreamspos.dreamguystech.com/html/template/assets/img/icons/closes.svg"
                                alt="img"/></span>
                            </div>
                        </div>
                        <a className="btn" id="searchdiv"><img
                            src="https://dreamspos.dreamguystech.com/html/template/assets/img/icons/search.svg"
                            alt="img"/></a>
                    </form>
                </div>
            </li>

            <li className="nav-item dropdown">
                <a href="#" className="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                    <img
                        src="https://dreamspos.dreamguystech.com/html/template/assets/img/icons/notification-bing.svg"
                        alt="img"/> <span className="badge rounded-pill">4</span>
                </a>
            </li>

            <li className="nav-item dropdown has-arrow main-drop">
                <a href="#" className="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span className="user-img"><img
                    src="https://dreamspos.dreamguystech.com/html/template/assets/img/profiles/avator1.jpg"
                    alt=""/>
                    <span className="status online"></span></span>
                </a>
                <div className="dropdown-menu menu-drop-user">
                    <div className="profilename">
                        <div className="profileset">
                                <span className="user-img">
                                    <img
                                        src="https://dreamspos.dreamguystech.com/html/template/assets/img/profiles/avator1.jpg"
                                        alt=""/>
                                    <span className=""></span>
                                </span>
                            <div className="profilesets">
                                <p style={{"fontSize": "14px"}}>{username}</p>
                                {/*<p>Admin</p>*/}
                            </div>
                        </div>
                        <hr className="m-0"/>
                        <a className="dropdown-item"
                           href="/home/profile">
                            <i className="me-2" data-feather="user"></i> My Profile</a>
                        <a className="dropdown-item"
                           href="https://dreamspos.dreamguystech.com/html/template/generalsettings.html"><i
                            className="me-2" data-feather="settings"></i>Settings</a>
                        <hr className="m-0"/>
                        <a onClick={() => logoutUser()} className="dropdown-item logout pb-0" href="#">
                            <img src={LogoutSvg} className="me-2" alt="img"/>Logout
                        </a>
                    </div>
                </div>
            </li>
        </ul>

        <div className="dropdown mobile-user-menu">
            <a href="#" className="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i
                className="fa fa-ellipsis-v"></i></a>
            <div className="dropdown-menu dropdown-menu-right">
                <a className="dropdown-item" href="https://dreamspos.dreamguystech.com/html/template/profile.html">My
                    Profile</a>
                <a className="dropdown-item"
                   href="https://dreamspos.dreamguystech.com/html/template/generalsettings.html">Settings</a>
                <a className="dropdown-item"
                   href="https://dreamspos.dreamguystech.com/html/template/signin.html">Logout</a>
            </div>
        </div>
    </div>);
}

export default Header;
