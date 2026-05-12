(function () {
    const TRACKING_URL = window.TRACKING_URL;
    if (!TRACKING_URL) return;

    fetch(TRACKING_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            url: window.location.href,
            referrer: document.referrer || null,
        }),
        keepalive: true,
    }).catch(function () {});
}());
