'use strict';

window.Fsociety = (() => {
    // Establish Socket.io connection
    const socket = io.connect('https://bot.fsociety.guru');
    // Announcements
    socket.on('announce', data => {
        if(!data) return;
        UIkit.notify({
            message : `<div class="uk-text-center"><h4>Announcement From ${data.from}</h4><p>${data.text}</p></div>`,
            status  : 'info',
            timeout : 7500,
            pos     : 'bottom-right'
        });
    });

    // Tweets
    socket.on('tweets', data => {
        if (!data) return;
        UIkit.notify({
            message : `[Twitter] @${data.tweet.user.screen_name}: ${data.tweet.text}` ,
            status  : 'success',
            timeout : 7500,
            pos     : 'bottom-left'
        });
    });

    // Expose
    return {
        socket
    };
})();