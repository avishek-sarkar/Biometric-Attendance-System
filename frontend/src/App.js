import { BrowserRouter, Route, Routes } from 'react-router-dom';
import './App.css';
import Home from './components/Home';
import Login from './components/Login';
import Logout from './components/Logout';
import Navbar from './components/Navbar';
import StudentDashboard from './components/StudentDashboard';
import StudentRegister from './components/StudentRegister';
import TeacherDashboard from './components/TeacherDashboard';
import TeacherRegister from './components/TeacherRegister';


function App() {
  return (
    <div className="App">
      <BrowserRouter>
      <Navbar />
        <div>
          <Routes className="pt-16"> {/* Added padding to avoid overlap with the navbar */}
            <Route path="/" element={<Home />} />
            <Route path="/student-register" element={<StudentRegister />} />
            <Route path="/teacher-register" element={<TeacherRegister />} />
            <Route path="/teacher-dashboard" element={<TeacherDashboard />} />
            <Route path="/student-dashboard" element={<StudentDashboard />} />
            <Route path="/login" element={<Login />} />
            <Route path="/logout" element={<Logout />} />
            {/* Add more routes here as needed */}
          </Routes>
        </div>
      </BrowserRouter>
    </div>
  );
}

export default App;
