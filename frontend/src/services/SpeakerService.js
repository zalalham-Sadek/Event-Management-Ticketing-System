import api from './api';

const SpeakerService = {

  // Get all users
  getAllSpeakers() {
    return api.get('/api/speakers');
  },
    // Get speaker by ID
    getSpeakerById(id) {
      return api.get(`/api/speakers/${id}`);
    },
    // Create new speaker
    createSpeaker(speakerData) {
        return api.post('/api/speakers/create', speakerData);
    },

    // Delete speaker
    delete(id) {    
        return api.delete(`/api/speakers/${id}`);
    }
};
export default SpeakerService;
