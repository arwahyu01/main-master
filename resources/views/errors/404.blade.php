@extends('errors.main')

@section('title', __($data["title"] ?? 'Not Found'))
@section('code', $data["code"] ?? '404')
@section('message', __($data["message"] ?? 'Oops! Page not found.'))
