import { BrowserRouter, Route, Routes } from 'react-router-dom';
import './App.css';
import Home from './components/Home';
import Navbar from './components/Navbar';

function App() {
  return (
    <div className="App">
      <BrowserRouter>
      <Navbar />
        <div>
          <Routes className="pt-16"> {/* Added padding to avoid overlap with the navbar */}
            <Route path="/" element={<Home />} />
            {/* Add more routes here as needed */}
          </Routes>
        </div>
      </BrowserRouter>
    </div>
  );
}

export default App;
