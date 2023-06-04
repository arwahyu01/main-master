@extends('errors::minimal')

@section('title', __($data["title"] ?? 'Unauthorized'))
@section('code', $data["code"] ?? '401')
@section('message', __($data["message"] ?? 'Oops! You are not authorized to access this page.'))
