import axios from 'axios';

const API_BASE_URL = '/api';  // adjust if needed

export default {
  // Generic GET with optional query params object
  get(url, params = {}) {
    const queryString = new URLSearchParams(params).toString();
    const fullUrl = queryString ? `${API_BASE_URL}${url}?${queryString}` : `${API_BASE_URL}${url}`;
    return axios.get(fullUrl);
  },

  getTorrents(params = {}) {
    return this.get('/torrents', params);
  },

  getTorrent(id) {
    return axios.get(`${API_BASE_URL}/torrents/${id}`);
  },

  createTorrent(data) {
    return axios.post(`${API_BASE_URL}/torrents`, data);
  },

  // Add more API calls here as needed, for example:
  updateTorrent(id, data) {
    return axios.put(`${API_BASE_URL}/torrents/${id}`, data);
  },

  // ✅ Delete torrent using POST with ID in body
  deleteTorrent(id) {
    return axios.post(`${API_BASE_URL}/torrents/delete`, { id });
  },
};
