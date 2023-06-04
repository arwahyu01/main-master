@extends('errors.main')

@section('title', __($data["title"] ?? 'Server Error'))
@section('code', $data["code"] ?? '500')
@section('message', __($data["message"] ?? 'Oops! Something went wrong on our servers.'))
