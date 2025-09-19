// import EventDetails from '@/views/EventDetails.vue';
import api from './api';

const EventService = {

  // Get all users
  getAllEvents() {
    return api.get('/events');
  },
getAllTypes() {
    return api.get('/event-types');
  },
    // Get event by ID
    getEventById(id) {
      return api.get(`/events/${id}`);
    },
    // Create new event
    createEvent(eventData) {
        return api.post('/events', eventData,
            {headers: { 'Content-Type': 'multipart/form-data' }}

        );
    },
    // Update event
    updateEvent(id, formData) {
    return  api.post(
  `/events/${id}`,
  formData,
  {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
    params: {
      _method: 'PUT' // Laravel uses this to override POST to PUT
    }
  }
);
    },
    // Delete event
    delete(id) {    
        return api.delete(`/events/${id}`);
    },

    EventDetails(id){
      return api.get(`/eventDetials/${id}`);
    }

};

export default EventService;
