require('axios');

export default class Video {
    latest() {
        return axios.get('/api/videos/latest');
    }
}