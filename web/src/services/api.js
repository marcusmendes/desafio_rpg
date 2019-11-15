import axios from 'axios';

console.tron.debug(process);

const api = axios.create({
  baseURL: 'http://localhost:8000/',
});

export default api;
