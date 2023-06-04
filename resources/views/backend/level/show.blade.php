<div class="panel shadow-sm">
    <div class="panel-body">
        <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" value="{{ $data->name }}" readonly>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Code</label>
					<input type="text" class="form-control" value="{{ $data->code }}" readonly>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label>Access</label>
					<div class="row">
                        @foreach(collect(config('master.app.level')) as $key => $level)
                            <div class="col-auto">
                                <input type="checkbox" name="access[]" id="md_checkbox_{{$key}}" value="{{ $level }}" class="filled-in chk-col-primary" {{ in_array($level, ($data->access ?? [])) ? (($data->access[$level] ?? false) ? 'checked' : '') : '' }} disabled>
                                <label for="md_checkbox_{{$key}}" class="text-uppercase">{{ $level }}</label>
                            </div>
                        @endforeach
                    </div>
				</div>
			</div>
		</div>
    </div>
</div>
<style>
    .modal-lg {
        max-width: 1000px !important;
    }
</style>
<script>
    $('.submit-data').hide();
</script>
