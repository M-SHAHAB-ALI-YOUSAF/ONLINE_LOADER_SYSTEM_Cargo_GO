import React, { useState, useEffect } from "react";
import Table from "../Table/Tablerequests";
import "./Cards.css";

function Home({ Toggle }) {
  const [dashboardData, setDashboardData] = useState(null);

  useEffect(() => {
    fetch("http://localhost/Cargo_Go/v1/dashbaordadmindata.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => setDashboardData(data))
      .catch((error) => console.error("Error fetching data:", error));
  }, []);
  

  return (
    <div className="px-3">
      <div className="d">
        <h3>Dashboard</h3>
        {dashboardData && (
          <div className="container-fluid">
            <div className="row g-3 my-2">
              <div className="col-md-3 p-1">
                <div className="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                  <div>
                    <h3 className="fs-2">{dashboardData.total_booking}</h3>
                    <p className="fs-6">Total Bookings</p>
                  </div>
                  <i className="bi bi-cart-plus p-3 fs-1"></i>
                </div>
              </div>
              <div className="col-md-3 p-1">
                <div className="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                  <div>
                    <h3 className="fs-2">
                      {dashboardData.complete_booking}
                    </h3>{" "}
                    <p className="fs-6">Complete Booking</p>{" "}
                  </div>{" "}
                  <i className="bi bi-currency-dollar p-3 fs-1"></i>{" "}
                </div>{" "}
              </div>{" "}
              <div className="col-md-3 p-1">
                <div className="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                  <div>
                    <h3 className="fs-2">{dashboardData.cancel_booking}</h3>{" "}
                    <p className="fs-6">Cancel Bookings</p>{" "}
                  </div>{" "}
                  <i className="bi bi-truck p-3 fs-1"></i>{" "}
                </div>{" "}
              </div>{" "}
              <div className="col-md-3 p-1">
                <div className="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                  <div>
                    <h3 className="fs-2">{dashboardData.total_user}</h3>{" "}
                    <p className="fs-6">Total Users</p>{" "}
                  </div>{" "}
                  <i className="bi bi-graph-up-arrow p-3 fs-1"></i>{" "}
                </div>{" "}
              </div>{" "}
            </div>{" "}
          </div>
        )}
      </div>
      <Table />
    </div>
  );
}

export default Home;
