const dnCB = document.querySelector("[data-diginaut-cb]");
if (dnCB) {
    dnCB.querySelectorAll("[data-diginaut-cb-button]").forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            // 30 days
            const dnOptions = dnCB.querySelectorAll('[data-diginaut-cb-option]');
            // Set preferences based on button
            if (e.currentTarget.dataset.diginautCbAccept !== undefined) dnOptions.forEach((opt) => {
                opt.checked = true;
            });
            if (e.currentTarget.dataset.diginautCbReject !== undefined) dnOptions.forEach((opt) => {
                if (!opt.required) opt.checked = false;
            });

            // Collect preferences
            let dnPreferences = [];
            dnCB.querySelectorAll('[data-diginaut-cb-option]').forEach((opt) => {
                dnPreferences += opt.value + ':' + + opt.checked + ',';
            });
            dnPreferences = dnPreferences.slice(0, -1);

            // Set cookie
            const currentDateTme = new Date().toUTCString();
            document.cookie = `dncb-cookie-datetime=${currentDateTme}; path=/; max-age=${60 * 60 * 24 * 30};`;
            document.cookie = `dncb-cookie-preferences=${dnPreferences}; path=/; max-age=${60 * 60 * 24 * 30};`;
            if (window.dataLayer) window.dataLayer.push({ event: "cookie_refresh" });

            // Hide banner
            dnCB.classList.remove("cb-visible");
            dnCB.classList.remove("cb-preferences");
        });
    });

    // Show banner initially
    const dnHasCookie = (cN) => { let v = `; ${document.cookie}`; let pts = v.split(`; ${cN}=`); if (pts.length === 2) return pts.pop().split(';').shift(); };
    let dnCookie = dnHasCookie("dncb-cookie-preferences");
    if (dnCookie === undefined) {
        dnCB.classList.add("cb-visible");
    };

    // Show preferences
    const dnCollapse = dnCB.querySelector('[data-diginaut-cb-collapse]');
    const dnTypes=  dnCB.querySelector('[data-diginaut-cb-types]');
    if (dnCollapse && dnTypes) dnCollapse.addEventListener('click', (e) => {
        e.preventDefault();
        dnCB.classList.toggle('cb-preferences');
    });

    const dnCP = document.querySelector('[data-diginaut-cb-preferences]');
    if (dnCP && dnCookie !== undefined) dnCP.addEventListener('click', (e) => {
        e.preventDefault();

        // Load up preferences
        let dnCookie = dnHasCookie("dncb-cookie-preferences");
        dnCookie.split(',').forEach(pref => {
            let preference = pref.split(':');
            let option = document.querySelector('input[data-diginaut-cb-option][value="'+preference[0]+'"]');
            if (preference[1]==='1') option.checked = true;
            else option.checked = false;
        });

        // Show
        dnCB.classList.add("cb-visible");
        dnCB.classList.toggle('cb-preferences');
    });
}
