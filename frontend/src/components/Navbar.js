import { useEffect, useRef, useState } from 'react';
import { Link } from 'react-router-dom';

const Navbar = () => {
    const [isOpen, setIsOpen] = useState(false);
    const sidebarRef = useRef(null);
    const buttonRef = useRef(null);

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

    const navLinks = (
        <>
            <Link to="/" className="block px-2 py-2 hover:bg-gray-700 rounded" onClick={() => setIsOpen(false)}>Home</Link>
            <Link to="/about" className="block px-2 py-2 hover:bg-gray-700 rounded" onClick={() => setIsOpen(false)}>Register as Teacher</Link>
            <Link to="/contact" className="block px-2 py-2 hover:bg-gray-700 rounded" onClick={() => setIsOpen(false)}>Register as Student</Link>
            <Link to="/contact" className="block px-2 py-2 hover:bg-gray-700 rounded" onClick={() => setIsOpen(false)}>Teacher Dashboard</Link>
            <Link to="/contact" className="block px-2 py-2 hover:bg-gray-700 rounded" onClick={() => setIsOpen(false)}>Student Dashboard</Link>
            <Link to="/contact" className="block px-2 py-2 hover:bg-gray-700 rounded" onClick={() => setIsOpen(false)}>Login</Link>
            <Link to="/contact" className="block px-2 py-2 hover:bg-gray-700 rounded" onClick={() => setIsOpen(false)}>Logout</Link>
        </>
    );

    return (
        <div className="relative">
            {/* Main Navbar - Below the sidebar */}
            <nav className="bg-gray-800 text-white fixed w-full z-10 shadow-md top-0">
            <div className="max-w-7xl mx-auto px-0 sm:px-1 lg:px-0"> {/* Reduced horizontal padding */}
                <div className="flex justify-between items-center h-16">
                    {/* Logo with reduced left margin */}
                    <div className="flex-shrink-0 -ml-3"> {/* Added negative margin to pull it left */}
                        <Link to="/" className="text-white text-lg md:text-xl font-bold pl-0"> {/* Added pl-0 to remove padding */}
                            Biometric Attendance Management System
                        </Link>
                    </div>

                    {/* Desktop Menu pulled to the right edge */}
                    <div className="hidden md:flex space-x-0 -mr-3"> {/* Added negative margin to pull it right */}
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
                    className="text-white bg-blue-600 rounded-full p-2 focus:outline-none shadow-lg" /* Changed button color for visibility */
                    onClick={() => setIsOpen(!isOpen)}
                    aria-label="Toggle menu"
                >
                    <svg 
                        className="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="white" /* Made the icon white */
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
                        className="fixed top-16 right-0 w-48 h-auto bg-gray-900 z-30 shadow-lg flex flex-col pt-4 pb-8" /* Added more bottom padding */
                    >
                        {/* Menu Links */}
                        <div className="flex flex-col px-4 space-y-3 mt-4"> {/* Increased vertical spacing */}
                            {navLinks}
                        </div>
                    </div>
                </>
            )}
        </div> 
    );
};

export default Navbar;