export default class LabelRepository {
    constructor(httpClient) {
        this.httpClient = httpClient;
    }

    all() {
        return this.httpClient.get('/api/labels');
    }
}