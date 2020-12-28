<?php
/* @var string $picture_path */
?>
@extends('layout')
@section('content')
    <a class="btn btn-primary" href="/" role="button">Home page</a>
    <h1>Get & share the signed picture</h1>
    <img src="/{{$picture_path}}" class="img-fluid" alt="signed image">
@endSection
