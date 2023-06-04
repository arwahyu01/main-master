@extends('errors.main')

@section('title', __($data["title"] ?? 'Page Expired'))
@section('code', $data["code"] ?? '419')
@section('message', __($data["message"] ?? 'Oops! Page expired.'))
