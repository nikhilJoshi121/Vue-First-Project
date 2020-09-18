import { http, httpFile } from './http_service';

//post data
export function createCategory(data) {
    return httpFile().post('/add-category', data);
}
//Get data
export function getCategory() {
    return http().get('/add-category');
}
//delete data
export function deleteCategory(id) {
    return http().delete('/add-category/' + id);
}
//update Data
export function updateCategory(id, data) {
    return httpFile().post(`/add-category/${id}`, data);
}

export function loadPagination(page) {
    return http().get(`/add-category?page=${page}`);
}