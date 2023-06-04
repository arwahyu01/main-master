@extends('errors.main')

@section('title', __($data["title"] ?? 'Too Many Requests'))
@section('code', $data["code"] ?? '429')
@section('message', __($data["message"] ?? 'Oops! Too many requests.'))
