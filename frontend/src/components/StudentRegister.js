import { useState } from 'react';
import { FaEye, FaEyeSlash, FaFingerprint } from 'react-icons/fa';
import { toast, ToastContainer } from 'react-toastify';

const StudentRegister = () => {
  const [formData, setFormData] = useState({
    name: '',
    roll: '',
    reg: '',
    currentSession: '',
    actualSession: '',
    email: '',
    phone: '+880',
    password: '',
    confirmPassword: ''
  });

  const [errors, setErrors] = useState({});
  const [loading, setLoading] = useState(false);
  const [showPassword, setShowPassword] = useState(false);
  const [showConfirmPassword, setShowConfirmPassword] = useState(false);

  const handleChange = (e) => {
    const { name, value } = e.target;
    
    // Special handling for phone number to keep +880 prefix
    if (name === 'phone') {
      let phoneValue = value;
      if (!phoneValue.startsWith('+880')) {
        phoneValue = '+880';
      }
      // Only allow numbers after +880
      if (phoneValue.length > 4) {
        const numbers = phoneValue.slice(4).replace(/[^\d]/g, '');
        phoneValue = '+880' + numbers;
      }
      // Limit to maximum length (+880 + 10 digits)
      if (phoneValue.length > 14) {
        phoneValue = phoneValue.slice(0, 14);
      }
      setFormData({ ...formData, [name]: phoneValue });
    } else {
      setFormData({ ...formData, [name]: value });
    }
  };

  const validate = () => {
    const newErrors = {};
    
    // Name validation
    if (!formData.name.trim()) {
      newErrors.name = 'Name is required';
    } else if (formData.name.length < 2) {
      newErrors.name = 'Name must be at least 2 characters long';
    }
    
    // Roll validation
    if (!formData.roll) {
      newErrors.roll = 'Roll number is required';
    } else if (!/^\d{8}$/.test(formData.roll)) {
      newErrors.roll = 'Roll number must be exactly 8 digits';
    }
    
    // Registration number validation
    if (!formData.reg) {
      newErrors.reg = 'Registration number is required';
    } else if (!/^\d{4,}$/.test(formData.reg)) {
      newErrors.reg = 'Registration number must be at least 4 digits';
    }
    
    // Session validation
    if (!formData.currentSession) {
      newErrors.currentSession = 'Please select current session';
    }
    
    if (!formData.actualSession) {
      newErrors.actualSession = 'Please select actual session';
    }
    
    // Email validation
    if (!formData.email) {
      newErrors.email = 'Email is required';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      newErrors.email = 'Email address is invalid';
    }
    
    // Phone validation
    if (!formData.phone) {
      newErrors.phone = 'Phone number is required';
    } else if (!/^\+880\d{10}$/.test(formData.phone)) {
      newErrors.phone = 'Phone number should be in +880XXXXXXXXXX format';
    }
    
    // Password validation
    if (!formData.password) {
      newErrors.password = 'Password is required';
    } else if (formData.password.length < 8) {
      newErrors.password = 'Password must be at least 8 characters';
    } else if (!/[A-Z]/.test(formData.password)) {
      newErrors.password = 'Password must contain at least one uppercase letter';
    } else if (!/[a-z]/.test(formData.password)) {
      newErrors.password = 'Password must contain at least one lowercase letter';
    } else if (!/\d/.test(formData.password)) {
      newErrors.password = 'Password must contain at least one number';
    } else if (!/[!@#$%^&*]/.test(formData.password)) {
      newErrors.password = 'Password must contain at least one special character (!@#$%^&*)';
    }
    
    // Confirm password validation
    if (!formData.confirmPassword) {
      newErrors.confirmPassword = 'Please confirm your password';
    } else if (formData.password !== formData.confirmPassword) {
      newErrors.confirmPassword = 'Passwords do not match';
    }
    
    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    
    if (validate()) {
      setLoading(true);
      
      try {
        // Replace with your actual API endpoint
        const response = await fetch('http://localhost:8000/attendance/register-student/', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(formData),
        });
        
        const data = await response.json();
        
        if (response.ok) {
          toast.success('Registration successful!');
          // Reset form
          setFormData({
            name: '',
            roll: '',
            reg: '',
            currentSession: '',
            actualSession: '',
            email: '',
            phone: '+880',
            password: '',
            confirmPassword: ''
          });
        } else {
          alert(`Registration failed: ${data.message}`);
        }
      } catch (error) {
        alert('An error occurred during registration. Please try again.');
      } finally {
        setLoading(false);
      }
    }
  };

  // Session years for dropdown options
  const sessionYears = [
    '2018-19', '2019-20', '2020-21', '2021-22', 
    '2022-23', '2023-24', '2024-25', '2025-26', '2026-27'
  ];

  return (
    <div className="min-h-screen pt-16 bg-gradient-to-r from-blue-100 via-cyan-50 to-amber-100">
      <div className="container mx-auto px-4 py-8">
        <div className="flex justify-center">
          <div className="w-full max-w-2xl">
            <div className="bg-white/90 p-8 rounded-xl shadow-md animate-fadeIn">
              <div className="text-center mb-6">
                <div className="relative w-20 h-20 mx-auto">
                  <FaFingerprint className="text-5xl text-blue-600 mx-auto animate-pulse absolute inset-0" />
                </div>
                <h2 className="text-2xl font-bold mt-4 text-indigo-700">Student Registration</h2>
              </div>
              
              <form onSubmit={handleSubmit}>
                <div className="mb-4">
                  <label htmlFor="name" className="block text-gray-700 font-medium mb-1">Full Name</label>
                  <input
                    type="text"
                    id="name"
                    name="name"
                    value={formData.name}
                    onChange={handleChange}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                  />
                  {errors.name && <p className="text-red-500 text-sm mt-1">{errors.name}</p>}
                </div>

                <div className="mb-4">
                  <label htmlFor="roll" className="block text-gray-700 font-medium mb-1">Roll Number</label>
                  <input
                    type="text"
                    id="roll"
                    name="roll"
                    value={formData.roll}
                    onChange={handleChange}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                  />
                  {errors.roll && <p className="text-red-500 text-sm mt-1">{errors.roll}</p>}
                </div>

                <div className="mb-4">
                  <label htmlFor="reg" className="block text-gray-700 font-medium mb-1">Registration Number</label>
                  <input
                    type="text"
                    id="reg"
                    name="reg"
                    value={formData.reg}
                    onChange={handleChange}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                  />
                  {errors.reg && <p className="text-red-500 text-sm mt-1">{errors.reg}</p>}
                </div>

                <div className="mb-4">
                  <label htmlFor="currentSession" className="block text-gray-700 font-medium mb-1">Current Session</label>
                  <select
                    id="currentSession"
                    name="currentSession"
                    value={formData.currentSession}
                    onChange={handleChange}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                  >
                    <option value="">Select Current Session</option>
                    {sessionYears.map(year => (
                      <option key={`current-${year}`} value={year}>{year}</option>
                    ))}
                  </select>
                  {errors.currentSession && <p className="text-red-500 text-sm mt-1">{errors.currentSession}</p>}
                </div>

                <div className="mb-4">
                  <label htmlFor="actualSession" className="block text-gray-700 font-medium mb-1">Actual Session</label>
                  <select
                    id="actualSession"
                    name="actualSession"
                    value={formData.actualSession}
                    onChange={handleChange}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                  >
                    <option value="">Select Actual Session</option>
                    {sessionYears.map(year => (
                      <option key={`actual-${year}`} value={year}>{year}</option>
                    ))}
                  </select>
                  {errors.actualSession && <p className="text-red-500 text-sm mt-1">{errors.actualSession}</p>}
                </div>

                <div className="mb-4">
                  <label htmlFor="email" className="block text-gray-700 font-medium mb-1">Email</label>
                  <input
                    type="email"
                    id="email"
                    name="email"
                    value={formData.email}
                    onChange={handleChange}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                  />
                  {errors.email && <p className="text-red-500 text-sm mt-1">{errors.email}</p>}
                </div>

                <div className="mb-4">
                  <label htmlFor="phone" className="block text-gray-700 font-medium mb-1">Phone Number</label>
                  <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value={formData.phone}
                    onChange={handleChange}
                    onKeyDown={(e) => {
                      // Prevent deletion of +880 prefix
                      if (e.key === 'Backspace' && e.target.value.length <= 4) {
                        e.preventDefault();
                      }
                    }}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                  />
                  {errors.phone && <p className="text-red-500 text-sm mt-1">{errors.phone}</p>}
                </div>

                <div className="mb-4">
                  <label htmlFor="password" className="block text-gray-700 font-medium mb-1">Password</label>
                  <div className="relative">
                    <input
                      type={showPassword ? "text" : "password"}
                      id="password"
                      name="password"
                      value={formData.password}
                      onChange={handleChange}
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      required
                    />
                    <button
                      type="button"
                      className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                      onClick={() => setShowPassword(!showPassword)}
                    >
                      {showPassword ? <FaEyeSlash /> : <FaEye />}
                    </button>
                  </div>
                  {errors.password && <p className="text-red-500 text-sm mt-1">{errors.password}</p>}
                </div>

                <div className="mb-6">
                  <label htmlFor="confirmPassword" className="block text-gray-700 font-medium mb-1">Confirm Password</label>
                  <div className="relative">
                    <input
                      type={showConfirmPassword ? "text" : "password"}
                      id="confirmPassword"
                      name="confirmPassword"
                      value={formData.confirmPassword}
                      onChange={handleChange}
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      required
                    />
                    <button
                      type="button"
                      className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                      onClick={() => setShowConfirmPassword(!showConfirmPassword)}
                    >
                      {showConfirmPassword ? <FaEyeSlash /> : <FaEye />}
                    </button>
                  </div>
                  {errors.confirmPassword && <p className="text-red-500 text-sm mt-1">{errors.confirmPassword}</p>}
                </div>

                {loading && (
                  <div className="text-center mb-4">
                    <div className="spinner-border animate-spin inline-block w-8 h-8 border-4 border-t-blue-500 border-r-transparent border-b-blue-500 border-l-transparent rounded-full"></div>
                    <p className="mt-2 text-gray-600">Processing registration...</p>
                  </div>
                )}

                <button
                  type="submit"
                  className="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105"
                  disabled={loading}
                >
                  Register
                </button>
              </form>
              <ToastContainer/>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default StudentRegister;