@extends('layout')
@section('content')
    <!-- Content here -->
    <form action="" class="row g-3" method="POST">
        @csrf
        <div class="mb-3">
            <label for="fullname" class="form-label">الإسم</label>
            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="الإسم">
            @error('fullname')
            <div id="fullname-error" class="form-text">
                {{ $message }}
            </div>
            @endError
        </div>
        <div class="mb-3">
            <label for="country" class="form-label">البلد\المدينة</label>
            <input type="text" class="form-control" id="country" name="country" placeholder="البلد\المدينة">
            @error('country')
            <div id="country-error" class="form-text">
                {{ $message }}
            </div>
            @endError
        </div>
        <div class="mb-3">
            <button class="btn btn-primary" type="submit">Generate</button>
        </div>
    </form>
@endSection
