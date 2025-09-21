// src/plugins/echo.js
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const echo = new Echo({
  broadcaster: 'pusher',
  key: "f8e9b1ac7c6883c370ac",
  cluster: "us2",
  forceTLS: true,
});

export default echo;
