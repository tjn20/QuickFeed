import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

 import Echo from 'laravel-echo';

 import Pusher from 'pusher-js';
 window.Pusher = Pusher;

 window.Echo = new Echo({
     broadcaster: 'pusher',
     key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
     enabledTransports: ['ws', 'wss'],
 });



 const messagesNotification=document.getElementById('messagesNotifications');

 if(messagesNotification)
 {
    window.Echo.private(`chat.${window.user}`)
    .listen('MessageSent', (event) => {
        const toast = bootstrap.Toast.getOrCreateInstance(document.getElementById('liveToast'))
        if(window.location.pathname.indexOf('chat')<0){
            window.dispatchEvent(new CustomEvent('refresh'));
        if(toast)
        {
            toast._element.querySelector('.toast-body').textContent="Someone Messaged You";
            toast.show();
        }
            messagesNotification.textContent++;

    }
   

    });

   
 }
