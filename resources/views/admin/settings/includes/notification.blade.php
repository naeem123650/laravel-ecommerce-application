<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form">
        @csrf
        <h3 class="tile-title">Bootstrap Notification Style Settings</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="notification_style">Notification Style</label>
                <select name="notification_style" id="notification_style" class="form-control">
                    <option value="1" {{ Setting::get('notification_style') == 1 || Setting::get('notification_style') == null ? 'selected' : '' }}>Bootstrap Alert</option>
                    <!-- <option value="0" {{ Setting::get('notification_style') == 0  ? 'selected' : ''  }}>Bootstrap Sweat Alert</option> -->
                </select>
            </div>
        </div>
        <!-- <h4>Demo</h4><a class="btn btn-info" id="demoSwal" href="#">Sample Alert</a> -->
        <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Settings</button>
                </div>
            </div>
        </div>
    </form>
</div>


