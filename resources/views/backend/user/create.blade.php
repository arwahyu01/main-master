{{ html()->form('POST', route($page->url.'.store'))->id('form-create-'.$page->code)->acceptsFiles()->class('form form-horizontal')->open() }}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6 form-group">
                {!! html()->label('First Name','first_name')->class('control-label') !!}
                <span class="text-danger">*</span>
                {!! html()->text('first_name')->placeholder('Type first name here')->class('form-control')->id('first_name')->required() !!}
            </div>
            <div class="col-md-6 form-group">
                {!! html()->label('Last Name','last_name')->class('control-label') !!}
                <span class="text-danger">*</span>
                {!! html()->text('last_name')->placeholder('Type last name here')->class('form-control')->id('last_name')->required() !!}
            </div>
        </div>
        <div class="form-group">
            {!! html()->label('Email','email')->class('control-label') !!}
            <span class="text-danger">*</span>
            {!! html()->text('email')->placeholder('Type email here')->class('form-control')->id('email')->required() !!}
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                {!! html()->label('Password','password')->class('control-label') !!}
                <span class="text-danger">*</span>
                {!! html()->password('password')->placeholder('Type password here')->class('form-control')->id('password')->required() !!}
            </div>
            <div class="col-md-6">
                {!! html()->label('Password Confirmation','password_confirmation')->class('control-label') !!}
                <span class="text-danger">*</span>
                {!! html()->password('password_confirmation')->placeholder('Type password confirmation here')->class('form-control')->id('password_confirmation')->required() !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                {!! html()->label('Level','level_id')->class('control-label') !!}
                <span class="text-danger">*</span>
                {!! html()->select('level_id',$level)->class('form-control select2')->id('level_id')->required() !!}
            </div>
            <div class="col-md-6">
                {!! html()->label('Access Group','access_group_id')->class('control-label') !!}
                <span class="text-danger">*</span>
                {!! html()->select('access_group_id',$access_group)->class('form-control select2')->id('access_group_id')->required() !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <span class="message"></span>
        <div class="progress" style="display: none;">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                <div id="statustxt">0%</div>
            </div>
        </div>
    </div>
</div>
{!! html()->hidden('table-id','datatable')->id('table-id') !!}
{!! html()->form()->close() !!}
<style>
    .select2-container {
        z-index: 9999 !important;
        width: 100% !important;
    }

    .modal-lg {
        max-width: 1000px !important;
    }
</style>
<script>
    $('.modal-title').html('<i class="mdi mdi-bookmark-plus"></i> Tambah Data {!! $page->title !!}');
    $('.select2').select2();
    $('#password_confirmation').on('keyup', function () {
        let password = $('#password');
        let password_confirmation = $('#password_confirmation');
        if (password.val() === password_confirmation.val()) {
            password_confirmation.css('border-color', 'green');
            password.css('border-color', 'green');
        } else {
            password_confirmation.css('border-color', 'red');
            password.css('border-color', 'red');
        }
    });
</script>
