<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form">
        @csrf
        <h3 class="tile-title">General Settings</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="site_name">Site Name </label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter site name"
                    id="site_name"
                    name="site_name"
                    value="{{ Setting::get('site_name') }}"
                />
                <!-- value="{{ config('settings.site_name') }}" -->
            </div>
            <div class="form-group">
                <label class="control-label" for="site_title">Site Title</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter site title"
                    id="site_title"
                    name="site_title"
                    value="{{ Setting::get('site_title') }}"
                />
                <!-- value="{{ config('settings.site_title') }}" -->

            </div>
            <div class="form-group">
                <label class="control-label" for="default_email_address">Default Email Address</label>
                <input
                    class="form-control"
                    type="email"
                    placeholder="Enter store default email address"
                    id="default_email_address"
                    name="default_email_address"
                    value="{{ Setting::get('default_email_address') }}"
                    />
                    <!-- value="{{ config('settings.default_email_address') }}" -->
                </div>
            <div class="form-group">
                <input type="hidden" id="db_country_code" value="{{ Setting::get('currency_code') }}">
                <label class="control-label" for="currency_code">Country Code</label>
                <select class="form-control" id="currency_code" name="currency_code" onchange="filterCurrencySymbol(event)"/>
                    <option value="" {{ Setting::get('currency_code') == ""  ? 'selected' : ''}} disabled>Select Country Code</option>
                </select>
                    <!-- value="{{ Setting::get('currency_code') }}" -->
                    <!-- value="{{ config('settings.currency_code') }}" -->
            </div>
            <div class="form-group">
                <label class="control-label" for="currency_symbol">Currency Symbol</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Please select the country code."
                    id="currency_symbol"
                    name="currency_symbol"
                    value="{{ Setting::get('currency_symbol') }}"
                    readonly
                    />
                    <!-- value="{{ config('settings.currency_symbol') }}" -->
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
