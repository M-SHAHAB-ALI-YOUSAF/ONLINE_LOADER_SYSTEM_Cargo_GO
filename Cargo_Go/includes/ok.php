private void fetchDataFromServer(String vehicleType) {
    

        StringRequest stringRequest = new StringRequest(
                Request.Method.POST,
                Constants.URL_Booking_details
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        progressDialog.dismiss();

                        try {
                            // Check if the response is empty or null
                            if (response == null || response.isEmpty()) {
                                Toast.makeText(getActivity(), "Empty response received", Toast.LENGTH_SHORT).show();
                                return;
                            }

                            // Parse the response as JSON
                            JSONObject jsonObject = new JSONObject(response);

                            // Check if the response contains the "error" key
                            if (!jsonObject.getBoolean("error")) {
                                // Retrieve the available drivers array from the JSON object
                                JSONArray driversArray = jsonObject.getJSONArray("booking_details");

                                // Process the driver data
                                List<DriverRequstModel> driverList = new ArrayList<>();
                                for (int i = 0; i < driversArray.length(); i++) {
                                    JSONObject driverObject = driversArray.getJSONObject(i);
                                    String driverId = driverObject.getString("Driver_ID");
                                    String name = driverObject.getString("Driver_First_Name") + " " + driverObject.getString("Driver_Last_Name");
                                    String vehicle = driverObject.getString("Vehicle_type");
                                    String plateNumber = driverObject.getString("Vehicle_number");
                                    String cost = driverObject.getString("Vehicle_Model");
                                    String imageURL = driverObject.getString("Driver_Profile_Image");

                                    driverList.add(new DriverRequstModel(driverId, imageURL, name, vehicle, plateNumber, cost));
                                }

                                // Create and set the adapter
                                adapter = new DriverInfoAdapter(getContext(), driverList, getFragmentManager(), args);
                                recyclerView.setAdapter(adapter);
                            } else {
                                // If the "error" key is present, display the error message
                                String message = jsonObject.getString("message");
                                Toast.makeText(getActivity(), message, Toast.LENGTH_SHORT).show();
                            }
                        } catch (JSONException e) {
                            // If an exception occurs while parsing JSON, log the error and display a toast
                            e.printStackTrace();
                            Toast.makeText(getActivity(), "Error parsing JSON", Toast.LENGTH_SHORT).show();
                        }
                    }

                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        progressDialog.dismiss();
                        // Handle error cases
                        Toast.makeText(getActivity(), "Error: " + error.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }
        ) {
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<>();
                // Add parameters to the request
                params.put("vehicle_Type", vehicleType); // Replace "" with the actual Vehicle Type
                // Add other parameters as needed
                return params;
            }
        };

        // Add the request to the request queue
        RequestHandler.getInstance(getActivity()).addToRequestQueue(stringRequest);
    }