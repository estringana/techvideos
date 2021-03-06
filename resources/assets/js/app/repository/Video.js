export default class VideoRepository {
    constructor(httpClient) {
        this.httpClient = httpClient;
    }

    latest() {
        return this.httpClient.get('/api/videos/latest');
    }

    get(videoId) {
        return this.httpClient.get('/api/videos/' + videoId);
    }

    labels(videoId) {
        return this.httpClient.get('/api/videos/' + videoId + '/labels');
    }

    vote(videoId, vote) {
        return this.httpClient.post('/api/votes/video/' + videoId, {
            vote
        });
    }
}