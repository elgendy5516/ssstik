<section class="about-section" aria-label="About Section">
    <div class="container">
        <x-theme::ad.about-section-ad />

        <p>@lang(":appName is one of the most popular tools to save no-watermark TikTok videos. No need to install any apps to use our service, all you need is a browser and a valid link to paste in the input field on :appName website and remove the watermark from TikTok video.", ['appName'=> config('app.name')])</p>

        <div class="service-cards">
            <div class="service-card">
                <div class="icon">
                    <x-theme::icon.mini.paper-clip/>
                </div>
                <p>@lang("It's a perfect solution for post-editing and publishing videos.")</p>
            </div>
            <div class="service-card">
                <div class="icon">
                    <x-theme::icon.mini.tag/>
                </div>
                <p>@lang("It is free. You can save as many mp4 files as you want.")</p>
            </div>
            <div class="service-card">
                <div class="icon">
                    <x-theme::icon.mini.user/>
                </div>
                <p>@lang("Registration is not required. Just open our website and paste the link.")</p>
            </div>

            <div class="service-card">
                <div class="icon">
                    <x-theme::icon.mini.bolt/>
                </div>
                <p>@lang("Download TikTok videos without watermark at high speed.")</p>
            </div>
            <div class="service-card">
                <div class="icon">
                    <x-theme::icon.mini.music/>
                </div>
                <p>@lang("Save TikTok without watermark in mp4 or mp3 online.")</p>
            </div>
            <div class="service-card">
                <div class="icon">
                    <x-theme::icon.mini.computer-desktop/>
                </div>
                <p>@lang("TikTok download works in every browser and operating system.")</p>
            </div>
        </div>
    </div>
</section>
