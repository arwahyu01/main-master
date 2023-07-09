{!! Form::open(['id'=>'form-create-'.$page->code, 'route' => [$page->url.'.update', $data->id], 'class' => 'form form-horizontal', 'method' => 'put', 'files' => TRUE]) !!}
<div class="panel shadow-sm">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6 form-group">
                {!! Form::label('first_name', 'First Name', array('class' => 'control-label')) !!}
                <span class="text-danger">*</span>
                {!! Form::text('first_name',$data->first_name,['class'=>'form-control','id'=>'first_name','placeholder'=>'First Name']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::label('last_name', 'Last Name', array('class' => 'control-label')) !!}
                <span class="text-danger">*</span>
                {!! Form::text('last_name',$data->last_name,['class'=>'form-control','id'=>'last_name','placeholder'=>'Last Name']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('email', 'Email', array('class' => 'control-label')) !!}
            <span class="text-danger">*</span>
            {!! Form::text('email',$data->email,['class'=>'form-control','id'=>'email','placeholder'=>'Email','disabled'=>'disabled']) !!}
        </div>
        @if($data->id == $user->id)
            <div class="form-group row">
                <div class="col-md-6">
                    {!! Form::label('password', 'Password Baru', array('class' => 'control-label')) !!}
                    {!! Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>'Password']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('password_confirmation', 'Password Confirmation', array('class' => 'control-label')) !!}
                    {!! Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','placeholder'=>'Password Confirmation']) !!}
                </div>
            </div>
        @endif
        @if(in_array($user->level->code,['root','admin']))
            <div class="form-group row">
                <div class="col-md-6">
                    {!! Form::label('level_id', 'Level', array('class' => 'form-label')) !!}
                    <span class="text-danger">*</span>
                    {!! Form::select('level_id',$level, $data->level_id, ['class' => 'form-control select2', 'id' => 'level_id']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('access_group_id', 'Access Group', array('class' => 'form-label')) !!}
                    <span class="text-danger">*</span>
                    {!! Form::select('access_group_id',$access_group, $data->access_group_id, ['class' => 'form-control select2', 'id' => 'access_group_id']) !!}
                </div>
            </div>
        @endif
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
{!! Form::hidden('table-id','datatable',['id'=>'table-id']) !!}
{!! Form::close() !!}
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
    $('.modal-title').html('<i class="fa fa-edit"></i> Edit Data {!! $page->title !!}');
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
