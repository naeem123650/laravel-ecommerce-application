<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form">
        @csrf
        <h3 class="tile-title">Footer &amp; SEO</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="footer_copyright_text">Footer Copyright Text</label>
                <textarea
                    class="form-control"
                    rows="4"
                    placeholder="Enter footer copyright text"
                    id="footer_copyright_text"
                    name="footer_copyright_text"
                >{{ Setting::get('footer_copyright_text') }}</textarea>
                <!-- {{ config('settings.footer_copyright_text') }} -->
            </div>
            <div class="form-group">
                <label class="control-label" for="seo_meta_title">SEO Meta Title</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter seo meta title for store"
                    id="seo_meta_title"
                    name="seo_meta_title"
                    value="{{ Setting::get('footer_copyright_text') }}"
                    />
                </div>
                <!-- value="{{ config('settings.seo_meta_title') }}" -->
            <div class="form-group">
                <label class="control-label" for="seo_meta_description">SEO Meta Description</label>
                <textarea
                    class="form-control"
                    rows="4"
                    placeholder="Enter seo meta description for store"
                    id="seo_meta_description"
                    name="seo_meta_description"
                >{{ Setting::get('seo_meta_description') }}</textarea>
                <!-- {{ config('settings.seo_meta_description') }} -->
            </div>
        </div>
        <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Settings</button>
                </div>
            </div>
        </div>
    </form>
</div>