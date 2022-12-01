import React from 'react';

function GeneralSettings(props) {
    return (<div className="page-wrapper">
        <div className="content">
            <div className="page-header">
                <div className="page-title">
                    <h2 className='text-black-50'>Profile</h2>
                </div>
            </div>

            <div className="card">
                <div className="card-body">
                    <div className="profile-set">
                        <div className="profile-head">
                        </div>
                        <div className="profile-top">
                            <div className="profile-content">
                                <div className="profile-contentimg">
                                    <img
                                        src="https://dreamspos.dreamguystech.com/html/template/assets/img/customer/customer5.jpg"
                                        alt="img" id="blah"/>
                                    <div className="profileupload">
                                        <input type="file" id="imgInp"/>
                                        <a href="javascript:void(0);"><img
                                            src="https://dreamspos.dreamguystech.com/html/template/assets/img/icons/edit-set.svg"
                                            alt="img"/></a>
                                    </div>
                                </div>
                                <div className="profile-contentname">
                                    <h2>William Castillo</h2>
                                    <h4>Updates Your Photo and Personal Details.</h4>
                                </div>
                            </div>
                            <div className="ms-auto">
                                <button type='submit' className="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-lg-6 col-sm-12">
                            <div className="form-group">
                                <label>First Name</label>
                                <input type="text" placeholder="Enter first name"/>
                            </div>
                        </div>
                        <div className="col-lg-6 col-sm-12">
                            <div className="form-group">
                                <label>Last Name</label>
                                <input type="text" placeholder="Enter last name"/>
                            </div>
                        </div>
                        <div className="col-lg-6 col-sm-12">
                            <div className="form-group">
                                <label>Email</label>
                                <input type="text" placeholder="Enter email address"/>
                            </div>
                        </div>
                        <div className="col-lg-6 col-sm-12">
                            <div className="form-group">
                                <label>Phone</label>
                                <input type="text" placeholder="Enter phone number"/>
                            </div>
                        </div>
                        <div className="col-lg-6 col-sm-12">
                            <div className="form-group">
                                <label>Username</label>
                                <input type="text" placeholder="Enter username"/>
                            </div>
                        </div>

                        <div className="col-12">
                            <button type='submit' className="btn btn-primary">Save Changes</button>
                        </div>
                    </div>

                    <div className='dropdown-divider my-5'></div>

                    <div className="row">
                        <div className="col-lg-12 col-sm-12">
                            <div className="form-group">
                                <label>Old Password</label>
                                <div className="pass-group">
                                    <input type="password" placeholder='Current password'
                                           className="old-password pass-input"/>
                                    <span className="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-6 col-sm-12">
                            <div className="form-group">
                                <label>New Password</label>
                                <div className="pass-group">
                                    <input type="password" placeholder='New password' className="   pass-input"/>
                                    <span className="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-6 col-sm-12">
                            <div className="form-group">
                                <label>Confirm Password</label>
                                <div className="pass-group">
                                    <input type="password" className="pass-input" placeholder='Confirm new password'/>
                                    <span className="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>

                        <div className="col-12">
                            <button type='submit' className="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>);
}

export default GeneralSettings;
