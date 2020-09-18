import { http, httpFile } from './http_service';
import jwt from 'jsonwebtoken';


export function register(user) {
    return http().post('/register', user);
}

export function login(user) {
    return http().post('/login', user).then(response => {
        if (response.data.status_code === 200) { //is success login
            setToken(response.data.token); // call function
        }
        return response.data;
    });

}

function setToken(user) { // token storage
    var token = jwt.sign({ user: user }, 'ilovemyIndiayemeraindia');
    localStorage.setItem('laravel-login-token', JSON.stringify(token));
}

export function isLoggedIn() { // if login in then get token from application storge
    const token = localStorage.getItem('laravel-login-token');
    return token != null;
}


export function logout() {
    http().get('/logout');
    localStorage.removeItem('laravel-login-token');
}

export function getAccessToken() { // every time get token this event time

    const token = localStorage.getItem('laravel-login-token');
    if (!token) {
        return null;
    }
    const tokenData = jwt.decode(token); // toke can be null by jwt.decode

    return tokenData;
}