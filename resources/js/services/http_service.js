import axios from 'axios'; // for API
import store from '../store';
import * as auth from '../services/auth_services';

export function http() { //get
    return axios.create({
        baseURL: store.state.apiURL,
        headers: {
            Authorization: 'Bearer' + auth.getAccessToken(), // bearer token set in header
        }
    });
}

export function httpFile() { //Post
    return axios.create({
        baseURL: store.state.apiURL,
        headers: {
            'content-type': 'multipart/form-data',
            Authorization: 'Bearer' + auth.getAccessToken(),
        }
    });
}