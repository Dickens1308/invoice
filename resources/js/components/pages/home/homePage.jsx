import React from "react";
import {motion} from "framer-motion";

const HomePage = () => {
    return (
        <motion.div
            initial={{opacity: 0}}
            animate={{opacity: 1}}
            exit={{opacity: 0}}
        ></motion.div>
    );
};

export default HomePage;
