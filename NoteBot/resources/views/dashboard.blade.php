@extends('layout/layout')
@section('content')
    <div class="modal fade" id="addbookmodal" tabindex="-1" aria-labelledby="addbooklabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addbooklabel">Add New Note Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('add-new-book') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="book_name">Book Name</label>
                            <input type="text" required name="book_name" id="book_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="book_name">Image</label>
                            <input type="file" name="book_image" id="book_image" class="form-control">
                        </div>
                        <button type="submit" class="theme-button">Save changes</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('partials/navbar')

    @include('partials/notification')
    <div class="container" id="searc">
        <input style="background:lightgray" type="text" placeholder="Search Book" class="form-control" id="search">
    </div>

    <script>
        $(document).ready(function () {
            $('#search').keyup(function () {
                
                var searchText = $(this).val().toLowerCase();



                $('.card-title').each(function () {
                    var cardTitle = $(this).text().toLowerCase();
                    if (cardTitle.includes(searchText)) {
                        $(this).closest('.card-deck').show();
                    } else {
                        $(this).closest('.card-deck').hide();
                    }
                });
            });
        });
    </script>

    <div style="display: flex;flex-wrap: wrap;gap: 50px;align-items: center;justify-content: center;margin: 55px;">



        <a href="#" data-toggle="modal" data-target="#addbookmodal">
            <div class="card-deck">
                <div class="card">
                    <div class="card-body"
                        style="height: 450px; border-radius: 30px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px;;">
                        <img src="{{ asset('uploads/plus.png') }}"
                            style="width:60px; border-radius:50% !important;    border: 2px solid white;" alt="">
                        <h4 class="card-subtitle mb-2 bold" style="color: #c0b7e8 !important;">New Note Book</h4>
                    </div>
                </div>
            </div>
        </a>

        @foreach ($books as $book)
            <a href="{{ route('view') }}?book={{ base64_encode($book->id) }}">

                <div class="card-deck">
                    <div class="card">
                        <img class="card-img-top" src="{{ $book->image ? $book->image : 'uploads/default.jpeg' }}"
                            alt="{{ $book->name }}">
                        <div class="card-body">
                            <h2 class="card-title bold mt-3" style="color: white !important;">{{ $book->name }}</h2>
                            <h4 class="card-subtitle mb-2 bold mt-3" style="color: #c0b7e8 !important; font-size:18px;">
                                {{ \Carbon\Carbon::parse($book->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a') }}
                                <br>
                                <small>{{ \Carbon\Carbon::parse($book->created_at)->diffForHumans() }}</small>
                            </h4>
                            <a href="#"
                                onclick="confirmDelete('{{ route('delete') }}?book={{ base64_encode($book->id) }}');"><button
                                    style="float: right;" type="button"
                                    class="btn btn-danger btn-small">Delete</button></a>

                            <script>
                                function confirmDelete(url) {
                                    if (confirm("Are you sure you want to delete this book? All data will be lost!")) {
                                        window.location.href = url;
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach


    </div>
@endsection
