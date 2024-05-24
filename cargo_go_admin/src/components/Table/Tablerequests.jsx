import * as React from "react";
import { useState, useEffect } from "react";
import Table from "@mui/material/Table";
import TableBody from "@mui/material/TableBody";
import TableCell from "@mui/material/TableCell";
import TableContainer from "@mui/material/TableContainer";
import TableHead from "@mui/material/TableHead";
import TableRow from "@mui/material/TableRow";
import Paper from "@mui/material/Paper";
import "./Table.css";

function createData(trackingId, name, date, status, detail) {
  return { trackingId, name, date, status, detail };
}

export default function BasicTable() {
  const [complaints, setComplaints] = useState([]);
  useEffect(() => {
    fetch("http://localhost/Cargo_Go/v1/getallcomplaints.php")
      .then((response) => response.json())
      .then((data) => {
        if (data.error === false) {
          // Limit the complaints to the first 5 records
          const limitedComplaints = data.complaints.slice(0, 3);
          setComplaints(limitedComplaints);
        } else {
          console.error("Error fetching complaints:", data.message);
        }
      })
      .catch((error) => console.error("Error fetching complaints:", error));
  }, []);

  return (
    <div className="Table">
      <h3>Complaints</h3>
      <TableContainer
        component={Paper}
        style={{
          boxShadow: "0px 13px 20px 0px #80808029",
          maxHeight: "400px",
        }}
      >
        <Table sx={{ minWidth: 650 }} aria-label="simple table">
          <TableHead>
            <TableRow>
              <TableCell>Driver Name</TableCell>
              <TableCell align="left">Customer Name</TableCell>
              <TableCell align="left">Complaint type</TableCell>
              <TableCell align="left">Complaint description</TableCell>
              <TableCell align="left">Date</TableCell>
            </TableRow>
          </TableHead>
          <TableBody style={{ color: "white" }}>
            {complaints.map((complaint) => (
              <TableRow
                key={complaint.Complaint_ID}
                sx={{ "&:last-child td, &:last-child th": { border: 0 } }}
              >
                <TableCell component="th" scope="row">
                  {complaint.driver_name}
                </TableCell>
                <TableCell align="left">{complaint.customer_name}</TableCell>
                <TableCell align="left">{complaint.Complaint_Type}</TableCell>
                <TableCell align="left">
                  {complaint.Complaint_Description}
                </TableCell>
                <TableCell align="left">{complaint.Complaint_date}</TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    </div>
  );
}