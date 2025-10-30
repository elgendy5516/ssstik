<section class="faq-section" aria-label="FAQ Section">
    <div class="container">
        <x-theme::ad.faq-section-ad />
        {{$header ?? null}}
        <x-theme::accordion :title="__('Do I have to pay to download TikTok video?')">
            <p>@lang("No, you don't have to pay for anything, because our service is always free! We support all modern browsers such as Google Chrome, Mozilla Firefox, Safari, Microsoft Edge etc.")</p>
        </x-theme::accordion>
        <x-theme::accordion :title="__('Do I need to install extensions to use TikTok downloader?')">
            <p>@lang("No. To save and remove the watermark from TikTok online, you just need a link. Paste it into the input field and select the appropriate format for conversion. Our TikTok watermark remover will do the rest.")</p>
        </x-theme::accordion>
        <x-theme::accordion :title="__('Where are TikTok videos saved after downloading?')">
            <p>@lang("When you save from TikTok without trademark, files are usually saved to your default location. In your browser settings, you can change and manually select the destination folder for your downloaded TikTok videos.")</p>
        </x-theme::accordion>
        <x-theme::accordion :title="__('Do I need to have a TikTok account to download TikTok videos?')">
            <p>@lang("No, you do not need to have a TikTok account. You can launch TikTok video download when you have a link to it, just paste it into the input field at the top of the page and click Download. Our TikTok download service will remove the watermark from TikTok and the video will be ready to use in a few seconds.")</p>
        </x-theme::accordion>
        <x-theme::accordion :title="__('Can your TikTok downloader save videos from personal accounts?')">
            <p>@lang("Our TikTok video saver cannot access the content of private accounts and cannot save videos from there. You must make sure the account is public in order for us to save videos for you.")</p>
        </x-theme::accordion>
        <x-theme::accordion :title="__('How to get link for TikTok videos?')">
            <p>@lang("Open the TikTok app and Choose the video you want to save. Click \"Share\" and then \"Copy Link\". Your TikTok video download without watermark URL is ready on your clipboard.")</p>
        </x-theme::accordion>
    </div>
</section>
