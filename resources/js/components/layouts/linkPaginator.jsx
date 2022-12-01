import React from 'react';

const LinkPaginator = ({page, links, changePage}) => {
    return (
        links.map(link =>
            <div key={link.label} className="dataTables_paginate paging_numbers" id="DataTables_Table_0_paginate">
                <ul className="pagination">
                    {
                        link.label === "&laquo; Previous" ?
                            <li className={`paginate_button page-item ${link.url !== null ? '' : 'disabled'}`}>
                                <a onClick={() => {
                                    link.url !== null ? changePage(page - 1) : null
                                }
                                } className="page-link">Prev
                                </a>
                            </li> : <></>
                    }

                    {
                        (link.label !== "&laquo; Previous" && link.label !== "Next &raquo;") ?
                            <li className={`paginate_button page-item ${link.active === true ? 'active' :
                                link.label === '...' ? 'disabled' : ''}`}>
                                <a
                                    onClick={() => {
                                        link.label !== '...' ? changePage(link.label) : null
                                    }}
                                    className="page-link">{link.label}
                                </a>
                            </li>
                            : <></>
                    }

                    {
                        link.label === "Next &raquo;" ?
                            <li className={`paginate_button page-item ${link.url !== null ? '' : 'disabled'}`}>
                                <a
                                    onClick={() => {
                                        link.url !== null ? changePage(page + 1) : null
                                    }}
                                    className="page-link">Next
                                </a>
                            </li> : <></>
                    }
                </ul>
            </div>
        )
    );
}

export default LinkPaginator;
