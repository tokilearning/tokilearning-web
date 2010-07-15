<?php if ((!IPChecker::isInITB()) && (!IPChecker::isLocal())): ?>
    <div class="widget">
        <script src="http://widgets.twimg.com/j/2/widget.js"></script>
        <script>
            new TWTR.Widget({
                version: 2,
                type: 'profile',
                rpp: 5,
                interval: 6000,
                width: 200,
                height: 200,
                theme: {
                    shell: {
                        background: '#313428',
                        color: '#ffffff'
                    },
                    tweets: {
                        background: '#f9f9f9',
                        color: '#5a5a5a',
                        links: '#000000'
                    }
                },
                features: {
                    scrollbar: true,
                    loop: false,
                    live: false,
                    hashtags: true,
                    timestamp: true,
                    avatars: true,
                    behavior: 'all'
                }
            }).render().setUser('tokilearning').start();
        </script>
    </div>
<?php endif; ?>