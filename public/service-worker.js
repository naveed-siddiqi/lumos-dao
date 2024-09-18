//Registeration and activation
self.addEventListener('install',function(event){
    //force controll
   event.waitUntil(self.skipWaiting())
})
self.addEventListener('activate',function(event){
    event.waitUntil(self.clients.claim())
})
/* Listen to Push Notifications */
self.addEventListener("push", (e) => {
  const data = e.data.json().msg;
  self.registration.showNotification(data.title, {
    logo:data.logo,
    body: data.msg,
    image:data.image,
    data:{
        url:data.url
    }
  });
});
//listen to notification click
self.addEventListener('notificationclick', function(event) {
    const notification = event.notification
    notification.close(); // Close the notification
    event.waitUntil(
        clients.matchAll({ type: 'window' }).then(function(clientList) {
            // Check if there's already a tab open with this URL
            for (let i = 0; i < clientList.length; i++) {
                let client = clientList[i];
                if (client.url === notification.data.url && 'focus' in client) {
                    return client.focus();
                }
            }
            // If not, open a new tab
            if (clients.openWindow) {
                return clients.openWindow(notification.data.url);
            }
        })
    );
});