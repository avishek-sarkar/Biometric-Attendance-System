import { useEffect, useRef, useState } from 'react';
import { Link } from 'react-router-dom';

const Navbar = () => {
    const [isOpen, setIsOpen] = useState(false);
    const [isDropdownOpen, setIsDropdownOpen] = useState(false);
    const sidebarRef = useRef(null);
    const buttonRef = useRef(null);
    const dropdownRef = useRef(null);

    // Handle clicks outside sidebar to close it
    useEffect(() => {
        const handleClickOutside = (event) => {
            if (isOpen && 
                sidebarRef.current && 
                !sidebarRef.current.contains(event.target) &&
                buttonRef.current && 
                !buttonRef.current.contains(event.target)) {
                setIsOpen(false);
            }
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, [isOpen]);

    // Function to handle register option clicks
    const handleRegisterOptionClick = () => {
        setIsDropdownOpen(false); // Close dropdown
        setIsOpen(false); // Close sidebar
    };

    const navLinks = (
        <>
            <Link to="/" className="block px-2 py-2 hover:bg-gray-700 rounded text-white" onClick={() => setIsOpen(false)}>Home</Link>
            <div className="dropdown dropdown-hover" ref={dropdownRef}>
                <div 
                    tabIndex={0} 
                    role="button" 
                    className="block px-2 py-2 hover:bg-gray-700 rounded text-white"
                    onClick={() => setIsDropdownOpen(!isDropdownOpen)}
                >
                    Register
                </div>
                <div 
                    tabIndex={0} 
                    className={`dropdown-content z-[1] menu p-1 shadow bg-gray-800 rounded-box w-25 ${isDropdownOpen ? 'block' : 'md:block hidden'}`}
                >
                    <Link 
                        to="/student-register" 
                        className="block px-4 py-2 hover:bg-gray-600 rounded text-white" 
                        onClick={handleRegisterOptionClick}
                    >
                        Student
                    </Link>
                    <Link 
                        to="/teacher-register" 
                        className="block px-4 py-2 hover:bg-gray-600 rounded text-white" 
                        onClick={handleRegisterOptionClick}
                    >
                        Teacher
                    </Link>
                </div>
            </div>
            <Link to="/teacher-dashboard" className="block px-2 py-2 hover:bg-gray-700 rounded text-white" onClick={() => setIsOpen(false)}>Teacher Dashboard</Link>
            <Link to="/student-dashboard" className="block px-2 py-2 hover:bg-gray-700 rounded text-white" onClick={() => setIsOpen(false)}>Student Dashboard</Link>
            <Link to="/login" className="block px-2 py-2 hover:bg-gray-700 rounded text-white" onClick={() => setIsOpen(false)}>Login</Link>
            <Link to="/logout" className="block px-2 py-2 hover:bg-gray-700 rounded text-white" onClick={() => setIsOpen(false)}>Logout</Link>
        </>
    );

    return (
        <div className="relative">
            {/* Main Navbar - Below the sidebar */}
            <nav className="bg-gray-800 text-white fixed w-full z-10 shadow-md top-0">
                <div className="max-w-7xl mx-auto px-2 sm:px-3 lg:px-2"> {/* Added more padding */}
                    <div className="flex justify-between items-center h-16">
                        {/* Logo with better visibility */}
                        <div className="flex-shrink-0">
                            <Link to="/" className="text-white text-lg md:text-xl font-bold px-2">
                                Biometric Attendance Management System
                            </Link>
                        </div>

                        {/* Desktop Menu */}
                        <div className="hidden md:flex space-x-1">
                            {navLinks}
                        </div>
                    </div>
                </div>
            </nav>

            {/* Three Dots Button - Always Visible in top-right corner */}
            <div className="fixed top-2 right-2 z-40 md:hidden">
                <button
                    ref={buttonRef}
                    type="button"
                    className="text-white bg-blue-600 rounded-full p-2 focus:outline-none shadow-lg"
                    onClick={() => setIsOpen(!isOpen)}
                    aria-label="Toggle menu"
                >
                    <svg 
                        className="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="white"
                        strokeWidth={2}
                    >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>
            </div>

            {/* Right Side Mobile Sidebar */}
            {isOpen && (
                <>
                    {/* Overlay to capture clicks outside */}
                    <div className="fixed inset-0 bg-black bg-opacity-50 z-20" onClick={() => setIsOpen(false)}></div>
                    
                    {/* Sidebar */}
                    <div 
                        ref={sidebarRef}
                        className="fixed top-16 right-0 w-48 h-auto bg-gray-900 z-30 shadow-lg flex flex-col pt-4 pb-8"
                    >
                        {/* Menu Links */}
                        <div className="flex flex-col px-4 space-y-3 mt-4">
                            {navLinks}
                        </div>
                    </div>
                </>
            )}
        </div> 
    );
};

export default Navbar;