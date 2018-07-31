export default class Pagination {
    constructor(data) {
        for (let field in data) {
            this[field] = data[field];
        }
    }
}