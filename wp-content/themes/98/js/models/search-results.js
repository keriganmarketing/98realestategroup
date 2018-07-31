export default class SearchResults {
    constructor (data) {
        for (let field in data) {
            this[field] = data[field];
        }
    }
}