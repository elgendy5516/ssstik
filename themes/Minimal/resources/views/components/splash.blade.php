<section class="splash" aria-label="Download TikTok Video Section" x-data="SplashComponent()"
         @search-video.window="searchVideo($event)">
    <div class="container">
        <div class="splash-form" x-show="!tiktokVideo">
            <h1>@lang('Download TikTok Video')</h1>
            <form @submit.prevent="submitForm()" x-ref="form" method="POST" action="{{route('fetch')}}">
                <div class="splash-search pi">
                    @csrf
                    <input x-model="url" name="url" type="url" placeholder="@lang('Just insert a link')"
                           aria-label="@lang('Search Tiktok Video')" class="splash-search-input pi-end" required>
                    <button type="button" @click.prevent="pasteText()" x-show="canPaste"
                            class="splash-paste-button mi-end" aria-label="@lang("Paste")">
                        <x-theme::icon.clipboard class="icon mi-end" aria-hidden="true"/>
                        <span aria-hidden="true">@lang("Paste")</span>
                    </button>
                    <button :disabled="processing" type="submit" class="splash-search-button">
                        <span x-show="!processing">@lang('Download')</span>
                        <x-theme::icon.loading x-show="processing" class="icon" x-cloak="true"/>
                    </button>
                </div>
            </form>
        </div>
        <x-theme::ad.hero-section-ad/>
        <template x-if="tiktokVideo">
            <div class="splash-video-wrapper">
                <div
                    class="splash-video"
                >
                    <img class="splash-video-bg" x-show="!imageFailed" alt="Splash Bg" :src="decodeURIComponent(tiktokVideo?.coverURL ?? '')" role="presentation" @@error="onImageFail()" crossorigin="anonymous">
                    <img :src="tiktokVideo?.author.avatar" :alt="tiktokVideo?.author.username"/>
                    <h2 x-text="tiktokVideo?.author.username"></h2>
                    <p x-text="tiktokVideo?.caption"></p>
                    <a x-show="tiktokVideo?.watermark?.url" :href="tiktokVideo?.watermark?.url" target="_blank"
                       referrerpolicy="no-referrer" data-extension="mp4" :data-size="tiktokVideo?.watermark?.size"
                       @click.prevent="downloadVideo($event)">@lang('Original Video with Watermark')</a>

                    <template x-for="dld in tiktokVideo?.downloadUrls" :key="dld.idx">
                        <a :href="dld.url" target="_blank" referrerpolicy="no-referrer" :data-size="dld.size"
                           data-extension="mp4" @click.prevent="downloadVideo($event)">
                            <span x-text="downloadText(dld) + downloadSize(dld)"></span>
                        </a>
                    </template>

                    <a x-show="tiktokVideo?.mp3URL" :href="tiktokVideo?.mp3URL" target="_blank"
                       referrerpolicy="no-referrer" data-extension="mp3"
                       @click.prevent="downloadVideo($event)">@lang('Download MP3 Audio')</a>
                </div>
                <button class="reset-video" @click="resetVideo()">@lang('Download another video')</button>
            </div>
        </template>
    </div>
</section>

@pushonce('scripts')
    <script>
        function SplashComponent() {
            return {
                /**
                 * @var {Record<string, any|Record<string,any>|Record<string,any>[]>}
                 */
                tiktokVideo: null,
                url: "",
                processing: false,
                imageFailed: false,
                onImageFail() {
                    this.imageFailed = true;
                },
                submitForm() {

                    if (!validateURL(this.url)) {
                        return window.toasted.show("@lang('Please enter a valid URL')", {
                            type: "error"
                        });
                    }

                    this.processing = true;
                    const instance = this;
                    const formData = new FormData(this.$refs.form);

                    fetch(this.$refs.form.action, {
                        method: this.$refs.form.method,
                        body: formData,
                        headers: {
                            "accept": "application/json"
                        }
                    })
                        .then(function (response) {
                            if (response.status !== 200 || !response.headers.get('content-type').includes('json')) {
                                throw new window.RequestError(response);
                            }
                            return response.json();
                        })
                        .then(function (data) {
                            instance.imageFailed = false;
                            instance.tiktokVideo = data;
                        })
                        .catch(function (error) {
                            window.handleErrors(error);
                        })
                        .finally(function () {
                            instance.processing = false;
                        });
                },
                //Paste logic
                get canPaste() {
                    return window.navigator.clipboard;
                },
                pasteText() {
                    if (this.canPaste) {
                        const instance = this;
                        window.navigator.clipboard.readText().then(function (text) {
                            instance.url = text;
                        });
                    }
                },
                downloadText(download) {
                    return (download.isHD ? "@lang('Without Watermark [:idx] HD')" : "@lang('Without Watermark [:idx]')").replace(":idx", download.idx + 1);
                },
                downloadSize(download) {
                    if (!download.size) return ''
                    return ' ' + bytesToSize(download.size);
                },

                searchVideo(event) {
                    const instance = this;
                    this.resetVideo(event.detail).then(function () {
                        instance.submitForm();
                        window.scrollTo({top: 0});
                    });
                },
                resetVideo(url = "") {
                    this.url = url;

                    this.tiktokVideo = null;
                    return this.$nextTick();
                },
                downloadVideo(e) {
                    let anchorEl = e.target;
                    if (anchorEl.tagName.toLowerCase() !== 'a') {
                        anchorEl = anchorEl.closest('a');
                    }

                    if (!anchorEl || !anchorEl.href) return;

                    const url = new URL('/download', '{{config('app.url')}}');
                    const extension = anchorEl.dataset.extension ?? 'mp4';
                    const size = anchorEl.dataset.size;

                    url.searchParams.set('url', btoa(anchorEl.href));
                    url.searchParams.set('extension', extension);
                    if (typeof size === 'string' && size.trim() !== '')
                        url.searchParams.set('size', size);

                    open(url.toString(), "_blank");
                }
            };
        }

        function bytesToSize(bytes) {
            const units = ["byte", "kilobyte", "megabyte", "terabyte", "petabyte"];
            const unit = Math.floor(Math.log(bytes) / Math.log(1024));
            return new Intl.NumberFormat("en", {
                style: "unit",
                unit: units[unit],
                unitDisplay: 'narrow',
                notation: 'compact'
            }).format(bytes / 1024 ** unit);
        }

        function validateURL(url) {
            return /^(https?:\/\/)?(www\.)?vm\.tiktok\.com\/[^\n]+\/?$/.test(url)
                || /^(https?:\/\/)?(www\.)?m\.tiktok\.com\/v\/[^\n]+\.html([^\n]+)?$/.test(url)
                || /^(https?:\/\/)?(www\.)?tiktok\.com\/t\/[^\n]+\/?$/.test(url)
                || /^(https?:\/\/)?(www\.)?tiktok\.com\/@[^\n]+\/video\/[^\n]+$/.test(url)
                || /^(https?:\/\/)?(www\.)?vt\.tiktok\.com\/[^\n]+\/?$/.test(url)
        }
    </script>
@endpushonce
