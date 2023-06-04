@extends('errors.main')

@section('title', __($data["title"] ?? 'Forbidden'))
@section('code', $data["code"] ?? '403')
@section('message', __($data["message"] ?? 'Oops! You are not authorized to access this page.'))
