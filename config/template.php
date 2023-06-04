<?php

/**
 * Created by @arwahyupradana
 * path: config\template.php
 * description: this file is used for creating template for generating code in php artisan make:mvc
 * Please don't change this file if you don't understand what you do !!!
 */

$template = [
    'text' => "<div class='form-group'>\n" .
        "\t\t\t{!! Form::label('{{ field }}', '{{ title }}', array('class' => 'control-label')) !!}\n" .
        "\t\t\t{!! Form::text('{{ field }}',NULL,['class'=>'form-control','id'=>'{{ field }}','placeholder'=>'Ketik Disini']) !!}\n" .
        "\t\t</div>",
    'number' => "<div class='form-group'>\n" .
        "\t\t\t{!! Form::label('{{ field }}', '{{ title }}', array('class' => 'control-label')) !!}\n" .
        "\t\t\t{!! Form::number('{{ field }}',NULL,['class'=>'form-control','id'=>'{{ field }}']) !!}\n" .
        "\t\t</div>",
    'file'   => "<div class='form-group'>\n" .
        "\t\t\t{!! Form::label('{{ field }}', '{{ title }}', array('class' => 'control-label')) !!}\n" .
        "\t\t\t{!! Form::file('{{ field }}',NULL,['class'=>'form-control','id'=>'{{ field }}']) !!}\n" .
        "\t\t</div>",
    'textarea' => "<div class='form-group'>\n" .
        "\t\t\t{!! Form::label('{{ field }}', '{{ title }}', array('class' => 'control-label')) !!}\n" .
        "\t\t\t{!! Form::textarea('{{ field }}',NULL,['class'=>'form-control','id'=>'{{ field }}']) !!}\n" .
        "\t\t</div>",
    'select'   => "<div class='form-group'>\n" .
        "\t\t\t{!! Form::label('{{ field }}', '{{ title }}', array('class' => 'control-label')) !!}\n" .
        "\t\t\t{!! Form::select('{{ field }}',[],NULL,['class'=>'form-control','id'=>'{{ field }}','placeholder'=>'Pilih {{ title }}']) !!}\n" .
        "\t\t</div>",
    'select2' => "<div class='form-group'>\n" .
        "\t\t\t{!! Form::label('{{ field }}', '{{ title }}', array('class' => 'control-label')) !!}\n" .
        "\t\t\t{!! Form::select('{{ field }}',[],NULL,['class'=>'form-control select2','id'=>'{{ field }}','placeholder'=>'Pilih {{ title }}']) !!}\n" .
        "\t\t</div>",
    'checkbox' => "<div class='form-group'>\n" .
        "\t\t\t{!! Form::label('{{ field }}', '{{ title }}', array('class' => 'control-label')) !!}\n" .
        "\t\t\t{!! Form::checkbox('{{ field }}',NULL,['class'=>'form-control','id'=>'{{ field }}']) !!}\n" .
        "\t\t</div>",
    'date' => " <div class='form-group'>\n" .
        "\t\t\t{!! Form::label('{{ field }}', '{{ title }}', array('class' => 'control-label')) !!}\n" .
        "\t\t\t{!! Form::date('{{ field }}',NULL,['class'=>'form-control','id'=>'{{ field }}']) !!}\n" .
        "\t\t</div>",
    'dateTime' => " <div class='form-group'>\n" .
        "\t\t\t{!! Form::label('{{ field }}', '{{ title }}', array('class' => 'control-label')) !!}\n" .
        "\t\t\t{!! Form::dateTime('{{ field }}',NULL,['class'=>'form-control','id'=>'{{ field }}']) !!}\n" .
        "\t\t</div>",
    'time' => " <div class='form-group'>\n" .
        "\t\t\t{!! Form::label('{{ field }}', '{{ title }}', array('class' => 'control-label')) !!}\n" .
        "\t\t\t{!! Form::time('{{ field }}',NULL,['class'=>'form-control','id'=>'{{ field }}']) !!}\n" .
        "\t\t</div>",
    'timestamp' => " <div class='form-group'>\n" .
        "\t\t\t{!! Form::label('{{ field }}', '{{ title }}', array('class' => 'control-label')) !!}\n" .
        "\t\t\t{!! Form::timestamp('{{ field }}',NULL,['class'=>'form-control','id'=>'{{ field }}']) !!}\n" .
        "\t\t</div>",
    'radio'=> "<div class='form-group'>\n" .
        "\t\t\t{!! Form::label('{{ field }}', '{{ title }}', array('class' => 'control-label')) !!}<br>\n" .
        "\t\t\t{!! Form::radio('{{ field }}',NULL,['class'=>'form-control','id'=>'{{ field }}']) !!}\n" .
        "\t\t</div>",
    'datatable' => "{ data: '{{ field }}' , 'defaultContent':''},"
];

return [
    'view' => $template,
    'table' => $template['datatable'],
    'column_types' => [
        "id", "string", "text", "foreignId", "foreignUuid", "bigIncrements", "bigInteger", "json", "longText", "enum", "float", "binary", "boolean", "char", "dateTimeTz", "dateTime", "date",
        "decimal", "double", "foreignIdFor", "foreignUlid", "geometryCollection", "geometry", "increments", "integer", "ipAddress", "jsonb", "lineString", "macAddress", "mediumIncrements",
        "mediumInteger", "mediumText", "morphs", "multiLineString", "multiPoint", "multiPolygon", "nullableMorphs", "nullableTimestamps", "nullableUlidMorphs", "nullableUuidMorphs", "point",
        "polygon", "rememberToken", "set", "smallIncrements", "smallInteger", "softDeletesTz", "softDeletes", "timeTz", "time", "timestampTz", "timestamp", "timestampsTz", "timestamps",
        "tinyIncrements", "tinyInteger", "tinyText", "unsignedBigInteger", "unsignedDecimal", "unsignedInteger", "unsignedMediumInteger", "unsignedSmallInteger", "unsignedTinyInteger", "ulidMorphs",
        "uuidMorphs", "ulid", "uuid", "year",
    ]
];
