var endpoint;
var key;
var authSecret;
var vapidPublicKey ='BCR5FgUBzGlLjmsC9AjTOLYLtzW1AEUSVJdHG_p--IygEIR6uoh40LRaEj-OusVqZVMjgyhmEVKh0QGyCpBEJvs';
document.getElementsByTagName('p').innerHTML="then";
function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}
if(location.protocol != 'https:')
{
    location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
}
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js',{scope: '/'}).then(function(registration) {
        var serviceWorker;
        if (registration.installing) {
            serviceWorker = registration.installing;
            // console.log('Service worker installing');
        } else if (registration.waiting) {
            serviceWorker = registration.waiting;
             // console.log('Service worker installed & waiting');
        } else if (registration.active) {
            serviceWorker = registration.active;
            // console.log('Service worker active');
        }
        if (serviceWorker) {
            console.log("sw current state", serviceWorker.state);
            if (serviceWorker.state == "activated") {
                //If push subscription wasnt done yet have to do here
                console.log("sw already activated - Do watever needed here");
            }
            serviceWorker.addEventListener("statechange", function(e) {
                console.log("sw statechange : ", e.target.state);
                if (e.target.state == "activated") {
                    // use pushManger for subscribing here.
                    console.log("Just now activated. now we can subscribe for push notification")
                    subscribeForPushNotification(registration);
                }
            });
        }
    }).catch(function(err) {
        // registration failed :(
        console.log('ServiceWorker registration failed: ', err);
    });
}
function subscribeForPushNotification(registration) {
    return registration.pushManager.getSubscription()
        .then(function(subscription) {
            return registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
            }).then(function(subscription) {
                displayNotification();
                console.log('Endpoint URL: ', subscription.endpoint);
            }).catch(function(e) {
                if (Notification.permission === 'denied') {
                    console.warn('Permission for notifications was denied');
                } else {
                    console.error('Unable to subscribe to push', e);
                }
            });

                });
}

Notification.requestPermission(function(status) {
    console.log('Notification permission status:', status);
});

window.addEventListener('beforeinstallprompt', e => {
  // beforeinstallprompt Event fired
    console.log(e,'propt');
    // e.userChoice will return a Promise.
    e.userChoice.then(choiceResult => {
    ga('send', 'event', 'install', choiceResult.outcome);
  });
});

function displayNotification() {
  if (Notification.permission == 'granted') {
    navigator.serviceWorker.getRegistration().then(function(reg) {
      var options = {
        title: 'Thanks For Subscribing!',
        body: 'Welcome to Notification Subscription!',
        icon: '/pwa/img/192.png',
        vibrate: [100, 50, 100],
        data: {
          dateOfArrival: Date.now(),
          primaryKey: 1
        },
      };
      reg.showNotification('Thanks For Subscription!', options);
    });
  }
 else if (Notification.permission === "blocked") {
     console.log('blocked');
    /* the user has previously denied push. Can't reprompt. */
} else {
     console.log('else')
    /* show a prompt to the user */
}
}
