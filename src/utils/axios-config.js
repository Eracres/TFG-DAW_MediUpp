import axios from 'axios';

// Crear instancia de Axios con configuración global
const axiosInstance = axios.create({
    baseURL: 'http://localhost/tfg-daw_mediupp/src/config/', 
    headers: {
        'Content-Type': 'application/json',
    },
    timeout: 5000,
});

export default axiosInstance;