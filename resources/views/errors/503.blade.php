@extends('errors.main')

@section('title', __($data["title"] ?? 'Service Unavailable'))
@section('code', $data["code"] ?? '503')
@section('message', __($data["message"] ?? 'Oops! Service unavailable.'))

