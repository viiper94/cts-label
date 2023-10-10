@extends('layout.layout')

@section('title', 'ADE 2023 Event Guest List')

@section('content')

    <div class="event-header py-3">
        <div class="container py-5">
            <h1>ADE 2023 Event Guest List</h1>
        </div>
    </div>

    <div class="container event py-5">

        <div class="card bg-dark">
            <form method="post">
                @csrf
                <div class="card-header p-0">
                    <a href="https://www.amsterdam-dance-event.nl/en/program/2023/xcm-records-25-years/2164965" target="_blank">
                        <img src="/images/ade2023.jpg" alt="ADE 2023 XCM records 25 years" class="img-fluid">
                    </a>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Your Name*</label>
                        <input type="text" name="name" id="name" class="form-control form-dark" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" name="email" id="email" class="form-control form-dark">
                    </div>
                    <div class="form-group">
                        <label for="company" class="form-label">Company</label>
                        <input type="text" name="company" id="company" class="form-control form-dark">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-check me-2"></i>Submit</button>
                </div>
            </form>
        </div>

    </div>

@endsection
