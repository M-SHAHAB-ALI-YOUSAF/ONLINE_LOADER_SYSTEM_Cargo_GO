// App.js
import React, { useState } from "react";
import "./App.css";
import MainDash from './components/MainDash/MainDash';
import RequestDash from './components/RequestDash/RequestDash'
import Sidebar from './components/Sidebar';
import ComplaintsDash from "./components/ComplaintsDash/ComplaintsDash";

function App() {
  const [selectedOption, setSelectedOption] = useState("Dashboard");

  return (
    <div className="App">
      <div className="AppGlass">
        <Sidebar setSelectedOption={setSelectedOption} />
        {selectedOption === "Dashboard" && <MainDash />}
        {/* {/* {selectedOption === "Requests" && <RequestDash />} */}
        {selectedOption === "Complaints" && <ComplaintsDash />}
       
      </div>
    </div>
  );
}

export default App;
