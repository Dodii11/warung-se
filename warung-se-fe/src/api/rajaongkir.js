import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api";

function getAuthHeader() {
  const token = localStorage.getItem("token");

  
 

  return {
    Accept: "application/json",
    ...(token && { Authorization: `Bearer ${token}` }),
  };
}

// =====================
// PROVINCE
// =====================
export function fetchProvinces() {
  return axios.get(`${API_URL}/rajaongkir/provinces`, {
    headers: getAuthHeader(),
  });
}

// =====================
// CITY (BY PROVINCE)
// =====================
export function fetchCities(provinceId) {
  return axios.get(`${API_URL}/rajaongkir/cities/${provinceId}`, {
    headers: getAuthHeader(),
  });
}

// =====================
// DISTRICT (BY CITY)
// =====================
export function fetchDistricts(cityId) {
  return axios.get(`${API_URL}/rajaongkir/districts/${cityId}`, {
    headers: getAuthHeader(),
  });
}
